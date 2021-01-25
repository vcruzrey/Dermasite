let jsonToCheckRol = {
    "action": "PTSESSION"
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

//Cancelar
$('#patient_form_cancel').on('click', function (event) {
    event.preventDefault();
    $(location).attr("href", "./../patient-portal.html");
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

//Registrar Paciente
$('#patient_form_save').on('click', function (event) {
    event.preventDefault();
    var Registry = true;
    var PasswordC = false;
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
    if ($('#password').val() != "" && $('#verify_password').val() == "") {
        $('#error_password').text('');
        $('#error_verify_password').text('El campo debe estar lleno.');
        Registry = false;
    }
    else if ($('#password').val() == "" && $('#verify_password').val() != "") {
        $('#error_verify_password').text('');
        $('#error_password').text('El campo debe estar lleno.');
        Registry = false;
    }
    else if ($('#password').val() != "" && $('#verify_password').val() != "") {
        $('#error_verify_password').text('');
        if ($('#verify_password').val() == $('#password').val()) {
            $('#error_verify_password').text('');
            PasswordC = true;
        } else {
            $('#error_verify_password').text('Debe ser igual a la contraseña.');
            Registry = false;
        }
    } else {
        $('#error_verify_password').text('');
        $('#error_password').text('');
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
    if (Registry) {
        modifyPatient(PasswordC);
        $('#error_message').css("display", "none");
        $('#success_message').css("display", "block");
    } else {
        $('#error_message').empty();
        $('#error_message').append(`Error <i class="glyphicon glyphicon-thumbs-down"></i> Hay un error en el registro.`);
        $('#error_message').css("display", "block");
        $('#success_message').css("display", "none");
    }
});


//Funcion al iniciar la pagina
$(document).ready(function () {
    returnPatientInfo();
});

//LLenar la informacion del paciente
function returnPatientInfo() {
    let jsonToPatientInfo = {
        "action": "SELFPATIENTINFO"
    };

    $.ajax({
        url: '/data/ApplicationLayer.php',
        type: 'GET',
        data: jsonToPatientInfo,
        ContentType: "application/json",
        dataType: 'json',
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                $('#first_name').val(data[i].first_name);
                $('#last_name_father').val(data[i].last_name_father);
                $('#last_name_mother').val(data[i].last_name_mother);
                $('#email').val(data[i].email);
                $('[name="gender"][value=' + data[i].gender + ']').prop('checked', true);
                $('#birth_date').val(data[i].birth_date);
                $('[name="civil_status"][value=' + data[i].civil_status + ']').prop('checked', true);
                $('[name="occupation"][value=' + data[i].occupation + ']').prop('checked', true);
                $('#phone').val(data[i].phone);
                $('#street').val(data[i].street);
                $('#colony').val(data[i].colony);
                $('#zip_code').val(data[i].zip_code);
                $('#city').val(data[i].city);
                $('#patient_state').val(data[i].patient_state);
                $('#rfc').val(data[i].rfc);
                $('#consult_reason').val(data[i].consult_reason);
            }
        },
        error: function (error) {
        }
    });
}


//Modificar la informacion del paciente
function modifyPatient(PasswordC) {
    //Checa si se quiere modificar la contraseña
    if (PasswordC) {
        ModifyAnyUserPassword();
    } else {
        ModifyPatientInfo();
    }
}

//Modifica la contraseña
//ROLE MODEL
function ModifyAnyUserPassword() {
    let jsonToModifyAnyUserPassword = {
        "password": $("#password").val(),
        "action": "MODIFYANYUSERPASSWORD"
    };


    $.ajax({
        url: "/data/ApplicationLayer.php",
        type: "PUT",
        data: jsonToModifyAnyUserPassword,
        ContentType: "application/json",
        dataType: "json",
        success: function (data) {
            ModifyPatientInfo();
        },
        error: function (error) {
        }
    });
}

//Modifica Patient Info
function ModifyPatientInfo() {
    let jsonToModifyPatientInfo = {
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
        "action": "MODIFYPATIENTINFO"
    };


    $.ajax({
        url: "/data/ApplicationLayer.php",
        type: "PUT",
        data: jsonToModifyPatientInfo,
        ContentType: "application/json",
        dataType: "json",
        success: function (data) {
            $(location).attr("href", "./../patient-portal.html");
        },
        error: function (error) {
        }
    });
}
