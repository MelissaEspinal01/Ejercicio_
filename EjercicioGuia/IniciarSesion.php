<?php
session_start();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $usuario = $_POST['Usuario'];
    $contraseña = $_POST['Contraseña'];

   
    if (validarCredenciales($usuario, $contraseña)) {
        
        $_SESSION['usuario'] = $usuario;
        header("Location: recetas.php");
        exit();
    } else {
        
        $error = "Credenciales incorrectas. Por favor, intenta nuevamente.";
        header("Location: index.php?error=" . urlencode($error));
        exit();
    }
} else {
    
    header("Location: index.php");
    exit();
}


function validarCredenciales($usuario, $contraseña) {
   
    $host = "localhost";
    $user = "Melissa"; 
    $pass = "1234"; 
    $db = "recetas"; 

    $conexion = mysqli_connect($host, $user, $pass, $db);

    if (!$conexion) {
       
        return false;
    }

    
    $usuario = mysqli_real_escape_string($conexion, $usuario);
    $contraseña = mysqli_real_escape_string($conexion, $contraseña);

    
    $query = "SELECT * FROM usuario WHERE Nombre = '$usuario' AND Contraseña = '$contraseña'";

    
    $result = mysqli_query($conexion, $query);

    
    if (mysqli_num_rows($result) === 1) {
       
        mysqli_close($conexion);
        return true;
    } else {
        
        mysqli_close($conexion);
        return false;
    }
}
?>

