<?php

  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Games/GamesService.php";

  class MatchService{

    private $gamesService;
    private $gameState;

    public function __construct(){
      $this->gamesService = new GamesService();
    }

    private function getGameStateByPlayer($playerId){
      return $this->getGameStateByPlayer($playerId);
    }

    public function getStateForPlayer($playerId){
      $game = $this->gamesService->getGameStateByPlayer($playerId);
      return $game->getStateForPlayer($playerId);
    }

  }




?>
