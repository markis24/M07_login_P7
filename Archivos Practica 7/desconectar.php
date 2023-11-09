<?php
// Inicia una sesión o reanuda la sesión actual si ya existe
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual
session_destroy();

// Redirige al usuario a la página de inicio de sesión (login.html)
header("Location: login.html");

?>