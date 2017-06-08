

function showGamesMenu(){
  clearPage();
  $('#mainContent').append('<div id="gamesListMenu" class="row center"></div>');
  appendFunctionsButtons();
  appendGamesListGroups();

}

function appendFunctionsButtons(){
    $('#gamesListMenu').append('<div id="gamesListFunctions" class=""></div>');

    $('#gamesListFunctions').append('<button type="button" class="btn btn-primary" onclick="showAddNewGameModal()">Add new game</button>');
    $('#gamesListFunctions').append('<button type="button" class="btn btn-primary" onclick="refreshGamesList()">Refresh games</button>');
}

function appendGamesListGroups(){
  $('#gamesListMenu').append('<div id="gamesList" class="list-group gamesList well"></div>');
  gamesApi.getAllPendingGames();
  //appendGameItem('Game1', 'l331rr');
}

function appendGameItem(title, gameId, owner){
  var itemStr = '<a class="list-group-item clearfix" onclick="">';
  itemStr += title + "\n";
  itemStr += '<span class="pull-right">';
  if(owner == userData.login){
    itemStr += '<span class="btn btn-xs btn-default" onclick="deleteGame()">';
    itemStr += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
    itemStr += 'Delete game</span>';
  }
  itemStr += '<span class="btn btn-xs btn-default" onclick="joinGame(\''+gameId+'\')">';
  itemStr += '<span class="glyphicon glyphicon-play" aria-hidden="true"></span>';
  itemStr += 'Join game</span>';
  itemStr += '</span>';
  itemStr += '</a>';
  $('#gamesList').append(itemStr);
}

function showAddNewGameModal(){
  $('#addNewGame-modal').modal({
    show: 'true'
  });
}

function hideAddNewGameModal(){
  $('#addNewGame-modal').modal('hide');
}
