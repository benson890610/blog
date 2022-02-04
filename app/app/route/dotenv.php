<?php 

$dotenv = Dotenv\Dotenv::createImmutable(dirname(dirname(__DIR__)));
$dotenv->load();
$dotenv->required(['DB_DRIVER', 'DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME']);
$dotenv->required('DB_PORT')->isInteger();
$dotenv->required('APP_ROOT')->notEmpty();
$dotenv->required('APP_SRC')->notEmpty();