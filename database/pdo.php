<?php
$_user = 'dhruval';
$_password = 'serviceAdept';

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=service_adept', $_user, $_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
