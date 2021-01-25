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

//Cancelar
$('#patient_form_cancel').on('click', function (event) {
	event.preventDefault();
	$(location).attr("href", "./patient-dashboard.html");
});

//Registrar Paciente
$('#patient_form_save').on('click', function (event) {
	event.preventDefault();
	var Registry = true;

	//PATIENT
	if ($('#first_name').val() == "") {
		$('#error_first_name').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_first_name').text('');
	}
	if ($('#last_name_father').val() == "") {
		$('#error_last_name_father').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_last_name_father').text('');
	}
	if ($('#last_name_mother').val() == "") {
		$('#error_last_name_mother').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_last_name_mother').text('');
	}
	if ($('#username').val() == "") {
		$('#error_username').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_username').text('');
	}
	if ($('#password').val() == "") {
		$('#error_password').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_password').text('');
	}
	if ($('#verify_password').val() == "") {
		$('#error_verify_password').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_verify_password').text('');
		if ($('#verify_password').val() == $('#password').val()) {
			$('#error_verify_password').text('');
		} else {
			$('#error_verify_password').text('Debe ser igual a la contraseña.');
			Registry = false;
		}
	}
	if ($('#email').val() == "") {
		$('#error_email').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_email').text('');
	}
	if ($('input[name=gender]').is(':checked')) {
		$('#error_gender').text('');
	}
	else {
		$('#error_gender').text('Debe seleccionar una opción.');
		Registry = false;
	}
	if ($('#birth_date').val() == "") {
		$('#error_birth_date').text('Debe seleccionar una fecha.');
		Registry = false;
	}
	else {
		$('#error_birth_date').text('');
	}
	if ($('input[name=civil_status]').is(':checked')) {
		$('#error_civil_status').text('');
	}
	else {
		$('#error_civil_status').text('Debe seleccionar una opción.');
		Registry = false;
	}
	if ($('input[name=occupation]').is(':checked')) {
		$('#error_occupation').text('');
	}
	else {
		$('#error_occupation').text('Debe seleccionar una opción.');
		Registry = false;
	}
	if ($('#phone').val() == "") {
		$('#error_phone').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_phone').text('');
	}
	if ($('#street').val() == "") {
		$('#error_street').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_street').text('');
	}
	if ($('#colony').val() == "") {
		$('#error_colony').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_colony').text('');
	}
	if ($('#zip_code').val() == "") {
		$('#error_zip_code').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		if (Number.isInteger(parseInt($('#zip_code').val()))) {
			$('#error_zip_code').text('');
		} else {
			$('#error_zip_code').text('Debe introducir un número.');
			Registry = false;
		}
	}
	if ($('#city').val() == "") {
		$('#error_city').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_city').text('');
	}
	if ($('#patient_state').val() == 0) {
		$('#error_patient_state').text('Debe seleccionar una opción.');
		Registry = false;
	}
	else {
		$('#error_patient_state').text('');
	}
	if ($('#consult_reason').val() == "") {
		$('#error_consult_reason').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_consult_reason').text('');
	}
	//CheckUP
	if ($('input[name=family_diabetes]').is(':checked')) {
		$('#error_family_diabetes').text('');
	}
	else {
		$('#error_family_diabetes').text('Debe seleccionar una opción.');
		Registry = false;
	}

	if ($('input[name=family_arterial_hypertension]').is(':checked')) {
		$('#error_family_arterial_hypertension').text('');
	}
	else {
		$('#error_family_arterial_hypertension').text('Debe seleccionar una opción.');
		Registry = false;
	}

	if ($('input[name=family_cancer]').is(':checked')) {
		$('#error_family_cancer').text('');
	}
	else {
		$('#error_family_cancer').text('Debe seleccionar una opción.');
		Registry = false;
	}
	if ($('#family_comment').val() == "") {
		$('#error_family_comment').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_family_comment').text('');
	}

	if ($('input[name=diabetes]').is(':checked')) {
		$('#error_diabetes').text('');
	}
	else {
		$('#error_diabetes').text('Debe seleccionar una opción.');
		Registry = false;
	}

	if ($('input[name=arterial_hypertension]').is(':checked')) {
		$('#error_arterial_hypertension').text('');
	}
	else {
		$('#error_arterial_hypertension').text('Debe seleccionar una opción.');
		Registry = false;
	}

	if ($('input[name=cancer]').is(':checked')) {
		$('#error_cancer').text('');
	}
	else {
		$('#error_cancer').text('Debe seleccionar una opción.');
		Registry = false;
	}
	if ($('#comment').val() == "") {
		$('#error_comment').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_comment').text('');
	}
	if ($('#alergies').val() == "") {
		$('#error_alergies').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_alergies').text('');
	}
	if ($('#surgeries').val() == "") {
		$('#error_surgeries').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_surgeries').text('');
	}
	if ($('#results').val() == "") {
		$('#error_results').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_results').text('');
	}
	if ($('#diagnosis').val() == "") {
		$('#error_diagnosis').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_diagnosis').text('');
	}
	if ($('#treatment').val() == "") {
		$('#error_treatment').text('El campo debe estar lleno.');
		Registry = false;
	}
	else {
		$('#error_treatment').text('');
	}
	if (Registry) {
		RegisterUser();
		$('#error_message').css("display", "none");
		$('#success_message').css("display", "block");
	} else {
		$('#error_message').empty();
		$('#error_message').append(`Error <i class="glyphicon glyphicon-thumbs-down"></i> Hay un error en el registro.`);
		$('#error_message').css("display", "block");
	}
});

