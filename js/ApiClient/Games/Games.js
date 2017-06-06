var gamesApi = new GamesApi();

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
      appendGameItem(value.id, value.id);
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
