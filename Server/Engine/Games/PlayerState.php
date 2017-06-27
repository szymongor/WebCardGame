<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Card/CardsService.php";

  class PlayerState{

    private static $CARDS_ON_HAND = 6;

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

    public function discardACard($cardPosition){
      unset($this->hand[$cardPosition]);
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

    public function getWall(){
      return $this->wall;
    }

    public function setWall($newWall){
      $this->wall = $newWall;
    }

    public function getMagic(){
      return $this->magic;
    }

    public function setMagic($newMagic){
      $this->magic = $newMagic;
    }

    public function getGems(){
      return $this->gems;
    }

    public function getBricks(){
      return $this->bricks;
    }

    public function beginTurn(){
      $this->bricks += $this->quarry;
      $this->gems += $this->magic;
      $this->recruits += $this->dungeon;
    }
    //Cards effects:

    public function addWallPoints($amount){
      $this->wall += $amount;
      $passDamage = 0;
      if($this->wall < 0){
        $passDamage = $this->wall;
        $this->wall = 0;
      }
      return $passDamage;
    }

    public function addTowerPoints($amount){
      $this->tower += $amount;
      if($this->tower < 0){
        $this->tower = 0;
      }
    }

    public function dealDamage($amount){
      $passDamage = $this->addWallPoints(-$amount);
      $this->tower -= $passDamage;
    }

    public function addQuarry($amount){
      $this->quarry += $amount;
      if($this->quarry < 0){
        $this->quarry = 0;
      }
    }

    public function addBricks($amount){
      $this->bricks += $amount;
      if($this->bricks < 0){
        $this->bricks = 0;
      }
    }

    public function addMagic($amount){
      $this->magic += $amount;
      if($this->magic < 0){
        $this->magic = 0;
      }
    }

    public function addGems($amount){
      $this->gems += $amount;
      if($this->gems < 0){
        $this->bricks = 0;
      }
    }

    public function addDungeon($amount){
      $this->dungeon += $amount;
      if($this->dungeon < 0){
        $this->bricks = 0;
      }
    }

    public function addRecruits($amount){
      $this->recruits += $amount;
      if($this->recruits < 0){
        $this->bricks = 0;
      }
    }

  }


?>
