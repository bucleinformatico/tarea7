<?php

/* Clase para la interacción con la DB*/
class Repositorio {

    // Método de conexión
    private function conexion() {

        //Datos xampp
        $BBDD="tarea7";
        $usuario="root";
        $pass="";
        $loc="localhost";
	
        $mysqli = new mysqli($loc, $usuario, $pass, $BBDD);
        if (mysqli_connect_errno())
        {	
            echo "Error de conexión con la BBDD: $BBDD. " . mysqli_connect_error();
            die("Pruebe de nuevo más tarde.");
        }

        return $mysqli;
    }

    //Método de desconexión
    private function desconexion($conexion) {
        $conexion->close();
    }

    //Método que obtiene todos los autores
    public function getAutores() {
        $db = $this->conexion();

        $stmt = $db->prepare("SELECT * FROM autor");
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        $autores = $resultado->fetch_all(MYSQLI_ASSOC);

        $resultado->close();
        $stmt->close();
        $db = $this->desconexion($db);
        $db = null;

        return $autores;
    }

    //Método que obtiene todos los autores de un libro
    public function getAutoresLibro($id) {
        $db = $this->conexion();

        $stmt = $db->prepare("SELECT a.nombre, a.apellidos, a.id FROM autor a LEFT JOIN libro l ON a.id = l.id_autor WHERE l.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        $libros = $resultado->fetch_array(MYSQLI_ASSOC);
        $resultado->close();
        $stmt->close();

        $db = $this->desconexion($db);
        $db = null;

        return $libros;
    }

    //Método que obtiene los datos de un autor en concreto
    public function getAutor($id) {
        $db = $this->conexion();

        $stmt = $db->prepare("SELECT nombre, apellidos, nacionalidad FROM autor WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        $autor = $resultado->fetch_array(MYSQLI_ASSOC);
        $resultado->close();
        $stmt->close();
        
        $db = $this->desconexion($db);
        $db = null;

        return $autor;
    }

    //Método que obtiene la lista de libros de un autor.
    public function getLibrosAutor($id) {
        $db = $this->conexion();

        $stmt = $db->prepare("SELECT * FROM libro WHERE id_autor = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        $libros = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->close();
        $stmt->close();

        $db = $this->desconexion($db);
        $db = null;

        return $libros;
    }

    //Método que obtiene la lista de libros
    public function getLibros() {
        $db = $this->conexion();

        $stmt = $db->prepare("SELECT id, titulo FROM libro");
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        $libros = $resultado->fetch_all(MYSQLI_ASSOC);
        $resultado->close();
        $stmt->close();

        $db = $this->desconexion($db);
        $db = null;

        return $libros;
    }

    //Método que obtiene los datos de un libro
    public function getLibro($id) {
        $db = $this->conexion();

        $stmt = $db->prepare("SELECT * FROM libro WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $resultado = $stmt->get_result();
        $libro = $resultado->fetch_array(MYSQLI_ASSOC);
        $resultado->close();
        $stmt->close();
        
        $db = $this->desconexion($db);
        $db = null;

        return $libro;
    }

}

?>