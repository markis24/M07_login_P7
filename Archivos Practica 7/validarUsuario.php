<?php
// Inicia o reanuda una sesión
session_start();

// Incluye el archivo de configuración de la base de datos
include "dbConfig.php";

try {
    // Intenta establecer una conexión a la base de datos
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PSW, DB_NAME, DB_PORT);

    // Comprueba si la conexión a la base de datos fue exitosa
    if ($connect) {
        // Obtiene el email y la contraseña del formulario de inicio de sesión
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Crea una consulta SQL para seleccionar un usuario con el email y contraseña proporcionados
        $query = "SELECT * FROM `user` WHERE email = '$email' AND password = '$password'";
        $resultado = mysqli_query($connect, $query);

        if ($resultado) {
            // Si la consulta se ejecuta correctamente
            $user = mysqli_fetch_array($resultado);

            // Establece variables de sesión para el usuario
            $_SESSION["LoggedIn"] = true;
            $_SESSION["name"] = $user['name'];
            $_SESSION["rol"] = $user['rol'];
            $_SESSION["user_id"] = $user['user_id'];

            // Redirige al usuario a la página 'index.php'
            header("Location: index.php");
        } else {
            // Si la consulta de usuario no tiene éxito, muestra un mensaje de error
            include 'login.html';
            echo "Login incorrecto";
        }
    } else {
        // Si la conexión a la base de datos no se estableció con éxito, lanza una excepción
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
} catch (Exception $ex) {
    // Captura excepciones y muestra un mensaje de error personalizado
    echo "Error: " . $ex->getMessage();
}
