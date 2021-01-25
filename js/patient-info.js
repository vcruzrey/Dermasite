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
		$(location).attr("href", "./../../login.html ");
	}
});

//Funcion al iniciar la pagina
$(document).ready(function () {
	returnPatientInfo();
});

//LLenar la informacion del paciente
function returnPatientInfo() {
	let jsonToPatientInfo = {
		"action": "PATIENTINFO"
	};

	$.ajax({
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToPatientInfo,
		ContentType: "application/json",
		dataType: 'json',
		success: function (data) {
			for (var i = 0; i < data.length; i++) {
				$('#info-creation_date').text(data[i].creation_date);
				$('#info-patient_id').text(data[i].patient_id);
				$('#info-name').text(data[i].first_name + " " + data[i].last_name_father + " " + data[i].last_name_mother);
				$('#info-username').text(data[i].username);
				$('#info-email').text(data[i].email);
				$('#info-gender').text(data[i].gender);
				$('#info-birth_date').text(data[i].birth_date);
				$('#info-civil_status').text(data[i].civil_status);
				$('#info-occupation').text(data[i].occupation);
				$('#info-phone').text(data[i].phone);
				$('#info-street').text(data[i].street);
				$('#info-colony').text(data[i].colony);
				$('#info-zip_code').text(data[i].zip_code);
				$('#info-city').text(data[i].city);
				$('#info-patient_state').text(data[i].patient_state);
				$('#info-rfc').text(data[i].rfc === "" ? "N/D" : data[i].rfc);
				$('#info-consult_reason').text(data[i].consult_reason);
				returnPatientCheckUp();
			}
		},
		error: function (error) {
		}
	});
}

function returnPatientCheckUp() {
	let jsonToPatientCheckUp = {
		"action": "PATIENTCHECKUP"
	};

	$.ajax({
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToPatientCheckUp,
		ContentType: "application/json",
		dataType: 'json',
		success: function (data) {
			$('#warning_message').css("display", "none");
			$('#checkup_info').css("display", "block");
			for (var i = 0; i < data.length; i++) {
				$('#info-family_diabetes').text(data[i].family_diabetes);
				$('#info-family_arterial_hypertension').text(data[i].family_arterial_hypertension);
				$('#info-family_cancer').text(data[i].family_cancer);
				$('#info-family_comment').text(data[i].family_comment);
				$('#info-diabetes').text(data[i].diabetes);
				$('#info-arterial_hypertension').text(data[i].arterial_hypertension);
				$('#info-cancer').text(data[i].cancer);
				$('#info-comment').text(data[i].comment);
				$('#info-alergies').text(data[i].alergies);
				$('#info-surgeries').text(data[i].surgeries);
				$('#info-results').text(data[i].results);
				$('#info-diagnosis').text(data[i].diagnosis);
				$('#info-treatment').text(data[i].treatment);
			}
		},
		error: function (error) {
			$('#checkup_info').css("display", "none");
			$('#warning_message').css("display", "block");
		}
	});

}
//Regresar
$('#patient_form_cancel').on('click', function (event) {
	event.preventDefault();
	$(location).attr("href", "./patient-dashboard.html");
});
//Editar
$('#patient_form_edit').on('click', function (event) {
	event.preventDefault();
	$(location).attr("href", "./patient-edit.html");
});

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
