function MatchApi(){

  this.playersMove = function(cardPosition,isDiscarded,target){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/MatchApi.php/playersMove',
      data : {'cardPosition':cardPosition, 'isDiscarded':isDiscarded,"target":target},
  		success: function(data){
          console.log(data);
          var serverResponse = $.parseJSON(data);
          if(serverResponse['Status'] == "Error"){
            alert(serverResponse['Message']);
          }
          //playersMoveResponse(serverResponse);
          //checkServerResponse(serverResponse);
  		}
  	});
  };

  this.getGameState = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/MatchApi.php/getGameState',
      data : {},
  		success: function(data){
        var serverResponse = $.parseJSON(data);
        gameStateResponse(serverResponse);
  		}
  	});
  };

  this.waitingToStart = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/MatchApi.php/getGameState',
      data : {},
  		success: function(data){
        //console.log(data);
        var serverResponse = $.parseJSON(data);
        joinGameWaiting(serverResponse);
  		}
  	});
  };

  this.getCardsInfo = function(gameName){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/MatchApi.php/cards',
      data : {},
  		success: function(data){
        //console.log(data);
        var serverResponse = $.parseJSON(data);
        cardsInfoResponse(serverResponse);
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

}
