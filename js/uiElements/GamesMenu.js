

function showGamesMenu(){
  clearPage();
  $('#mainContent').append('<div id="gamesListMenu" class="row center"></div>');
  appendFunctionsButtons();
  apendGamesListGroups();

}

function appendFunctionsButtons(){
    $('#gamesListMenu').append('<div id="gamesListFunctions" class=""></div>');

    $('#gamesListFunctions').append('<button type="button" class="btn btn-primary">Add new game</button>');
    $('#gamesListFunctions').append('<button type="button" class="btn btn-primary">Find Game</button>');
}

function apendGamesListGroups(){
  $('#gamesListMenu').append('<div id="gamesList" class="list-group gamesList well"></div>');
}
