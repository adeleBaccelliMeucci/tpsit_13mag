<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  //get di tutti
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //get con id
  public function view(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query('SELECT * FROM alunni WHERE id=' . $args["id"] .'');
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args){
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("INSERT INTO alunni (nome, cognome) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['nome'], $data['cognome']);
    $stmt->execute();

    $response->getBody()->write($data["nome"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function update(Request $request, Response $response, $args){
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("UPDATE alunni SET nome = ?, cognome = ? where id = ?");
    $stmt->bind_param("ssi", $data['nome'], $data['cognome'], $data['id']);
    $stmt->execute();

    $response->getBody()->write($data["nome"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

}
?>