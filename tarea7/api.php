<?php
require("repositorio.php");
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.

function get_lista_autores(){
  $repositorio = new Repositorio();
  return $repositorio->getAutores();
}

function get_datos_autor($id){
  $repositorio = new Repositorio();
  $info_autor = array(); 
  $info_autor["datos"] = $repositorio->getAutor($id);
  $info_autor["libros"] = $repositorio->getLibrosAutor($id);
  return $info_autor;
}

function get_lista_libros(){
  $repositorio = new Repositorio();
  return $repositorio->getLibros();
}

function get_datos_libro($id){
  $repositorio = new Repositorio();
  $info_libro = array(); 
  $info_libro["datos"] = $repositorio->getLibro($id);
  $info_libro["autores"] = $repositorio->getAutoresLibro($id);
  return $info_libro;
}

$posibles_URL = array("get_lista_autores", "get_datos_autor", "get_lista_libros", "get_datos_libro");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"])
    {
      case "get_lista_autores":
        $valor = get_lista_autores();
        break;
      case "get_datos_autor":
        if (isset($_GET["id"]))
            $valor = get_datos_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;
        case "get_lista_libros":
          $valor = get_lista_libros();
        break;
        case "get_datos_libro":
          if (isset($_GET["id"]))
            $valor = get_datos_libro($_GET["id"]);
          else
            $valor = "Argumento no encontrado";
        break;
    }
}

//devolvemos los datos serializados en JSON
exit(json_encode($valor));
?>
