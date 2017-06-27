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
      $this->cardsService = new CardsService();
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

    public function getGameStateForPlayer($playerId){
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

    private function currentTurnPlayerId(){
      return $this->players[$this->turn];
    }

    private function checkTurn($playerIdToCheck){
      if($this->currentTurnPlayerId() == $playerIdToCheck){
        return true;
      }
      else{
        return false;
      }
    }

    private function startNextTurn(){
      $this->turn++;
      if($this->turn >= Count($this->players)){
        $this->turn = 0;
      }

      $card = $this->drawACard();
      $this->playersState[$this->turn]->addACard($card);
      $this->playersState[$this->turn]->beginTurn($card);

    }

    public function playersMove($playerId, $cardPositionInHand, $isDiscarded, $target){
      if(!$this->checkTurn($playerId)){
        $response = array("Status" => "Error", "Message" => "Not your turn");
      }
      else{
        $playerState = $this->getPlayerStateById($playerId);
        $playedCardId = $playerState->getCardId($cardPositionInHand);
        $playedCard = $this->cardsService->getCardById($playedCardId);
        if($isDiscarded){
          $response = array("Status" => "Ok", "Message" => "Done", "GameState" => $this->getGameStateForPlayer($playerId));
          $playerState->discardACard($cardPositionInHand);
          $this->startNextTurn();
        }
        elseif($playerState->chceckResources($playedCard->getType(),$playedCard->getCost())){
          $this->actCardEffects($playedCard, $target);
          $playerState->discardACard($cardPositionInHand);
          $this->startNextTurn();
          $response = array("Status" => "Ok", "Message" => "Done", "GameState" => $this->getGameStateForPlayer($playerId));
        }
        else{
          $response = array("Status" => "Error", "Message" => "You dont have enough resources");
        }
      //to do - act card effect, ..., discard and draw new card.
      }
      return $response;
    }

    //Cards effect:

    public function addPlayerWall($amount, $target){
      $this->playersState[$target]->addWallPoints($amount);
    }

    public function addPlayerTower($amount, $target){
      $this->playersState[$target]->addTowerPoints($amount);
    }

    public function dealDamageToPlayer($amount, $target){
      $this->playersState[$target]->dealDamage($amount);
    }

    public function addPlayerQuarry($amount, $target){
      $this->playersState[$target]->addQuarry($amount);
    }

    public function addPlayerBricks($amount, $target){
      $this->playersState[$target]->addBricks($amount);
    }

    public function addPlayerMagic($amount, $target){
      $this->playersState[$target]->addMagic($amount);
    }

    public function addPlayerGems($amount, $target){
      $this->playersState[$target]->addGems($amount);
    }

    public function addPlayerDungeon($amount, $target){
      $this->playersState[$target]->addDungeon($amount);
    }

    public function addPlayerRecruits($amount, $target){
      $this->playersState[$target]->addRecruits($amount);
    }

    public function wallsShift($target){
      $currentPlayerWall = $this->playersState[$this->players[$this->turn]]->getWall();
      $targetPlayerWall = $this->playersState[$target]->getWall();
      $this->playersState[$this->players[$this->turn]]->setWall($targetPlayerWall);
      $this->playersState[$target]->setWall($currentPlayerWall);
    }

    public function magicParity(){
      $bestMagic = 0;
      for($i = 0 ; $i < count($this->players) ; $i++){
        $magicScore = $this->playersState[$i]->getMagic();
        if($bestMagic < $magicScore ){
          $bestMagic = $magicScore;
        }
      }
      for($i = 0 ; $i < count($this->players) ; $i++){
        $magicScore = $this->playersState[$i]->setMagic($bestMagic);
      }
    }

    public function thief($target){
      $targetGems = $this->playersState[$target]->getGems();
      $targetBricks = $this->playersState[$target]->getBricks();

      $stolenGems = $targetGems;
      $stolenBricks = $targetBricks;

      if($stolenGems > 10){
        $stolenGems = 10;
      }

      if($stolenBricks > 5){
        $stolenBricks = 5;
      }

      $this->playersState[$target]->addGems(-10);
      $this->playersState[$target]->addBricks(-5);

      $this->playersState[$this->players[$this->turn]]->addGems($stolenGems/2);
      $this->playersState[$this->players[$this->turn]]->addBricks($stolenBricks/2);
    }

    public function floodWater(){
      $lowestWall = $this->playersState[0]->getWall();
      for($i = 0 ; $i < count($this->players) ; $i++){
        $wall = $this->playersState[$target]->getWall();
        if($lowestWall > $wall ){
          $lowestWall = $wall;
        }
      }
      for($i = 0 ; $i < count($this->players) ; $i++){
        $wall = $this->playersState[$target]->getWall();
        if($lowestWall == $wall ){
          $this->playersState[$i]->addDungeon(-1);
          $this->playersState[$i]->addTowerPoints(-2);
        }
      }
    }

    //

    public function actCardEffects($card, $target){
      $cardEffects = $card->getEffects();
      for($i = 0 ; $i < count($cardEffects) ; $i++){
        $this->actCardEffect($cardEffects[$i],$target);
      }
    }

    private function actCardEffect($cardEffect, $target){
      switch($cardEffect['EffectName']){
        case "AddAllPlayersBricks":
          $this->addAllPlayersBricks($cardEffect['EffectParam']);
          break;
        case "AddBricks":
          $this->addPlayerBricks($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddEnemyBricks":
          $this->addPlayerBricks($cardEffect['EffectParam'],$target);
          break;
        case "AddAllPlayersGems":
          $this->AddAllPlayersGems($cardEffect['EffectParam']);
          break;
        case "AddGems":
          $this->addPlayerGems($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddAllPlayerWalls":
          $this->addAllPlayerWalls($cardEffect['EffectParam']);
          break;
        case "AddWall":
          $this->addPlayerWall($cardEffect['EffectParam'],$this->turn);
          break;
        case "SwitchWall":
          $this->wallsShift($target);
        case "AddAllPlayerQuarrys":
          $this->addAllPlayerQuarries($cardEffect['EffectParam']);
          break;
        case "AddQuarry":
          $this->addPlayerQuarry($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddEnemyQuarry":
          $this->addPlayerQuarry($cardEffect['EffectParam'],$target);
          break;
        case "AddAllPlayersMagic":
          $this->addAllPlayersMagic($cardEffect['EffectParam']);
          break;
        case "AddMagic":
          $this->addPlayerMagic($cardEffect['EffectParam'],$this->turn);
          break;
        case "AllMagicTheHighestMagic":
          $this->magicParity();
          break;
        case "AddAllPlayersDungeon":
          $this->addAllPlayersDungeon($cardEffect['EffectParam']);
          break;
        case "AddDungeon":
          $this->addPlayerDungeon($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddEnemyDungeon":
          $this->addPlayerDungeon($cardEffect['EffectParam'],$target);
          break;
        case "AddAllPlayersTowers":
          $this->addAllPlayersTowers($cardEffect['EffectParam']);
          break;
        case "AddTower":
          $this->addPlayerTower($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddAllEnemyTowers":
          $this->addAllEnemyTowers($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddEnemyTower":
          $this->addPlayerTower($cardEffect['EffectParam'],$target);
          break;
        case "AddAllPlayersRecruits":
          $this->addAllPlayersRecruits($cardEffect['EffectParam']);
          break;
        case "AddRecruits":
          $this->addPlayerRecruits($cardEffect['EffectParam'],$this->turn);
          break;
        case "AddEnemyRecruits":
          $this->addPlayerRecruits($cardEffect['EffectParam'],$target);
          break;
        case "AddCard":
          $this->addCards($cardEffect['EffectParam'],$this->turn);
          break;
        case "FloodWater":
          $this->floodWater();
          break;
        case "DealDamage":
          $this->dealDamageToPlayer($cardEffect['EffectParam'],$target);
          break;
        case "DealDamageToAllEnemies":
          $this->dealDamageToAllEnemies($cardEffect['EffectParam'],$this->turn);
          break;
        case "TakeDamage":
          $this->dealDamageToPlayer($cardEffect['EffectParam'],$this->turn);
          break;
        case "Thief":
          $this->thief($target);
          break;
        case "PlayAgain":
          break;
        default:
          echo($cardEffect['EffectName']);
          break;
      }
    }

    private function addCards($amount,$target){
      if($amount>0){
        for($i = 0 ; $i < amount ; $i++){
          $cardId = $this->drawACard();
          $this->playersState[$target]->addACard($cardId);
        }
      }
      // else {
      //   amount = amount * (-1);
      //   for($i = 0 ; $i < amount ; $i++){
      //     $playerState->discardACard(??positionInHand);
      //   }
      // }
    }

    private function addAllPlayersBricks($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerBricks($amount, $i);
      }
    }

    private function addAllPlayerQuarries($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerQuarry($amount, $i);
      }
    }

    private function addAllPlayersGems($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerGems($amount, $i);
      }
    }

    private function addAllPlayerWalls($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerWall($amount, $i);
      }
    }

    private function addAllPlayersMagic($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerMagic($amount, $i);
      }
    }

    private function addAllPlayersDungeon($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerDungeon($amount, $i);
      }
    }

    private function addAllPlayersTowers($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerTower($amount, $i);
      }
    }

    private function addAllEnemyTowers($amount,$currentPlayer){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        if($i!=$currentPlayer){
            $this->addPlayerTower($amount, $i);
        }
      }
    }

    private function addAllPlayersRecruits($amount){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        $this->addPlayerRecruits($amount, $i);
      }
    }

    private function dealDamageToAllEnemies($amount,$currentPlayer){
      for($i = 0 ; $i < count($this->players) ; $i++ ){
        if($i!=$currentPlayer){
            $this->dealDamageToPlayer($amount, $i);
        }
      }
    }

  }

  // $gameState = new GameState("{}");
  // for($i = 0 ; $i < 20 ; $i++){
  //   $response = $gameState->drawACard();
  //   echo(json_encode($response)."</br>");
  // }


?>
