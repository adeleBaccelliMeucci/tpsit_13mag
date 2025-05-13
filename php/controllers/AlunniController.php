<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController{


  //get di tutti
  public function index(Request $request, Response $response, $args){
    
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni"); //array asociativo
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

  public function create(Request $request, Response $response, $args){ //agiungo uno studente
    $data = json_decode($request->getBody()->getContents(), true); 
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("INSERT INTO alunni (nome, cognome) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['nome'], $data['cognome']);
    $stmt->execute();

    $response->getBody()->write($data["nome"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function update(Request $request, Response $response, $args){ //id?
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare("UPDATE alunni SET nome = ?, cognome = ? where id = ?");
    $stmt->bind_param("ssi", $data['nome'], $data['cognome'], $data['id']);
    $stmt->execute();

    $response->getBody()->write($data["nome"]);
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function destroy(Request $request, Response $response, $args){ //id
    $data = json_decode($request->getBody()->getContents(), true);
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $stmt = $mysqli_connection->prepare('DELETE FROM alunni WHERE id = ' . $args['id']);
    //$stmt->bind_param("i", $data['id']);
    $stmt->execute();

    $response->getBody()->write("");
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //get con almeno 3 lettere nome o cognome
  public function search(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query('SELECT * FROM alunni WHERE nome like "%' . $args["lettere"] .'%"' . 'OR cognome like "%' . $args["lettere"] .'%"');
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function sort(Request $request, Response $response, $args){
    /*
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("DESCRIBE alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    var_dump($results->fetch_all(MYSQLI_ASS));
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
    */

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $db = Db::getInstance();
    //$results = $mysqli_connection->query("DESCRIBE alunni");
    $results = $db->query("DESCRIBE alunni"); //
    //$results = $result->fetch_all(MYSQLI_ASSOC);

    $found = false;

    $columns = $results->fetch_all(MYSQLI_ASSOC);
    foreach ($columns as $col) {
      if($col['Field'] == $args["col"]) {
        $found = true;
        break;
      }
    }

    if(!$found){
      $response->getBody()->write(json_encode(["msg" => "colonna non trovata"]));
      return $response->withHeader("Content-type", "application/json")->withStatus(404);
    }
    /* */
    $order = isset($args["order"])?$args["order"]:"ASC";
    $result = $db->query("SELECT * FROM alunni ORDER BY " . $args["col"] . " $order");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);

  }
}
?>