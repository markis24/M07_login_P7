<?php
session_start();

setcookie("idioma",$_GET["idioma"],time()+60*10);

header("Location: index.php");
?>