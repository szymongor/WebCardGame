<?php


  class Card{

    private $title;
    private $type;
    private $image;
    private $cost;
    private $action;
    private $effects;
    private $json;

    public function __construct($cardJSON){
      //$cardObj = json_decode($cardJSON,true);
      $this->json = $cardJSON;
      $this->title = $cardJSON['Title'];
      $this->type = $cardJSON['Type'];
      $this->image = $cardJSON['Image'];
      $this->cost = $cardJSON['Cost'];
      $this->action = $cardJSON['Action'];
      if(isset($cardJSON['Effects'])){
        $this->effects = $cardJSON['Effects'];
      }

    }

    public function toJson(){
      return $this->json;
    }

    public function getCost(){
      return $this->cost;
    }

    public function getType(){
      return $this->type;
    }

    public function getEffects(){
      return $this->effects;
    }


  }



?>
