<?php
session_start();
session_unset();
session_destroy();
header('Location: index.php'); // Redirection vers l'accueil après déconnexion
exit;
?>
