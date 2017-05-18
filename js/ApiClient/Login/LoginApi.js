function LoginApi(){

  this.login = function(login, password){
  	$.ajax({
  		type: 'POST',
  		url: 'Server/Api/Login.php',
      data : {'login':"user123",'password':"123"},
  		success: function(data){
          //console.log(data);
          var serverResponse = $.parseJSON(data);
          checkServerResponse(serverResponse);
  		}
  	});
  };

}
