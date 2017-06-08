<?php

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


  }


?>
