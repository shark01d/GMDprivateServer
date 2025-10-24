<?php
require_once __DIR__ . '/config/servername.php';
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
echo $protocol . "://" . $publicservername
?>