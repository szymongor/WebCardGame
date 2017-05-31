function LoginApi(){

  this.login = function(login, password){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/UserApi.php/login',
      data : {'login':"Szymon",'password':"12345678"},
  		success: function(data){
          console.log(data);
          var serverResponse = $.parseJSON(data);
          checkServerResponse(serverResponse);
  		}
  	});
  };

  this.logout = function(){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/UserApi.php/logout',
  		success: function(data){
          console.log(data);
  		}
  	});
  };

}
