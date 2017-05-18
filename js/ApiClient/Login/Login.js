var loginApi = new LoginApi();

var userData={};

function login(){
  clearLoginErrorMessage();
  var userLogin = $('#loginInput').val();
  var userPassword = $('#passwordInput').val();
  loginApi.login(userLogin, userPassword);
}

function logout(){
  clearPage();
  navbarLoginChange();
}

function register(){
  var userLogin = $('#registerLoginInput').val();
  var userEmail = $('#emailInput').val();
  var userPassword1 = $('#password1Input').val();
  var userPassword2 = $('#password2Input').val();

  console.log(userLogin+":"+userEmail+":"+userPassword1);
}

function checkServerResponse(serverData){
  if(serverData.Status == "Ok"){
    hideLoginModal();
    userData.login=serverData.Login;
    succesLogin();
  }
  else{
    appendLoginErrorMessage(serverData.Message);
  }
}

function appendLoginErrorMessage(message){
  var errorMsg = document.createElement('div');
  $(errorMsg).addClass("alert alert-danger")
  .html(message)
  .appendTo($("#loginMessage"));
}

function clearLoginErrorMessage(){
  $("#loginMessage").empty();
}

function hideLoginModal(){
  $('#login-modal').modal('hide');
}

function hideRegisterModal(){
  $('#register-modal').modal('hide');
}

function succesLogin(){
  showMainMenu();
  navbarLogoutChange();
}

function navbarLogoutChange(){
  $('#navbarLoginBtn').empty();
  $('#navbarLoginBtn').append("Logout("+userData.login+")");
  $('#navbarLoginBtn').removeAttr('data-toggle');
  $('#navbarLoginBtn').removeAttr('data-target');
  $('#navbarLoginBtn').click(logout);
}

function navbarLoginChange(){
  $('#navbarLoginBtn').empty();
  $('#navbarLoginBtn').append("Login");
  $('#navbarLoginBtn').attr("data-toggle", "modal");
  $('#navbarLoginBtn').attr("data-target", "#login-modal");
}

function showMainMenu(){
  var button = document.createElement('button');
//  $(button).addClass("btn btn-default btn-lg")
//  .html(message)
//  .appendTo($("#loginMessage"));
  clearPage();
  $('#mainContent').append('<div id="glyphMenu" class="row"></div>');
  $('#glyphMenu').append('<div class="col-md-offset-1 col col-xs-5 col-md-3"><a href="#" class="thumbnail text-center menuThumbItem"><div class="glyphicon glyphiconMenuItem glyphicon-knight"></div><div>Games</div><div>');
  $('#glyphMenu').append('<div class="col col-xs-5 col-md-3"><a href="#" class="thumbnail text-center menuThumbItem"><div class="glyphicon glyphiconMenuItem glyphicon-tower"></div><div>Achievements</div><div>');
  $('#glyphMenu').append('<div class="col col-xs-5 col-md-3"><a href="#" class="thumbnail text-center menuThumbItem"><div class="glyphicon glyphiconMenuItem glyphicon-user"></div><div>User options</div><div>');

}

function clearPage(){
  $('#mainContent').empty();
}
