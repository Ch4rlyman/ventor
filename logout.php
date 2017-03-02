<?php
/**
 * Eliminar todas la variables de Sessión y destruye la Sesión
 * @author Farly Minchán Lezcano
 * Date: 1/02/2017
 * Time: 5:11 PM
 */

session_start();
session_unset();
session_destroy();

header('Location: login.php');
?>
