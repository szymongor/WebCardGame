<?php
  require_once "GamesDao.php";


  class GamesService{

    private $gamesDao;

    public function __construct(){
      $this->gamesDao = new GamesDao();
    }

    public function getAllGames(){
      return $this->gamesDao->getAllGames();
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


  }

  //$gamesService = new GamesService();
  //$response = $gamesService->createNewGame(1, "myNewGame");
  //echo json_encode($response);



?>
