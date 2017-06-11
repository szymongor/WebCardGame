<?php

  require_once "PlayerState.php";

  class GameState{

    private static $CARDS_NUMBER = 102;
    private static $CARDS_ON_HAND = 6;

    private $cardsService;

    private $players;
    private $pending;

    private $turn;
    private $cardsDeck;
    private $playersState;

    public function __construct($gameStateJSON){
      $cardsService = new CardsService();
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
      $this->shuffleCards();
      $this->dealCards();
    }

    private function shuffleCards(){
      $this->cardsDeck = range(0, self::$CARDS_NUMBER-1);
      shuffle($this->cardsDeck);
      return $this->cardsDeck;
    }

    private function dealCards(){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        for($j = 0 ; $j < self::$CARDS_ON_HAND ; $j++ ){
          $cardId = $this->drawACard();
          $this->playersState[$i]->addACard($cardId);
        }
      }
    }

    private function drawACard(){
      if(count($this->cardsDeck) == 0){
        $this->shuffleCards();
      }
      $cardId = $this->cardsDeck[count($this->cardsDeck)-1];
      unset($this->cardsDeck[count($this->cardsDeck)-1]);
      return $cardId;
    }

    private function getPlayerStateById($playerId){
      $index = array_search($playerId, $this->players);
      return $this->playersState[$index];
    }

    public function playersMove($playerId, $cardPositionInHand, $isDiscarded, $target){
      if($playerId != $this->turn){
        $response = array("Status" > "Error", "Message" => "Not your turn");
      }
      else{
        $playerState = $this->getPlayerStateById($playerId);
        $playedCardId = $playerState->getCardId($cardPositionInHand);
        $playedCard = $cardsService->getCardById($playedCardId);

        //to do - check players resources, act card effect, ..., draw new card.
      }
    }

    public function getStateForPlayer($playerId){
      $gameArray = array();
      $gameArray['Players'] = $this->players;
      $gameArray['Pending'] = $this->pending;
      $gameArray['Turn'] = $this->turn;
      if($this->pending == 0){
        $gameArray['PlayersState'] = array();
        for($i = 0 ; $i < count($this->playersState) ; $i++){
          if($this->players[$i] == $playerId)
          {
            $gameArray['PlayersState'][] = $this->playersState[$i]->toArray();
          }
          else{
            $gameArray['PlayersState'][] = $this->playersState[$i]->publicStateToArray();
          }
        }
      }
      return $gameArray;

    }

  }

  // $gameState = new GameState("{}");
  // for($i = 0 ; $i < 20 ; $i++){
  //   $response = $gameState->drawACard();
  //   echo(json_encode($response)."</br>");
  // }


?>
