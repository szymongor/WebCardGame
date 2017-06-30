var gamesApi = new GamesApi();
var matchApi = new MatchApi();

var gameState = {};

function createNewGame(){
  var gameName = $('#gameNameInput').val();
  gamesApi.addNewGame(gameName);
  $('#serverMessage').empty();
}

function refreshGamesList(){
  gamesApi.getAllPendingGames();
}

function pendingGamesResponse(response){
  if(response.Status == "Ok"){
    $('#gamesList').empty();
    //console.log(response.Games);
    $.each(response.Games, function( index, value ) {
      appendGameItem(value.id, value.id, value.Owner);
      //console.log(value);
    });
  }
}

function addNewGameResponse(response){
  console.log(response);
  if(response.Status == "Ok"){
    hideAddNewGameModal();
    refreshGamesList();
  }
  else{
    appendAddGameErrorMessage(response.Message);
  }
}

function appendAddGameErrorMessage(message){
  var errorMsg = document.createElement('div');
  $(errorMsg).addClass("alert alert-danger")
  .html(message)
  .appendTo($("#serverMessage"));
}

function joinGame(gameName){
  gamesApi.joinGame(gameName);
}

function joinGameResponse(response){
  if(response.Status == "Ok"){
    console.log("To do: open game View: " );
    matchApi.waitingToStart();
  }
  else{
    console.log(response.Message);
  }
}

function joinGameWaiting(serverResponse){
  if(serverResponse['GameState']['Pending'] != undefined){
    if(serverResponse['GameState']['Pending'] == 1){
      console.log(serverResponse['GameState']['Pending']);
      setTimeout(function(){matchApi.waitingToStart(); }, 3000);
    }
    else{
      console.log("Start");
      window.location.replace("GameView.html");
    }
  }
}

function startGameResponse(serverResponse){
  if(serverResponse['Status'] == "Ok"){
    window.location.replace("GameView.html");
  }
}

function deleteGame(){
  gamesApi.deleteGame();
  refreshGamesList();
}
