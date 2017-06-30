function LoginApi(){

  this.login = function(login, password){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/UserApi.php/login',
      data : {'login':login,'password':password},
  		success: function(data){
          //console.log(data);
          var serverResponse = $.parseJSON(data);
          checkServerLoginResponse(serverResponse);
  		}
  	});
  };

  this.logout = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/UserApi.php/logout',
  		success: function(data){
          //console.log(data);
  		}
  	});
  };

  this.register = function(login, email, password){
    $.ajax({
  		type: 'POST',
  		url: 'Server/Api/UserApi.php/register',
      data : {'login':login,'password':password, 'email':email},
  		success: function(data){
          //console.log(data);
          var serverResponse = $.parseJSON(data);
          checkServerLoginResponse(serverResponse);
  		}
  	});
  }

}
