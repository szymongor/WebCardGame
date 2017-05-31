<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/DB/connect.php";

  class GamesDao{

    private $gamesFolder = "../../CurrentGamesFiles/";
    private $db_connect;

    public function __construct(){}

    private function startConnection(){
      global $host, $db_user, $db_password, $db_name;
      $this->db_connect = @new mysqli($host, $db_user, $db_password, $db_name);
      if ($this->db_connect->connect_error) {
        return false;
        //die("Connection failed: " . $this->db_connect->connect_error);
      }
      else{
        return true;
      }
    }

    public function getAllGames(){
      $this->startConnection();
      $queryStr = sprintf("SELECT * FROM `games`");
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$games = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $games;
    }

    public function getGameInfoById($gameId){
      $this->startConnection();
      $queryStr = sprintf("SELECT * FROM `games` WHERE id = \"%s\"",$gameId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$row = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $row;
    }

    public function getGameFileById($gameId){
      $gameFilePath = $this->gamesFolder.$gameId.".json";
      try{
        $gamesFile = @fopen($gameFilePath, "r");
        if (!$gamesFile) {
          throw new Exception('No such file');
        }
        $game = json_decode(fread($gamesFile,filesize($gameFilePath)),true);
      } catch(Exception $e){
        $game= null;
      }
      return $game;
    }

    public function createNewGame($gameID, $playerId){
      $gameInfo = $this->getGameInfoById($gameID);
      if($gameInfo == null){
        $this->addGameToDB($gameID);
        $this->setPlayerPlayingGame($playerId,$gameID);
        $gameFilePath = $this->gamesFolder."/".$gameID.".json";
        $gamesFile = fopen($gameFilePath, "w");
        $game = array('Message' => "Yo2");
        fwrite($gamesFile,json_encode($game));
        fclose($gamesFile);
      }
      else{
        throw new Exception("Game already exist");
      }
    }

    public function getPlayerGame($playerId){

    }

    private function addGameToDB($gameId){
      $this->startConnection();
    	$queryStr = sprintf("INSERT INTO `games`(`id`, `generationDate`) VALUES (\"%s\",%s)",$gameId,time());
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }

    public function setPlayerPlayingGame($playerId, $gameId){
      $this->startConnection();
    	$queryStr = sprintf("INSERT INTO `plays`(`user`, `game`) VALUES (%s,\"%s\")",$playerId,$gameId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }

    public function unsetPlayerPlayingGame($playerId){
      $this->startConnection();
    	$queryStr = sprintf("DELETE FROM `plays` WHERE user = %s",$playerId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }

    public function deleteGame($gameId){
      $this->unsetPlayingGame($gameId);
      $this->deleteGameInfo($gameId);
      $this->deleteGameFile($gameId);
    }

    public function unsetPlayingGame($gameId){
      $this->startConnection();
    	$queryStr = sprintf("DELETE FROM `plays` WHERE game = \"%s\"",$gameId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }

    private function deleteGameFile($gameId){
      $gameFilePath = $this->gamesFolder."/".$gameId.".json";
      if (file_exists($gameFilePath)) {
        unlink($gameFilePath);
      }
    }

    private function deleteGameInfo($gameId){
      $this->startConnection();
    	$queryStr = sprintf("DELETE FROM `games` WHERE id = \"%s\"",$gameId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }


  }

  $gamesDao = new GamesDao();
  //$gamesDao->unsetPlayerPlayingGame(1);
  //$gamesDao->createNewGame("myNewGame",1);
  $gamesDao->deleteGame("myNewGame");
  //$response = $gamesDao->getAllGames();
  //echo json_encode($response);

?>
