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

//INICIO
$(document).ready(function () {
	SearchAllNotes();
});

function SearchAllNotes() {
	let jsonToAllNotes = {
		"action": "ALLNOTES"
	};

	$.ajax({
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToAllNotes,
		ContentType: "application/json",
		dataType: 'json',
		success: function (data) {
			let newHTML = "";
			for (var i = 0; i < data.length; i++) {
				newHTML += `<tr>
										<td class="col-md-1">${data[i].patient_id}</td>
										<td class="col-md-2">${data[i].first_name} ${data[i].last_name_father} ${data[i].last_name_mother}</td>
										<td class="col-md-4">${data[i].evolution}</td>
										<td class="col-md-4">${data[i].treatment}</td>
										<td class="col-md-1">${data[i].creation_date}</td>
										<td class="col-md-2">
											<div id="${data[i].note_id}">
												<button type="button" id="modifyNote" class="action_button">
													<i class="btn fa fa-edit fa-lg text-primary" aria-hidden="true"></i>
												</button>
											</div>
											<div id="${data[i].note_id}">
												<button id="trashNote" class="action_button">
													<i class="btn fa fa-trash-alt fa-lg text-danger" aria-hidden="true"></i>
													</button>
											</div>
										</td>
										</tr>`;
			}
			$('.all-notes').empty();
			$('.all-notes').append(newHTML);
			$('#warning_message').css("display", "none");
		},
		error: function (error) {
			$('.all-notes').empty();
			$('#warning_message').css("display", "block");
		}
	});
}

//BUSCA Paciente
$(".SearchNote").submit(function (event) {
	event.preventDefault();
	if ($('#search').val() != "") {
		let jsonToSearch = {
			"noteSearch": $('#search').val(),
			"action": "SEARCHNOTE"
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
											<td class="col-md-2">${data[i].first_name} ${data[i].last_name_father} ${data[i].last_name_mother}</td>
											<td class="col-md-4">${data[i].evolution}</td>
											<td class="col-md-4">${data[i].treatment}</td>
											<td class="col-md-1">${data[i].creation_date}</td>
											<td class="col-md-2">
												<div id="${data[i].note_id}">
													<button type="button" id="modifyNote" class="action_button">
														<i class="btn fa fa-edit fa-lg text-primary" aria-hidden="true"></i>
													</button>
												</div>
												<div id="${data[i].note_id}">
													<button id="trashNote" class="action_button">
														<i class="btn fa fa-trash-alt fa-lg text-danger" aria-hidden="true"></i>
													</button>
												</div>
											</td>
											</tr>`;
				}
				$('.all-notes').empty();
				$('.all-notes').append(newHTML);
				$('#warning_message').css("display", "none");
			},
			error: function (error) {
				$('.all-notes').empty();
				$('#warning_message').css("display", "block");
			}
		});
	}
	else {
		SearchAllNotes();
	}
});

//BOTON EditarNota
$('body').on('click', '#modifyNote', function () {
	let note = $(this).parent().attr('id');
	let action = "modifyNote";
	DrNoteSession(note, action);
});

//BOTON EliminarNota
$('body').on('click', '#trashNote', function () {
	let note = $(this).parent().attr('id');
	let action = "trashNote";
	if (confirm("Seguro de que quieres borrar esta nota? \n Si aceptas no habrá forma de recuperarla.")) {
		DrNoteSession(note, action);
	}
});

function DrNoteSession(note, action) {

	let jsonToDrNoteSession = {
		"note_id": note,
		"do": action,
		"action": "DRNOTESESSION"
	};


	$.ajax({
		dataType: 'json',
		url: '/data/ApplicationLayer.php',
		type: 'GET',
		data: jsonToDrNoteSession,
		ContentType: "application/json",
		success: function (data) {
			if (data.do == "modifyNote") {
				$(location).attr("href", "./note-edit.html");
			} else if (data.do == "trashNote") {
				trashNote();
				$(location).attr("href", "./note-dashboard.html");
			}
		},
		error: function (error) {
		}
	});
}

function trashNote() {
	let jsonTotrashNote = {
		"action": "TRASHNOTE"
	};

	$.ajax({
		dataType: 'json',
		url: '/data/ApplicationLayer.php',
		type: 'DELETE',
		data: jsonTotrashNote,
		ContentType: "application/json",
		success: function (data) {
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
