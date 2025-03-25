<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  //get di tutti
  public function index(Request $request, Response $response, $args){
    $result = include_once("./connection.php")->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //get con id
  public function view(Request $request, Response $response, $args){
    $result =include_once("./connection.php")->query('SELECT * FROM alunni WHERE id=' . $args["id"] .'');
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("INSERT INTO 'alunni' ('id', 'nome', 'cognome') VALUES ( '" . $args["id"] . "' , '" . $args["nome"] . "', '" . $args["cognome"] . "')");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }


}
?>