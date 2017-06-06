<?php
  require_once "GamesDao.php";


  class GamesService{

    private $gamesDao;

    public function __construct(){
      $this->gamesDao = new GamesDao();
    }

    public function getAllPendingGames(){
      return $this->gamesDao->getAllPendingGames();
    }

    public function createNewGame($playerId, $gameId){
      try{
        $this->gamesDao->createNewGame($playerId, $gameId);
        $response = array("Status" => "Ok", "Message" => "Game successfully created");
      }
      catch(Exception $e){
        $response = array("Status" => "Error", "Message" => $e->getMessage());
      }
      return $response;
    }

    public function deleteGame($gameId){
      $this->gamesDao->deleteGame($gameId);
    }

    public function deleteGameByOwner($ownerId){
      return $this->gamesDao->deleteGameByOwner($ownerId);
    }

    public function getGameFileByPlayer($playerId){
        $gameFile = $this->gamesDao->getGameFileByPlayer($playerId);
        if($gameFile){
          $response = array("Status" => "Ok", "GameState" => $gameFile->toArray());
        }
        else{
          $response = array("Status" => "Error", "Message" => "No such game");
        }
        return $response;
    }

    public function setPlayerPlayingGame($playerId, $gameId){
      return $this->gamesDao->setPlayerPlayingGame($playerId, $gameId);
    }

  }

  //$gamesService = new GamesService();
  //$response = $gamesService->createNewGame(1, "myNewGame");
  //echo json_encode($response);



?>
