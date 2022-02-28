<html>
<style>
    body {
		background-image: url(pantano.jpg); 

	}
    a{
        font-size: 32px;
        font-family: Arial;
        text-decoration: none;
                padding: 5px;
        background-color: #000000;
        color: #ffffff;

    }
    p {
        width: 500px;
        font: normal 23px Arial;
        text-align: center;
       
    }

    menu {
        padding: 0px;
        display: inline-block;
        text-align: center;
    }

    li {

        list-style: none;
        padding: 10px;

    }


    li a:hover {
        background-color: #000000;
        color: #ffffff;
        margin-top: -5px;
        margin-left: 5px;
        margin-right: 5px;
        padding-bottom: 10px;
        font-size: 40px;
        font-family: arial;
    }
</style>

<body>

    <?php
    // Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
    if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_autor") {
        //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
        $app_info = file_get_contents('http://localhost/dwes/rest/api.php?action=get_datos_autor&id=' . $_GET["id"]);
        // Se decodifica el fichero JSON y se convierte a array
        $app_info = json_decode($app_info, true);
    ?>
        <p>
            <td>Nombre: </td>
            <td> <?php echo $app_info["datos"]["nombre"] ?></td>
        </p>
        <p>
            <td>Apellidos: </td>
            <td> <?php echo $app_info["datos"]["apellidos"] ?></td>
        </p>
        <p>
            <td>País de nacimiento: </td>
            <td> <?php echo $app_info["datos"]["nacionalidad"] ?></td>
        </p>
        <ul>
            <!-- Mostramos los libros del autor -->
            <?php foreach ($app_info["libros"] as $libro) : ?>
                <li>
                    <a href="<?php echo "http://localhost/dwes/rest/cliente.php?action=get_datos_libro&id=" . $libro["id"]  ?>">
                        <?php echo $libro["titulo"] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <br />
        <!-- Enlace para volver a la lista de autores -->
        <a href="http://localhost/dwes/rest/cliente.php?action=get_lista_autores" alt="Lista de autores">Volver a la lista de autores</a>
    <?php
    } else if (isset($_GET["action"]) && $_GET["action"] == "get_lista_libros") {
        //muestra la lista de libros
        // Pedimos al la api que nos devuelva una lista de libros. La respuesta se da en formato JSON
        $lista_libros = file_get_contents('http://localhost/dwes/rest/api.php?action=get_lista_libros');
        $lista_libros = json_decode($lista_libros, true);
    ?>
        <ul>
            <!-- Mostramos una entrada por cada uno de los libros -->
            <?php foreach ($lista_libros as $libros) : ?>
                <li>
                    <a href="<?php echo "http://localhost/dwes/rest/cliente.php?action=get_datos_libro&id=" . $libros["id"]  ?>">
                        <?php echo $libros["titulo"] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
    } else if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "get_datos_libro") {
        //muestra datos de un libro
        //Se realiza la peticion a la api que nos devuelve el JSON con la información de los libros
        $app_info = file_get_contents('http://localhost/dwes/rest/api.php?action=get_datos_libro&id=' . $_GET["id"]);
        // Se decodifica el fichero JSON y se convierte a array
        $app_info = json_decode($app_info, true);
    ?>
        <p>
            <td>Título: </td>
            <td> <?php echo $app_info["datos"]["titulo"] ?></td>
        </p>
        <p>
            <td>Fecha de publicación: </td>
            <td> <?php echo $app_info["datos"]["f_publicacion"] ?></td>
        </p>
        <p>
            <td>Autor: </td>
            <td> <a href="<?php echo "http://localhost/dwes/rest/cliente.php?action=get_datos_autor&id=" . $app_info["autores"]["id"]  ?>">
                    <?php echo $app_info["autores"]["nombre"] . " " . $app_info["autores"]["apellidos"] ?>
                </a></td>
        </p>
        <br />
        <!-- Enlace para volver a la lista de libros -->
        <a href="http://localhost/dwes/rest/cliente.php?action=get_lista_libros" alt="Lista de libros">Volver a la lista de libros</a>
    <?php
    } else //sino muestra la lista de autores
    {
        // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
        $lista_autores = file_get_contents('http://localhost/dwes/rest/api.php?action=get_lista_autores');
        $lista_autores = json_decode($lista_autores, true);
    ?>
        <ul>
            <!-- Mostramos una entrada por cada autor -->
            <?php foreach ($lista_autores as $autores) : ?>
                <li>
                    <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
                    <a href="<?php echo "http://localhost/dwes/rest/cliente.php?action=get_datos_autor&id=" . $autores["id"]  ?>">
                        <?php echo $autores["nombre"] . " " . $autores["apellidos"] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php
    } ?>
</body>

</html>