

function showGamesMenu(){
  clearPage();
  $('#mainContent').append('<div id="gamesListMenu" class="row center"></div>');
  appendFunctionsButtons();
  appendGamesListGroups();

}

function appendFunctionsButtons(){
    $('#gamesListMenu').append('<div id="gamesListFunctions" class=""></div>');

    $('#gamesListFunctions').append('<button type="button" class="btn btn-primary">Add new game</button>');
    $('#gamesListFunctions').append('<button type="button" class="btn btn-primary">Find Game</button>');
}

function appendGamesListGroups(){
  $('#gamesListMenu').append('<div id="gamesList" class="list-group gamesList well"></div>');

  appendGameItem('Game1', 'l331rr');
  appendGameItem('Game2', '323c23');
  appendGameItem('Game3', 'l431rh');
  appendGameItem('Game4', '547buv');
  appendGameItem('Game5', '5vy6u7');
}

function appendGameItem(title, gameId){

  var itemStr = '<a class="list-group-item clearfix" onclick="">';
      itemStr += title + "\n";
      itemStr += '<span class="pull-right">';
      itemStr += '<span class="btn btn-xs btn-default" onclick="console.log(\''+gameId+'\')">';
      itemStr += '<span class="glyphicon glyphicon-play" aria-hidden="true"></span>';
      itemStr += 'Join game</span>';
      itemStr += '</span>';
      itemStr += '</a>';

  $('#gamesList').append(itemStr);
}
