<?php
// includes/header.php
if(session_status() === PHP_SESSION_NONE) {
session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ECE CINÉ</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<main class="container">
