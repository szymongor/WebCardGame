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
      $gameState = $this->getGameStateByPlayer($playerId);
      $response = $gameState->playersMove($playerId, $cardsPositionInHand, $isDiscarded, $target);
      return $response;
    }

  }




?>
