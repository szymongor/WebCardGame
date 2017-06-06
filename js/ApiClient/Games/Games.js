

function createNewGame(){
  
}

function pendingGamesResponse(response){
  if(response.Status = "Ok"){
    console.log(response.Games);
    $.each(response.Games, function( index, value ) {
      appendGameItem(value.id, value.id);
      console.log(value);
    });
  }


}
