<?php


  class CardsDao{

    private $cardsPath;


    public function __construct(){
      $this->cardsPath = $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/Engine/Card/Cards/Cards.json";
    }

    public function getCardsFile(){
      try{
        $cardsFile = @fopen($this->cardsPath, "r");
        if (!$cardsFile) {
          throw new Exception('No such file');
        }
        $cards = fread($cardsFile,filesize($this->cardsPath));
        //$game = $gameState->toArray();
      } catch(Exception $e){
        $cards = null;
      }
      return json_decode($cards,true);

    }

  }

  //$cardsDao = new CardsDao();
  //$response = $cardsDao->getCardsFile()[50];
  //echo(json_encode($response));



?>
