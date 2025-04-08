<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/includes/Db.php';

$app = AppFactory::create();

//curl http://localhost:8080/alunni
$app->get('/alunni', "AlunniController:index");
//curl http://localhost:8080/alunni/2
$app->get('/alunni/{id:\d+}', "AlunniController:view");
//curl -X POST http://localhost:8080/alunni -d '{"nome":"petro", "" }' -H "Content-Type: application/json"
$app->post('/alunni', "AlunniController:create");
$app->put('/alunni', "AlunniController:update"); //id?
// curl -X delete ...
$app->delete('/alunni', "AlunniController:destroy"); //id?

$app->get('/alunni/search/{lettere:\w+}', "AlunniController:search"); //ricerca


$app->get('/alunni/sort/{col}[/{order:asc|desc}]', "AlunniController:sort"); //[/{order:asc|desc}] rotta con parametro opsionale, funziona anche senza


$app->run();
?>