<?php

  require_once "PlayerState.php";

  class GameState{

    private $players;
    private $pending;
    private $turn;

    private $cardsDeck;
    private $playersState;

    public function __construct($gameStateJSON){
      $gamesStateObj = json_decode($gameStateJSON,true);
      $this->players = $gamesStateObj['Players'];
      $this->pending = $gamesStateObj['Pending'];
      $this->turn = $gamesStateObj['Turn'];
      if($this->pending == 0){
        $this->playersState = array();
        for($i = 0 ; $i < count($gamesStateObj['PlayersState']) ; $i++){
          $playerState = new PlayerState();
          $playerState->fromArray($gamesStateObj['PlayersState'][$i]);
          $this->playersState[] = $playerState;
        }
      }
    }

    public function toArray(){
      $gameArray = array();
      $gameArray['Players'] = $this->players;
      $gameArray['Pending'] = $this->pending;
      $gameArray['Turn'] = $this->turn;
      if($this->pending == 0){
        $gameArray['PlayersState'] = array();
        for($i = 0 ; $i < count($this->playersState) ; $i++){
          $gameArray['PlayersState'][] = $this->playersState[$i]->toArray();
        }
      }
      return $gameArray;
    }

    public function toString(){
      return json_encode($this->toArray());
    }

    public function addPlayer($playerId){
      $this->players[] = $playerId;
    }

    public function startGame(){
      $this->pending = 0;
      $this->playersState = array();
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->playersState[] = new PlayerState();
      }
    }

  }


?>
