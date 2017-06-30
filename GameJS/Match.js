
var matchApi = new MatchApi();

var audioYourTurn = new Audio("gong.mp3");
var audioEndGame = new Audio("biggong.mp3");

var cardsInfo = null;
var gameState = {};
var playerInfo = {};
matchApi.getCardsInfo();

function loadGameState(){
  setTimeout(function(){
    if(cardsInfo == null){
      loadGameState();
    }
    else{
      matchApi.getGameState();
      refreshGameState();
    }
  }, 300);

}

function cardsInfoResponse(serverResponse){
  cardsInfo = serverResponse;
}

function gameStateResponse(serverResponse){
  if(serverResponse['Status'] == "Ok"){
      var turn = gameState['Turn'];
      gameState = serverResponse['GameState'];
      playerInfo['id'] = serverResponse['Id'];
      extractPlayerInfo();
      upDateView();
      if(turn != gameState['Turn'] ){
        audioYourTurn.play();
      }
      if(serverResponse['GameState']['GameStatus'] == "End"){
        audioEndGame.play();
        alert("End of game");
        matchApi.deleteGame();
        window.location.replace("/CardGame/index.html");
      }
  }
  else{
    alert(serverResponse['Message']);
  }
}

function extractPlayerInfo(){
  for(i = 0 ; i < gameState['Players'].length ; i++){
    if(gameState['Players'][i] == playerInfo['id'] ){
      playerInfo['index'] = i;
    }
    else{
      playerInfo['target'] = i;
    }
  }
}


function upDateView(){
  //console.log("update");
  for(var i = 0 ; i < gameState['Players'].length ; i++){
    if(i == playerInfo['index'] ){
      updatePlayer(gameState['PlayersState'][i]);
    }
    else{
      updateEnemy(gameState['PlayersState'][i]);
    }
  }
  setTurn(gameState['Turn']);
}

function updatePlayer(playerState){
  setPlayerName("YOU");
  setPlayerWall(playerState['Wall']);
  setPlayerTower(playerState['Tower']);
  setPlayerBricks(playerState['Bricks']);
  setPlayerQuarry(playerState['Quarry']);
  setPlayerGems(playerState['Gems']);
  setPlayerMagic(playerState['Magic']);
  setPlayerRecruits(playerState['Recruits']);
  setPlayerDungeon(playerState['Dungeon']);
  setPlayersHand(playerState['Hand']);
}

function updateEnemy(playerState){
  setEnemy1Name("ENEMY");
  setEnemy1Wall(playerState['Wall']);
  setEnemy1Tower(playerState['Tower']);
  setEnemy1Bricks(playerState['Bricks']);
  setEnemy1Quarry(playerState['Quarry']);
  setEnemy1Gems(playerState['Gems']);
  setEnemy1Magic(playerState['Magic']);
  setEnemy1Recruits(playerState['Recruits']);
  setEnemy1Dungeon(playerState['Dungeon']);
}

function checkTurn(){
  if(gameState['Turn'] == playerInfo['index']){
    return true;
  }
  else{
    return false;
  }
}

function playCard(cardPosition){

  if(checkTurn()){
    if(event.shiftKey){
      matchApi.playersMove(cardPosition,1,playerInfo['target']);
    }
    else{
        matchApi.playersMove(cardPosition,0,playerInfo['target']);
    }
    gameState['Turn'] = playerInfo['target'];
  }
  else{
    alert("Not your turn!");
  }
  refreshGameState();
}

function refreshGameState(){
  matchApi.getGameState();
  setTimeout(function(){
    if(!checkTurn()){
      console.log("Refresh");
      refreshGameState();
    }
    else{

    }

  }, 700);
}
