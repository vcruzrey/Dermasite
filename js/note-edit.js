//Check Session y si es DR
let jsonToCheckRol = {
	"action": "DRSESSION"
}

$.ajax({
	url: "/data/ApplicationLayer.php",
	type: "GET",
	data: jsonToCheckRol,
	ContentType: "application/json",
	dataType: "json",
	success: function (data) {
	},
	error: function (error) {
		alert("Error: Sesión no iniciada.");
		$(location).attr("href", "./../../login.html");
	}
});
//ON LOAD GET username
//FALYTA first_name

//Funcion al iniciar la pagina
$(document).ready(function () {
	returnNote();
});


//Cancelar
$('#patient_form_cancel').on('click', function (event) {
	event.preventDefault();
	$(location).attr("href", "./note-dashboard.html");
});


//LLenar la informacion del paciente
function returnNote() {
	let jsonToNote = {
		"action": "NOTEINFO"
	};

	$.ajax({
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToNote,
		ContentType: "application/json",
		dataType: 'json',
		success: function (data) {
			for (var i = 0; i < data.length; i++) {
				$('#first_name').val(data[i].complete_name);
				$('#evolution').val(data[i].evolution);
				$('#treatment').val(data[i].treatment);
			}
		},
		error: function (error) {
		}
	});
}

$('#patient_form_save').on('click', function (event) {
	event.preventDefault();
	var Registry = true;

	//Notes
	if ($('#evolution').val() == "") {
		$('#error_evolution').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_evolution').text('');
	}
	if ($('#treatment').val() == "") {
		$('#error_treatment').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_treatment').text('');
	}

	if (Registry) {
		ModifyNote();
		$('#error_message').css("display", "none");
		$('#success_message').css("display", "block");
	} else {
		$('#error_message').empty();
		$('#error_message').append(`Error <i class="glyphicon glyphicon-thumbs-down"></i> Hay un error en el registro.`);
		$('#error_message').css("display", "block");
	}
});

function ModifyNote() {
	let jsonToModifyNote = {
		"evolution": $("#evolution").val(),
		"treatment": $("#treatment").val(),
		"action": "NOTEMODIFY"
	};

	$.ajax({
		url: "/data/ApplicationLayer.php",
		type: "PUT",
		data: jsonToModifyNote,
		ContentType: "application/json",
		dataType: "json",
		success: function (data) {
			$(location).attr("href", "./note-dashboard.html");
		},
		error: function (error) {
		}
	});
}

//LOGOUT
$('#logout_button').on('click', function (event) {
	event.preventDefault();

	let jsonToCheckRol = {
		"action": "LOGOUT"
	}

	$.ajax({
		url: "/data/ApplicationLayer.php",
		type: "GET",
		data: jsonToCheckRol,
		ContentType: "application/json",
		dataType: "json",
		success: function (data) {
			$(location).attr("href", "./../../login.html");
		},
		error: function (error) {
		}
	});
});