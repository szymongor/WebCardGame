<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/DB/connect.php";
  require_once "GamesUtils.php";
  require_once "GameState.php";

  class GamesDao{


    private $gamesUtils;
    private $gamesFolder;
    private $db_connect;

    public function __construct(){
      $this->gamesFolder = $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/CurrentGamesFiles/";
      $this->gamesUtils = new GamesUtils();
    }

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

    public function getAllPendingGames(){
      $this->startConnection();
      $queryStr = sprintf("SELECT * FROM `games` WHERE pending = 1");
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

    public function getGameInfoByOwner($ownerId){
      $this->startConnection();
      $queryStr = sprintf("SELECT * FROM `games` WHERE userOwner = %s",$ownerId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$row = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $row;
    }

    public function getGameInfoByPlayer($playerId){
      $this->startConnection();
      $queryStr = sprintf("SELECT * FROM `games` WHERE id = (SELECT game FROM plays WHERE user = %s)",$playerId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$row = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      return $row;
    }

    public function getGameFileByPlayer($playerId){
      $gameInfo = $this->getGameInfoByPlayer($playerId);
      if(isset($gameInfo['id'])){
        return $this->getGameFileById($gameInfo['id']);
      }
      else{
        return null;
      }
    }

    public function getGameFileById($gameId){
      $gameFilePath = $this->gamesFolder.$gameId.".json";
      try{
        $gamesFile = @fopen($gameFilePath, "r");
        if (!$gamesFile) {
          throw new Exception('No such file');
        }
        $gameState = new GameState(fread($gamesFile,filesize($gameFilePath)));
        $game = $gameState->toArray();
      } catch(Exception $e){
        $game= null;
      }
      return $game;
    }

    public function createNewGame($playerId, $gameID){
      $gameInfo = $this->getGameInfoById($gameID);
      if($gameInfo != null){
        throw new Exception("Game already exist");
      }
      $playerGames = $this->getPlayerGameId($playerId);
      if($playerGames != null){
        throw new Exception("You are already assigned to the game");
      }
      $this->addGameToDB($playerId,$gameID);
      $this->setPlayerPlayingGame($playerId,$gameID);
      $this->createNewGameFile($playerId, $gameID);
    }

    private function createNewGameFile($playerId, $gameID){
      $gameFilePath = $this->gamesFolder.$gameID.".json";
      $gamesFile = fopen($gameFilePath, "w");
      $game = $this->gamesUtils->newGameJson($playerId);
      fwrite($gamesFile,json_encode($game));
      fclose($gamesFile);
    }

    public function getPlayerGameId($playerId){
      $this->startConnection();
      $queryStr = sprintf("SELECT * FROM `plays` WHERE user = %s",$playerId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
    	$game = $result->fetch_assoc();
      mysqli_close($this->db_connect);
      if($game != null){
        return $game['game'];
      }
      else{
        return null;
      }

    }

    private function addGameToDB($ownerId, $gameId){
      $this->startConnection();
    	$queryStr = sprintf("INSERT INTO `games`(`id`, `generationDate`, `userOwner`) VALUES (\"%s\",%s,%s)",$gameId,time(),$ownerId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new Exception("Database Error [{$this->db_connect->errno}] {$this->db_connect->error}");
      }
      mysqli_close($this->db_connect);
    }

    public function setPlayerPlayingGame($playerId, $gameId){
      try{
        $gameInfo = $this->getGameInfoById($gameId);
        if($gameInfo == null){
          $response = array('Status'=>'Error', 'Message' => 'No such game');
        }
        else if($gameInfo['pending'] == 0){
          $response = array('Status'=>'Error', 'Message' => 'You can not join the game during the match');
        }
        else{
          $this->setPlayerPlayingGameInfo($playerId, $gameId);
          $this->setPlayerPlayingGameFile($playerId, $gameId);
          $response = array('Status'=>'Ok', 'Message' => 'You are assigned to the game: '.$gameId);
        }  
      }
      catch(PlayerAlreadyAssignedException $e){
        $response = array('Status'=>'Error', 'Message' => 'You are already assigned to the game');
      }
      return $response;
    }

    private function setPlayerPlayingGameInfo($playerId, $gameId){
      $this->startConnection();
    	$queryStr = sprintf("INSERT INTO `plays`(`user`, `game`) VALUES (%s,\"%s\")",$playerId,$gameId);
    	$result = @$this->db_connect->query($queryStr);
      if (!$result) {
          throw new PlayerAlreadyAssignedException("");
      }
      mysqli_close($this->db_connect);
    }

    private function setPlayerPlayingGameFile($playerId, $gameId){

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

    public function deleteGameByOwner($ownerId){
      $game = $this->getGameInfoByOwner($ownerId);
      if(isset($game['id'])){
        $this->deleteGame($game['id']);
        $response = array('Status' => 'Ok', 'Message' => "Game successfully deleted");
      }
      else{
        $response = array('Status' => 'Error', 'Message' => "No such game");
      }
      return $response;

    }

    private function unsetPlayingGame($gameId){
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

  class PlayerAlreadyAssignedException extends Exception { }

  //$gamesDao = new GamesDao();
  //$gamesDao->unsetPlayerPlayingGame(1);
  //$gamesDao->createNewGame("myNewGame",1);
  //$gamesDao->deleteGame("myNewGame");
  //$response = $gamesDao->getPlayerGameId(1);
  //echo json_encode($response);

?>
