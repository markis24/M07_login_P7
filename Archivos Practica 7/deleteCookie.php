<?php
session_start();

setcookie("idioma_actual",time()-1);

header("Location: login.html");

?>