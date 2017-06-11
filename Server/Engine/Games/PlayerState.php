<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Card/CardsService.php";

  class PlayerState{

    private $tower;
    private $wall;

    private $quarry;
    private $bricks;

    private $magic;
    private $gems;

    private $dungeon;
    private $recruits;

    private $hand;

    public function __construct(){
      $this->tower = 10;
      $this->wall = 5;
      $this->quarry = 2;
      $this->bricks = 6;
      $this->magic = 2;
      $this->gems = 6;
      $this->dungeon = 2;
      $this->recruits = 6;
      $this->hand = array();
    }

    public function publicStateToArray(){
      $stateArray = array();
      $stateArray['Tower'] = $this->tower;
      $stateArray['Wall'] = $this->wall;
      $stateArray['Quarry'] = $this->quarry;
      $stateArray['Bricks'] = $this->bricks;
      $stateArray['Magic'] = $this->magic;
      $stateArray['Gems'] = $this->gems;
      $stateArray['Dungeon'] = $this->dungeon;
      $stateArray['Recruits'] = $this->recruits;
      return $stateArray;
    }

    public function toArray(){
      $stateArray = $this->publicStateToArray();
      $stateArray['Hand'] = $this->hand;
      return $stateArray;
    }

    public function fromArray($stateArray){
      $this->tower = $stateArray['Tower'];
      $this->wall = $stateArray['Wall'];
      $this->quarry = $stateArray['Quarry'];
      $this->bricks = $stateArray['Bricks'];
      $this->magic = $stateArray['Magic'];
      $this->gems = $stateArray['Gems'];
      $this->dungeon = $stateArray['Dungeon'];
      $this->recruits = $stateArray['Recruits'];
      $this->hand = $stateArray['Hand'];
    }

    public function addACard($cardsId){
      $this->hand[] = $cardsId;
    }

    public function getCardId($cardPositionInHand){
      return $this->hand[$cardPositionInHand];
    }

    public function chceckResources($type, $amount){
      switch($type){
        case "red":
          if($this->bricks >= $amount)
            return true;
          else
            return false;
        case "blue":
          if($this->gems >= $amount)
            return true;
          else
            return false;
        case "green":
          if($this->recruits >= $amount)
            return true;
          else
            return false;
      }
    }

    public function transferResource($type, $amount){
      switch($type){
        case "red":
          $this->bricks += $amount;
          if($this->bricks < 0) $this->bricks = 0;
          break;
        case "blue":
          $this->gems += $amount;
          if($this->gems < 0) $this->gems = 0;
          break;
        case "green":
          $this->recruits += $amount;
          if($this->recruits < 0) $this->recruits = 0;
          break;
      }
    }

  }


?>
