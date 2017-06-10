<?php


  class Card{

    private $name;
    private $type;
    private $image;
    private $cost;
    private $action;
    private $effects;

    public function __construct($cardJSON){
      $cardObj = json_decode($cardJSON,true);
      $this->name = $cardObj['Name'];
      $this->type = $cardObj['Type'];
      $this->image = $cardObj['Image'];
      $this->cost = $cardObj['Cost'];
      $this->action = $cardObj['Action'];
      $this->effects = $cardObj['Effects'];
    }


  }



?>
