<?php
// logout.php — Déconnexion sécurisée

session_start();
session_destroy();
header('Location: login.php');
exit;
