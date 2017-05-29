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

  this.req1 = function(){
		$.ajax({
				type: 'GET',
				crossDomain: true,
				url: 'http://157.158.16.186:8090/EregUsers',
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				headers: {
					"Authorization":"eyJhbGciOiJIUzI1NiJ9.eyJleHAiOjE0OTY2MDgyNDQsImxvZ2luIjoicGF3bWFtMTIzIiwicm9sZXMiOiJURUFDSEVSIiwiaWQiOiI2IiwiZ2VuZXJhdGlvbkRhdGUiOiIyMDE3LTA1LTI4IDIyOjMwOjQ0In0.Nce6jt1BvOeXDjbs2BTM_sQF-VZ_Mm6ENuYwsGaDo0g",
				},
				success: function(data){
					console.log(data);
				},
				error: function (request, status, error) {
					console.log(error);
				}
			});
	  }

    this.req2 = function(){
  		$.ajax({
  				type: 'POST',
  				crossDomain: true,
  				url: 'http://157.158.16.186:8090/auth',
  				contentType: "application/json; charset=utf-8",
  				dataType: "json",
          data: '{"login": "pawmam123","password": "12345678"}',
  				headers: {
  					"Content-Type":"application/json",},
  				success: function(data){
  					console.log(data);
  				},
  				error: function (request, status, error) {
  					console.log(error);
  				}
  			});
  	  }

}
