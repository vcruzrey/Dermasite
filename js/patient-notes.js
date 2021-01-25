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

$(document).ready(function () {
    SearchMyNotes();
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

var sessionPATIENT_ID;
function SearchMyNotes() {
    let jsonToSearch = {
        "action": "SEARCHNOTEPATIENT"
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
                newHTML += ` <tr>
                                <td class="col-md-1">${data[i].creation_date}</td>
                                <td class="col-md-5">${data[i].evolution}</td>
                                <td class="col-md-5">${data[i].treatment}</td>
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
