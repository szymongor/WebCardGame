

function showMainMenu(){
  //var button = document.createElement('button');
//  $(button).addClass("btn btn-default btn-lg")
//  .html(message)
//  .appendTo($("#loginMessage"));
  clearPage();
  $('#mainContent').append('<div id="glyphMenu" class="row"></div>');
  //$('#glyphMenu').append('<div class="col-md-offset-1 col col-xs-5 col-md-3"><a href="#" class="thumbnail text-center menuThumbItem"><div class="glyphicon glyphiconMenuItem glyphicon-knight"></div><div>Games</div><div>');
  //$('#glyphMenu').append('<div class="col col-xs-5 col-md-3"><a href="#" class="thumbnail text-center menuThumbItem"><div class="glyphicon glyphiconMenuItem glyphicon-tower"></div><div>Achievements</div><div>');
  //$('#glyphMenu').append('<div class="col col-xs-5 col-md-3"><a href="#" class="thumbnail text-center menuThumbItem"><div class="glyphicon glyphiconMenuItem glyphicon-user"></div><div>User options</div><div>');
  appendGamesItem('glyphicon-knight','Games','showGamesMenu');
  appendGamesItem('glyphicon-tower','Achievements');
  appendGamesItem('glyphicon-user','User options');
}


function appendGamesItem(glyphType, text, action){
  var glyphAndText = '<div class="glyphicon glyphiconMenuItem '+glyphType+'"></div><div>'+text+'</div>';
  var thumbnailStr = '<a href="#" class="thumbnail text-center menuThumbItem">'+glyphAndText+'</a>';
  var elementCol = '<div class="col-md-offset-1 col col-xs-5 col-md-3" onclick="'+action+'()">'+thumbnailStr+'<div>';
  $('#glyphMenu').append(elementCol);

}
