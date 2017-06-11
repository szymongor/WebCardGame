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
        $game = $this->gamesDao->getGameFileByPlayer($playerId);
        if($game){
          $response = array("Status" => "Ok","GameId"=>$game['GameId'], "GameState" => $game['GameState']->toArray());
        }
        else{
          $response = array("Status" => "Error", "Message" => "No such game");
        }
        return $response;
    }

    public function setPlayerPlayingGame($playerId, $gameId){
      return $this->gamesDao->setPlayerPlayingGame($playerId, $gameId);
    }

    public function startGameByOwner($ownerId){
      return $this->gamesDao->startGameByOwner($ownerId);
    }

    public function getStateForPlayer($playerId){
      $game = $this->gamesDao->getGameFileByPlayer($playerId)['GameState'];
      return $game->getStateForPlayer($playerId);
    }

  }

  //$gamesService = new GamesService();
  //$response = $gamesService->createNewGame(1, "myNewGame");
  //echo json_encode($response);



?>
