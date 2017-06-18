<?php

  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Games/GamesService.php";

  class MatchService{

    private $gamesService;
    private $gameState;

    public function __construct(){
      $this->gamesService = new GamesService();
    }

    private function getGameStateByPlayer($playerId){
      return $this->gamesService->getGameStateByPlayer($playerId);
    }

    public function getGameStateForPlayer($playerId){
      $game = $this->getGameStateByPlayer($playerId);
      return $game->getGameStateForPlayer($playerId);
    }

    public function playersMove($playerId, $cardsPositionInHand, $isDiscarded, $target){
      $this->gameState = $this->getGameStateByPlayer($playerId);
      $response = $this->gameState->playersMove($playerId, $cardsPositionInHand, $isDiscarded, $target);
      if($response['Status'] == 'Ok'){
        $gameId = $this->gamesService->getGameFileByPlayer($playerId)['GameId'];
        $this->gamesService->saveGameState($this->gameState, $gameId);
      }
      return $response;
    }

  }




?>
