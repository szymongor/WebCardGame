<?php
  require_once "Card.php";
  require_once "CardsDao.php";

  class CardsService{

    private $cardsDao;

    public function __construct(){
      $this->cardsDao = new CardsDao();
    }

    private function getCardsFile(){
      return $this->cardsDao->getCardsFile();
    }

    public function getCardById($cardId){
      $cards = $this->getCardsFile();
      $card = new Card($cards[$cardId]);
      return $card;
    }
  }

  // $cardsService = new CardsService();
  // $response = $cardsService->getCardById(1)->getEffects();
  // //echo(json_encode($response));
  //
  // for($i = 0 ; $i < count($response) ; $i++){
  //   echo($response[$i]['EffectName'].":".$response[$i]['EffectParam']."</br>");
  // }


?>
