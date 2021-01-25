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

//INICIO
$(document).ready(function () {
	SearchAllPatients();
});

function SearchAllPatients() {
	//Regresa Todos los Pacientes
	let jsonToAllPatients = {
		"action": "ALLPATIENTS"
	};

	$.ajax({
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToAllPatients,
		ContentType: "application/json",
		dataType: 'json',
		success: function (data) {
			let newHTML = "";
			for (var i = 0; i < data.length; i++) {
				newHTML += `<tr>
		                  <td class="col-md-1">${data[i].patient_id}</td>
		                  <td class="col-md-5">${data[i].first_name} ${data[i].last_name_father} ${data[i].last_name_mother}</td>
		                  <td class="col-md-1">${data[i].gender}</td>
		                  <td class="col-md-2">${data[i].birth_date}</td>
		                  <td class="action_buttons_row">
												<div id="${data[i].patient_id}">
													<button type="button" id="editPatient" class="action_button">
		                      							<i class="btn fas fa-eye fa-lg text-primary" aria-hidden="true"></i>
		                    						</button>
												</div>
												<div id="${data[i].patient_id}">
													<button id="addNote" class="action_button">
														<i class="btn fas fa-folder-plus fa-lg text-success" aria-hidden="true"></i>
		                    						</button>
												</div>
												<div id="${data[i].patient_id}">
													<button id="trashPatient"class="action_button">
														<i class="btn fa fa-trash-alt fa-lg text-danger" aria-hidden="true"></i>
														</button>
												</div>
		                  	</td>
		                </tr>`;
			}
			$('.all-patients').empty();
			$('.all-patients').append(newHTML);
			$('#warning_message').css("display", "none");
		},
		error: function (error) {
			$('.all-patients').empty();
			$('#warning_message').css("display", "block");
		}
	});
}

//BUSCA Paciente
$(".SearchPatient").submit(function (event) {
	event.preventDefault();
	if ($('#search').val() != "") {
		let jsonToSearch = {
			"userSearch": $('#search').val(),
			"action": "SEARCHPATIENT"
		}
		$.ajax({
			url: '/data/ApplicationLayer.php',
			type: 'GET',
			data: jsonToSearch,
			ContentType: "application/json",
			dataType: 'json',
			success: function (data) {
				let newHTML = "";
				for (var i = 0; i < data.length; i++) {
					newHTML += `<tr>
												<td class="col-md-1">${data[i].patient_id}</td>
												<td class="col-md-5">${data[i].first_name} ${data[i].last_name_father} ${data[i].last_name_mother}</td>
												<td class="col-md-1">${data[i].gender}</td>
												<td class="col-md-2">${data[i].birth_date}</td>
												<td  <td class="action_buttons_row">
													<div id="${data[i].patient_id}">
														<button type="button" id="editPatient" class="action_button">
			                      							<i class="btn fas fa-eye fa-lg text-primary" aria-hidden="true"></i>
			                    						</button>
													</div>
													<div id="${data[i].patient_id}">
														<button id="addNote" class="action_button">
															<i class="btn fas fa-folder-plus fa-lg text-success" aria-hidden="true"></i>
			                    						</button>
													</div>
													<div id="${data[i].patient_id}">
														<button id="trashPatient"class="action_button">
															<i class="btn fa fa-trash-alt fa-lg text-danger" aria-hidden="true"></i>
														</button>
													</div>
			                  						</td>
											</tr>`;
				}
				$('.all-patients').empty();
				$('.all-patients').append(newHTML);
				$('#warning_message').css("display", "none");
			},
			error: function (error) {
				$('.all-patients').empty();
				$('#warning_message').css("display", "block");
			}
		});
	}
	else {
		SearchAllPatients();
	}
});

//BOTON Editar Paciente
$('body').on('click', '#editPatient', function () {
	let patient = $(this).parent().attr('id');
	let action = "editPatient";
	DrPatientSession(patient, action);
});

//BOTON Agregar nota
$('body').on('click', '#addNote', function () {
	let patient = $(this).parent().attr('id');
	let action = "addNote";
	DrPatientSession(patient, action);
});

//BOTON borrar paciente
$('body').on('click', '#trashPatient', function () {
	let patient = $(this).parent().attr('id');
	let action = "trashPatient";
	if (confirm("Seguro de que quieres borrar los datos del paciente? \n Si aceptas no habrá forma de recuperarlo.")) {
		DrPatientSession(patient, action);
	}
});

function DrPatientSession(patient, action) {

	let jsonToDrPatientSession = {
		"patient_id": patient,
		"do": action,
		"action": "DRPATIENTSESSION"
	};


	$.ajax({
		dataType: 'json',
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToDrPatientSession,
		ContentType: "application/json",
		success: function (data) {
			if (data.do == "editPatient") {
				$(location).attr("href", "./patient-info.html");
			} else if (data.do == "addNote") {
				$(location).attr("href", "./../NotasDevolucion/note-add.html");
			} else if (data.do == "trashPatient") {
				trashPaciente();
				$(location).attr("href", "./patient-dashboard.html");
			}
		},
		error: function (error) {
		}
	});
}

function trashPaciente() {
	let jsonTotrashPaciente = {
		"action": "TRASHPACIENTE"
	};


	$.ajax({
		dataType: 'json',
		url: '/data/ApplicationLayer.php',
		type: 'DELETE',
		data: jsonTotrashPaciente,
		ContentType: "application/json",
		success: function (data) {
		},
		error: function (error) {
		}
	});
}
