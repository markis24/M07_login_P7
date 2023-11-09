<?php
// Incluye el archivo de idioma antes de iniciar la sesión
$idioma_actual = isset($_COOKIE["idioma"]) ? $_COOKIE["idioma"] : 'cat';
$idioma_file = 'idioma_' . $idioma_actual . '.php';

if (file_exists($idioma_file)) {
    include($idioma_file);
} else {
    // Manejar el caso en el que el archivo de idioma no existe
    echo "Archivo de idioma no encontrado para el idioma '$idioma_actual'.";
}

// Inicia o reanuda una sesión existente
session_start();

// Asegúrate de que $_SESSION["rol"] esté definido antes de usarlo
if (!isset($_SESSION["rol"])) {
    // Maneja el caso en el que $_SESSION["rol"] no está definido
    echo "Error: Rol no ha sido definido.";
    exit;
}

// Verifica el rol del usuario en la sesión
if ($_SESSION["rol"] == 'alumnat') {
    // Usuario con rol "alumnat"
    echo "<h2>" . $saludo . " " . $_SESSION["name"] . $usuario_alumno . "</h2>";
?>
    <a href="idioma.php?idioma=cat">Cat</a>
    <a href="idioma.php?idioma=esp">Esp</a>
    <a href="idioma.php?idioma=ing">Ing</a>

    <a href="mostrarUsuario.php?user_id=<?php echo $_SESSION["user_id"]; ?>"><?php echo $mostrar_info_usuario; ?></a>
    <a href="desconectar.php"><?php echo $desconexion_usuario; ?></a><br>
<?php
} elseif ($_SESSION["rol"] == 'professorat') {
    // Usuario con rol "professorat"
    echo "<h2>" . $saludo . " " . $_SESSION["name"] . $usuario_profesor . "</h2>";
?>
    <a href="idioma.php?idioma=cat">Cat</a>
    <a href="idioma.php?idioma=esp">Esp</a>
    <a href="idioma.php?idioma=ing">Ing</a>
    <a href="mostrarUsuario.php?user_id=<?php echo $_SESSION["user_id"]; ?>"><?php echo $mostrar_info_usuario; ?></a>
    <a href="desconectar.php"><?php echo $desconexion_usuario; ?></a>
    <br>
    <br>
<?php
    echo '<table>
        <tr>
            <th>' . $nombre_usuarios . '</th>
            <th>' . $apellido_usuarios . '</th>
            <th>' . $email_usuarios . '</th>
        </tr>';
    include("dbConfig.php");
    // Establece una conexión con la base de datos utilizando las constantes definidas
    $connect = mysqli_connect(DB_HOST, DB_USER, DB_PSW, DB_NAME, DB_PORT);

    // Comprueba si la conexión a la base de datos fue exitosa
    if (!$connect) {
        echo "Error de conexión: " . mysqli_connect_error();
    } else {
        // Consulta para seleccionar todos los usuarios de la tabla "user"
        $query = "SELECT * FROM user";
        $resultado_usuarios = mysqli_query($connect, $query);

        // Recorre los resultados y muestra los datos en una tabla
        foreach ($resultado_usuarios as $usuario) {
            echo '<tr>
                <td>' . $usuario['name'] . '</td>
                <td>' . $usuario['surname'] . '</td>
                <td>' . $usuario['email'] . '</td>
            </tr>';
        }
        echo '</table>';
    }
}
?>