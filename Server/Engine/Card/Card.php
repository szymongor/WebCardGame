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
      //$this->effects = $cardObj['Effects'];
    }

    public function toJson(){
      return $this->json;
    }


  }



?>
