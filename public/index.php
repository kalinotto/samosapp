<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require 'db.php';

$app = new \Slim\App;
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/register', function (Request $request, Response $response) {
//    $uname = $request->getQueryParam('uname');
//    $pword = $request->getQueryParam('pass');

    $sql = "INSERT INTO users (name, phash, email) VALUES ('kalin', '123', 'kalin@mail.com')";
    
    $db = getDB();
    $db->query($sql);
});
$app->run();

?>