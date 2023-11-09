<?php
// Incluye el archivo de configuración de la base de datos
include "dbConfig.php";

try {
    // Intenta establecer una conexión con la base de datos utilizando las constantes definidas
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PSW, DB_NAME, DB_PORT);

    // Comprueba si la conexión a la base de datos fue exitosa
    if (!$connect) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    } else {
        // La conexión a la base de datos fue exitosa
        echo "Conexión establecida correctamente";

        // Obtiene los datos del formulario enviado mediante el método POST
        $user_id = $_POST["user_id"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $rol = $_POST["rol"];

        // Comprueba si la casilla "active" fue marcada en el formulario y asigna 1 o 0
        if (isset($_POST["active"])) {
            $active = 1;
        } else {
            $active = 0;
        }

        // Crea la consulta SQL para insertar los datos en la tabla 'user'
        $query = "INSERT INTO user (user_id, name, surname, password, email, rol, active)
        VALUES ('$user_id', '$name', '$surname', '$password', '$email', '$rol', '$active')";

        // Ejecuta la consulta de inserción en la base de datos
        if (mysqli_query($connect, $query)) {
            // Redirige a la página 'mostrar.php' si la inserción fue exitosa
            header('Location: respuesta.php');
        } else {
            // Muestra un mensaje de error si la inserción falla
            throw new Exception("Error al insertar datos: " . mysqli_error($connect));
        }
    }
} catch (Exception $ex) {
    // Captura excepciones y muestra un mensaje de error personalizado en caso de problemas
    echo "Error: " . $ex->getMessage();
}

// Cierra la conexión a la base de datos si estaba abierta
if (isset($connect)) {
    mysqli_close($connect);
}
