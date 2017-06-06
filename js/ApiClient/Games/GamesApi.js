
var gamesApi = new GamesApi();

function GamesApi(){

  this.getAllPendingGames = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/GamesApi.php/pendingGames',
      data : {},
  		success: function(data){
          console.log(data);
          var serverResponse = $.parseJSON(data);
          pendingGamesResponse(serverResponse);
          //checkServerResponse(serverResponse);
  		}
  	});
  };

  this.addNewGame = function(gameName){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/GamesApi.php/addNewGame',
      data : {'gameName':gameName,'rules':""},
  		success: function(data){
          console.log(data);
  		}
  	});
  };

}