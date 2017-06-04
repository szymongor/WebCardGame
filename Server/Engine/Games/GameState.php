<?php


  class GameState{

    private $players;
    private $pending;
    private $turn;

    public function __construct($gameStateJSON){
      $gamesStateObj = json_decode($gameStateJSON,true);
      $this->players = $gamesStateObj['Players'];
      $this->pending = $gamesStateObj['Pending'];
      $this->turn = $gamesStateObj['Turn'];
    }

    public function toArray(){
      $gameArray = array();
      $gameArray['Players'] = $this->players;
      $gameArray['Pending'] = $this->pending;
      $gameArray['Turn'] = $this->turn;
      return $gameArray;
    }

    public function toString(){
      return json_encode($this->toArray());
    }

    public function addPlayer($playerId){
      $this->players[] = $playerId;
    }


  }


?>