function RegisterUser() {
	let jsonToRegisterUser = {
		"username": $("#username").val(),
		"password": $("#password").val(),
		"action": "REGISTERUSER"
	}

	$.ajax({
		url: "/data/ApplicationLayer.php",
		type: "POST",
		data: jsonToRegisterUser,
		ContentType: "application/json",
		dataType: "json",
		success: function (data) {
			RegisterRol();
		},
		error: function (error) {
			$('#error_message').css("display", "block");
			$('#error_message').empty();
			$('#error_message').append(`Error <i class="glyphicon glyphicon-thumbs-down"></i> El nombre de usuario ya existe.`);
			$('#success_message').css("display", "none");
		}
	});
}

function RegisterRol() {
	let jsonToRegisterRol = {
		"username": $("#username").val(),
		"rol": "Paciente",
		"action": "REGISTERROL"
	}

	$.ajax({
		url: "/data/ApplicationLayer.php",
		type: "POST",
		data: jsonToRegisterRol,
		ContentType: "application/json",
		dataType: "json",
		success: function (data) {
			RegisterPatient();
		},
		error: function (error) {
		}
	});
}

function RegisterPatient() {
	let jsonToRegisterPatient = {
		"username": $("#username").val(),
		"first_name": $("#first_name").val(),
		"last_name_father": $("#last_name_father").val(),
		"last_name_mother": $("#last_name_mother").val(),
		"birth_date": $('#birth_date').val(),
		"email": $("#email").val(),
		"gender": $('input[name=gender]:checked').val(),
		"civil_status": $('input[name=civil_status]:checked').val(),
		"occupation": $('input[name=occupation]:checked').val(),
		"phone": $("#phone").val(),
		"street": $("#street").val(),
		"colony": $("#colony").val(),
		"zip_code": $("#zip_code").val(),
		"city": $("#city").val(),
		"patient_state": $("#patient_state").val(),
		"rfc": $("#rfc").val(),
		"consult_reason": $("#consult_reason").val(),
		"action": "REGISTERPATIENT"
	}

	$.ajax({
		url: "/data/ApplicationLayer.php",
		type: "POST",
		data: jsonToRegisterPatient,
		ContentType: "application/json",
		dataType: "json",
		success: function (data) {
			RegisterCheckUp();
		},
		error: function (error) {
		}
	});
}

function RegisterCheckUp() {
	let jsonToRegisterCheckUP = {
		"username": $("#username").val(),
		"family_diabetes": $("input[name=family_diabetes]:checked").val(),
		"family_arterial_hypertension": $("input[name=family_arterial_hypertension]:checked").val(),
		"family_cancer": $("input[name=family_cancer]:checked").val(),
		"family_comment": $("#family_comment").val(),
		"diabetes": $("input[name=diabetes]:checked").val(),
		"arterial_hypertension": $("input[name=arterial_hypertension]:checked").val(),
		"cancer": $('input[name=cancer]:checked').val(),
		"comment": $('#comment').val(),
		"alergies": $('#alergies').val(),
		"surgeries": $("#surgeries").val(),
		"results": $("#results").val(),
		"diagnosis": $("#diagnosis").val(),
		"treatment": $("#treatment").val(),
		"action": "REGISTERCHECKUP"
	}

	$.ajax({
		url: "/data/ApplicationLayer.php",
		type: "POST",
		data: jsonToRegisterCheckUP,
		ContentType: "application/json",
		dataType: "json",
		success: function (data) {
			$(location).attr("href", "./patient-dashboard.html");

		},
		error: function (error) {
		}
	});
}
