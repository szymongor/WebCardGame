function GamesApi(){

  this.getAllPendingGames = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/GamesApi.php/pendingGames',
      data : {},
  		success: function(data){
          //console.log(data);
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
        //console.log(data);
        var serverResponse = $.parseJSON(data);
        addNewGameResponse(serverResponse);
  		}
  	});
  };

  this.joinGame = function(gameName){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/GamesApi.php/joinGame',
      data : {'gameName':gameName},
  		success: function(data){
        console.log(data);
        var serverResponse = $.parseJSON(data);
        joinGameResponse(serverResponse);
  		}
  	});
  };

  this.deleteGame = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/GamesApi.php/deleteGame',
      data : {},
  		success: function(data){
        console.log(data);
        //var serverResponse = $.parseJSON(data);
        //joinGameResponse(serverResponse);
  		}
  	});
  };

  this.startGame = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/GamesApi.php/startGame',
      data : {},
  		success: function(data){
        console.log(data);
        var serverResponse = $.parseJSON(data);
        startGameResponse(serverResponse);
  		}
  	});
  };

}
