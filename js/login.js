let jsonToSendCookie = {
  "action": "COOKIE"
};

$.ajax({
  url: '/data/ApplicationLayer.php',
  type: 'GET',
  data: jsonToSendCookie,
  dataType: 'json',
  ContentType: "application/json",
  success: function (data) {
    $("#usernameLogin").val(data.username);
  },
  error: function (error) {
  }
});

//Funcion Login
$('#loginButton').on('click', function (event) {
  event.preventDefault();
  var Login = true;
  var rememberMe = $('#rememberMeLogin').is(":checked");

  //Username
  if ($('#usernameLogin').val() == "") {
    $('#error_usernameLogin').text('El campo debe estar lleno.');
    Login = false;
  }
  else {
    $('#error_usernameLogin').text('');
  }
  //Password
  if ($('#passwordLogin').val() == "") {
    $('#error_passwordLogin').text('El campo debe estar lleno.');
    Login = false;
  }
  else {
    $('#error_passwordLogin').text('');
  }

  //Data Send To loginService
  if (Login) {
    let jsonToLogin = {
      "username": $("#usernameLogin").val(),
      "password": $("#passwordLogin").val(),
      "rememberMe": rememberMe,
      "action": "LOGIN"
    };

    $.ajax({
      url: "/data/ApplicationLayer.php",
      type: "GET",
      data: jsonToLogin,
      contentType: "application/json",
      dataType: "json",
      success: function (data) {
        $('#error_message').css("display", "none");
        if (data.rol == "Doctor") {
          $(location).attr("href", "./Doctor/doctor-portal.html");
        } else {
          $(location).attr("href", "./Patients/patient-portal.html");
        }
      },
      error: function (error) {
        $('#error_message').empty();
        $('#error_message').append(`Error <i class="glyphicon glyphicon-thumbs-down"></i> El nombre de usuario o contraseña son
        incorrectos.`);
        $('#error_message').css("display", "block");
      }
    });
  } else {
    $('#error_message').empty();
    $('#error_message').append(`Error <i class="glyphicon glyphicon-thumbs-down"></i> Falta información.`);
    $('#error_message').css("display", "block");
  }
});
