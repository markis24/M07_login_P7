<?php
// Obtener el ID de usuario desde la consulta GET
$user_id = $_GET["user_id"];
$idioma_actual = isset($_COOKIE["idioma"]) ? $_COOKIE["idioma"] : 'cat';
$idioma_file = 'idioma_' . $idioma_actual . '.php';

if (file_exists($idioma_file)) {
    include($idioma_file);
} else {
    // Manejar el caso en el que el archivo de idioma no existe
    echo "Archivo de idioma no encontrado para el idioma '$idioma_actual'.";
}
// Incluir el archivo de configuración de la base de datos
include "dbConfig.php";

try {
    // Intentar establecer una conexión a la base de datos
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PSW, DB_NAME, DB_PORT);

    // Comprobar si la conexión a la base de datos fue exitosa
    if ($connect) {
        // Crear una consulta SQL para seleccionar un usuario con el ID proporcionado
        $query = "SELECT * FROM `user` WHERE user_id = '$user_id'";
        $resultado = mysqli_query($connect, $query);
    }

    if ($resultado) {
        // Obtener los datos del usuario y mostrarlos
        $user = mysqli_fetch_array($resultado);
        echo "<h2> $informacion_detallada_usuario </h2>";
        echo $id_usuario . ": " . $user['user_id'] . "<br>";
        echo $nombre_usuario . ": " . $user['name'] . "<br>";
        echo $apellido_usuario . ": " . $user['surname'] . "<br>";
        echo $email_usuario  .": " . $user['email'] . "<br>";
        echo $rol_usuario .": " . $user['rol'] . "<br>";
        
        // Comprobar si la casilla "active" fue marcada en el formulario
        if (isset($user['active'])) {
            $active = "Si";
        } else {
            $active = "No";
        }
        echo $actividad_usuario .": " . $active . "<br>";
    }
} catch (Exception $ex) {
    // Capturar excepciones y mostrar un mensaje de error personalizado en caso de que ocurra un error
    echo "Error: " . $ex->getMessage();
}
?>
<br>
<a href="loginUsuario.html"><?php echo $volver?></a>
