<?php
$router = new AltoRouter;

$router->map('GET', '/about/', '', 'Manish');

$match = $router->match();





?>