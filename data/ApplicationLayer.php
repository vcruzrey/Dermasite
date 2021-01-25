<?php

header('Content-type: application/json');
header('Accept: application/json');

require_once __DIR__ . '/DataLayer.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
	case "GET":
		$action = $_GET["action"];
		getRequests($action);
		break;
	case "POST":
		$action = $_POST["action"];
		postRequests($action);
		break;
	case "PUT":
		parse_str(file_get_contents("php://input"), $_PUT);
		$action = $_PUT["action"];
		putRequests($action);
		break;
	case "DELETE":
		parse_str(file_get_contents("php://input"), $_DELETE);
		$action = $_DELETE["action"];
		deleteRequests($action);
		break;
}

function getRequests($action)
{
	switch ($action) {
		case "LOGIN":
			requestLogin();
			break;
		case "COOKIE":
			requestCookie();
			break;
		case "SESSION":
			requestSession();
			break;
		case "REGISTER":
			requestRegister();
			break;
		case "ALLPATIENTS":
			requestAllPatients();
			break;
		case "SEARCHPATIENT":
			requestSearchPatient();
			break;
		case "PATIENTINFO":
		case "PATIENTCHECKUP":
		case "SELFPATIENTINFO":
			requestPatientInfo($action);
			break;
		case "ALLNOTES":
		case "SEARCHNOTE":
		case "SEARCHNOTEPATIENT":
		case "SEARCHNOTESPECIFIC":
			requestNotes($action);
			break;
		case "NOTEINFO":
			requestNote();
			break;
		case "DRPATIENTSESSION":
			requestDrPatientSESSION();
			break;
		case "NOTEPATIENT":
			requestNotePatient();
			break;
		case "DRNOTESESSION":
			requestDrNoteSESSION();
			break;
		case "DRSESSION":
			requestDrSession();
			break;
		case "PTSESSION":
			requestPtSession();
			break;
		case "LOGOUT":
			logout();
			break;
	}
}

function postRequests($action)
{
	switch ($action) {
		case "REGISTERUSER":
			requestRegisterUser();
			break;
		case "REGISTERROL":
			requestRegisterRol();
			break;
		case "REGISTERPATIENT":
			requestRegisterPatient();
			break;
		case "REGISTERDR":
			requestRegisterDr();
			break;
		case "REGISTERCHECKUP":
			requestRegisterCheckUp();
			break;
		case "REGISTERNOTE":
			requestRegisterNote();
			break;

	}
}


function putRequests($action)
{
	switch ($action) {
		case "MODIFYANYUSERPASSWORD":
		case "MODIFYPATIENTINFO":
		case "MODIFYPATIENTCHECKUP":
			requestModifyData($action);
			break;
		case "NOTEMODIFY":
			requestModifyNote();
			break;
	}
}

function deleteRequests($action)
{
	switch ($action) {
		case "TRASHNOTE":
		case "TRASHPACIENTE":
			requestTrashSQL($action);
			break;
	}
}

function requestLogin()
{
	$uName = filter_var($_GET["username"], FILTER_SANITIZE_STRING);
	$uPassword = filter_var($_GET["password"], FILTER_SANITIZE_STRING);
	$uRememberMe = filter_var($_GET["rememberMe"], FILTER_SANITIZE_STRING);
	$response = attemptLogin($uName, $uPassword);

	if ($response["status"] == "SUCCESS") {
		starSession($uName, $response["response"]["rol"]);
		cookieManipulation($uRememberMe, $uName);
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function starSession($username, $rol)
{
	session_start();
	$_SESSION["username"] = $username;
	$_SESSION["rol"] = $rol;
}

function cookieManipulation($flag, $username)
{
	if ($flag) {
		setcookie("username", $username, time() + 3600 * 24 * 30, "/", "", 0);
	} else {
		setcookie("username", "", time() - 3600, "/", "", 0);
		unset($_COOKIE["username"]);
	}
}

function requestCookie()
{
	if (isset($_COOKIE["username"])) {
		$response = array("username" => $_COOKIE["username"]);
		echo json_encode($response);
	} else {
		errorHandler("not saved.", "407");
	}
}

function requestSession()
{
	session_start();
	if (isset($_SESSION["username"])) {
		$response = array("username" => $_SESSION["username"]);
		echo json_encode($response);
	} else {
		session_destroy();
		errorHandler("not set yet.", "409");
	}
}

function requestSession2()
{
	session_start();
	if (isset($_SESSION["firstName"])) {
		return true;
	} else {
		session_destroy();
		return false;
	}
}

function requestRegister()
{
	$arrayData = array(
		"first_name" => filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
		"last_name_father" => filter_var($_POST['last_name_father'], FILTER_SANITIZE_STRING),
		"last_name_mother" => filter_var($_POST['last_name_mother'], FILTER_SANITIZE_STRING),
		"username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
		"password" => filter_var($_POST['password'], FILTER_SANITIZE_STRING),
		"email" => filter_var($_POST['email'], FILTER_SANITIZE_STRING),
		"gender" => filter_var($_POST['gender'], FILTER_SANITIZE_STRING),
		"civil_status" => filter_var($_POST['civil_status'], FILTER_SANITIZE_STRING),
		"occupation" => filter_var($_POST['occupation'], FILTER_SANITIZE_STRING),
		"phone" => filter_var($_POST['phone'], FILTER_SANITIZE_STRING),
		"street" => filter_var($_POST['street'], FILTER_SANITIZE_STRING),
		"colony" => filter_var($_POST['colony'], FILTER_SANITIZE_STRING),
		"zip_code" => filter_var($_POST['zip_code'], FILTER_SANITIZE_STRING),
		"city" => filter_var($_POST['city'], FILTER_SANITIZE_STRING),
		"patient_state" => filter_var($_POST['patient_state'], FILTER_SANITIZE_STRING),
		"rfc" => filter_var($_POST['rfc'], FILTER_SANITIZE_STRING),
		"consult_reason" => filter_var($_POST['consult_reason'], FILTER_SANITIZE_STRING),
		"family_diabetes" => filter_var($_POST['family_diabetes'], FILTER_SANITIZE_STRING),
		"family_arterial_hypertension" => filter_var($_POST['family_arterial_hypertension'], FILTER_SANITIZE_STRING),
		"family_cancer" => filter_var($_POST['family_cancer'], FILTER_SANITIZE_STRING),
		"family_comment" => filter_var($_POST['family_comment'], FILTER_SANITIZE_STRING),
		"diabetes" => filter_var($_POST['diabetes'], FILTER_SANITIZE_STRING),
		"arterial_hypertension" => filter_var($_POST['arterial_hypertension'], FILTER_SANITIZE_STRING),
		"cancer" => filter_var($_POST['cancer'], FILTER_SANITIZE_STRING),
		"comment" => filter_var($_POST['comment'], FILTER_SANITIZE_STRING),
		"alergies" => filter_var($_POST['alergies'], FILTER_SANITIZE_STRING),
		"surgeries" => filter_var($_POST['surgeries'], FILTER_SANITIZE_STRING),
		"results" => filter_var($_POST['results'], FILTER_SANITIZE_STRING),
		"diagnosis" => filter_var($_POST['diagnosis'], FILTER_SANITIZE_STRING),
		"treatment" => filter_var($_POST['treatment'], FILTER_SANITIZE_STRING)
	);

	$response = attemptRegister($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestRegisterUser()
{
	$arrayData = array(
		"username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
		"password" => filter_var($_POST['password'], FILTER_SANITIZE_STRING)
	);

	$response = attemptRegisterUser($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestRegisterRol()
{
	$arrayData = array(
		"username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
		"rol" => filter_var($_POST['rol'], FILTER_SANITIZE_STRING)
	);

	$response = attemptRegisterRol($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestRegisterPatient()
{
	$arrayData = array(
		"username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
		"first_name" => filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
		"last_name_father" => filter_var($_POST['last_name_father'], FILTER_SANITIZE_STRING),
		"last_name_mother" => filter_var($_POST['last_name_mother'], FILTER_SANITIZE_STRING),
		"birth_date" => filter_var($_POST['birth_date'], FILTER_SANITIZE_STRING),
		"email" => filter_var($_POST['email'], FILTER_SANITIZE_STRING),
		"gender" => filter_var($_POST['gender'], FILTER_SANITIZE_STRING),
		"civil_status" => filter_var($_POST['civil_status'], FILTER_SANITIZE_STRING),
		"occupation" => filter_var($_POST['occupation'], FILTER_SANITIZE_STRING),
		"phone" => filter_var($_POST['phone'], FILTER_SANITIZE_STRING),
		"street" => filter_var($_POST['street'], FILTER_SANITIZE_STRING),
		"colony" => filter_var($_POST['colony'], FILTER_SANITIZE_STRING),
		"zip_code" => filter_var($_POST['zip_code'], FILTER_SANITIZE_STRING),
		"city" => filter_var($_POST['city'], FILTER_SANITIZE_STRING),
		"patient_state" => filter_var($_POST['patient_state'], FILTER_SANITIZE_STRING),
		"rfc" => filter_var($_POST['rfc'], FILTER_SANITIZE_STRING),
		"consult_reason" => filter_var($_POST['consult_reason'], FILTER_SANITIZE_STRING),
	);

	$response = attemptRegisterPatient($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestRegisterDr()
{
	$arrayData = array(
		"username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
		"first_name" => filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
		"last_name_father" => filter_var($_POST['last_name_father'], FILTER_SANITIZE_STRING),
		"last_name_mother" => filter_var($_POST['last_name_mother'], FILTER_SANITIZE_STRING)
	);

	$response = attemptRegisterDr($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}
function requestRegisterCheckUp()
{
	$arrayData = array(
		"username" => filter_var($_POST['username'], FILTER_SANITIZE_STRING),
		"family_diabetes" => filter_var($_POST['family_diabetes'], FILTER_SANITIZE_STRING),
		"family_arterial_hypertension" => filter_var($_POST['family_arterial_hypertension'], FILTER_SANITIZE_STRING),
		"family_cancer" => filter_var($_POST['family_cancer'], FILTER_SANITIZE_STRING),
		"family_comment" => filter_var($_POST['family_comment'], FILTER_SANITIZE_STRING),
		"diabetes" => filter_var($_POST['diabetes'], FILTER_SANITIZE_STRING),
		"arterial_hypertension" => filter_var($_POST['arterial_hypertension'], FILTER_SANITIZE_STRING),
		"cancer" => filter_var($_POST['cancer'], FILTER_SANITIZE_STRING),
		"comment" => filter_var($_POST['comment'], FILTER_SANITIZE_STRING),
		"alergies" => filter_var($_POST['alergies'], FILTER_SANITIZE_STRING),
		"surgeries" => filter_var($_POST['surgeries'], FILTER_SANITIZE_STRING),
		"results" => filter_var($_POST['results'], FILTER_SANITIZE_STRING),
		"diagnosis" => filter_var($_POST['diagnosis'], FILTER_SANITIZE_STRING),
		"treatment" => filter_var($_POST['treatment'], FILTER_SANITIZE_STRING)
	);

	$response = attemptRegisterCheckUp($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestAllPatients()
{
	$response = attemptAllPatients();
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestSearchPatient()
{

	$userSearch = filter_var($_GET["userSearch"], FILTER_SANITIZE_STRING);
	$response = attemptSearchPatient($userSearch);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestPatientInfo($action)
{
	session_start();
	if ($action == "SELFPATIENTINFO") {
		$data = $_SESSION["username"];
	} else {
		$data = $_SESSION["patient_id"];
	}
	$response = attemptPatientInfo($action, $data);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestModifyData($action)
{
	parse_str(file_get_contents("php://input"), $_PUT);
	session_start();
	$rol = $_SESSION["rol"];
	if ($rol == "Paciente") {
		$data = $_SESSION["username"];
	} else {
		$data = $_SESSION["patient_id"];
	}

	if ($action == "MODIFYANYUSERPASSWORD") {
		$arrayData = array(
			"password" => filter_var($_PUT['password'], FILTER_SANITIZE_STRING)
		);
	} else if ($action == "MODIFYPATIENTINFO") {
		$arrayData = array(
			"first_name" => filter_var($_PUT['first_name'], FILTER_SANITIZE_STRING),
			"last_name_father" => filter_var($_PUT['last_name_father'], FILTER_SANITIZE_STRING),
			"last_name_mother" => filter_var($_PUT['last_name_mother'], FILTER_SANITIZE_STRING),
			"email" => filter_var($_PUT['email'], FILTER_SANITIZE_STRING),
			"gender" => filter_var($_PUT['gender'], FILTER_SANITIZE_STRING),
			"birth_date" => filter_var($_PUT['birth_date'], FILTER_SANITIZE_STRING),
			"civil_status" => filter_var($_PUT['civil_status'], FILTER_SANITIZE_STRING),
			"occupation" => filter_var($_PUT['occupation'], FILTER_SANITIZE_STRING),
			"phone" => filter_var($_PUT['phone'], FILTER_SANITIZE_STRING),
			"street" => filter_var($_PUT['street'], FILTER_SANITIZE_STRING),
			"colony" => filter_var($_PUT['colony'], FILTER_SANITIZE_STRING),
			"zip_code" => filter_var($_PUT['zip_code'], FILTER_SANITIZE_STRING),
			"city" => filter_var($_PUT['city'], FILTER_SANITIZE_STRING),
			"patient_state" => filter_var($_PUT['patient_state'], FILTER_SANITIZE_STRING),
			"rfc" => filter_var($_PUT['rfc'], FILTER_SANITIZE_STRING),
			"consult_reason" => filter_var($_PUT['consult_reason'], FILTER_SANITIZE_STRING)
		);
	} else if ($action == "MODIFYPATIENTCHECKUP") {
		$arrayData = array(
			"family_diabetes" => filter_var($_PUT['family_diabetes'], FILTER_SANITIZE_STRING),
			"family_arterial_hypertension" => filter_var($_PUT['family_arterial_hypertension'], FILTER_SANITIZE_STRING),
			"family_cancer" => filter_var($_PUT['family_cancer'], FILTER_SANITIZE_STRING),
			"family_comment" => filter_var($_PUT['family_comment'], FILTER_SANITIZE_STRING),
			"diabetes" => filter_var($_PUT['diabetes'], FILTER_SANITIZE_STRING),
			"arterial_hypertension" => filter_var($_PUT['arterial_hypertension'], FILTER_SANITIZE_STRING),
			"cancer" => filter_var($_PUT['cancer'], FILTER_SANITIZE_STRING),
			"comment" => filter_var($_PUT['comment'], FILTER_SANITIZE_STRING),
			"alergies" => filter_var($_PUT['alergies'], FILTER_SANITIZE_STRING),
			"surgeries" => filter_var($_PUT['surgeries'], FILTER_SANITIZE_STRING),
			"results" => filter_var($_PUT['results'], FILTER_SANITIZE_STRING),
			"diagnosis" => filter_var($_PUT['diagnosis'], FILTER_SANITIZE_STRING),
			"treatment" => filter_var($_PUT['treatment'], FILTER_SANITIZE_STRING)
		);
	}

	$response = attemptModifyData($action, $arrayData, $data, $rol);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestRegisterNote()
{
	session_start();
	$uUpatientID = $_SESSION["patient_id"];

	$arrayData = array(
		"patient_id" => $uUpatientID,
		"doctorID" => filter_var($_POST['doctorID'], FILTER_SANITIZE_STRING),
		"evolution" => filter_var($_POST['evolution'], FILTER_SANITIZE_STRING),
		"treatment" => filter_var($_POST['treatment'], FILTER_SANITIZE_STRING)
	);

	$response = attemptRegisterNote($arrayData);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestNotes($action)
{
	if ($action == "ALLNOTES") {
		$uKeyword = "";
	} else if ($action == "SEARCHNOTE") {
		$uKeyword = filter_var($_GET['noteSearch'], FILTER_SANITIZE_STRING);
	} else if ($action == "SEARCHNOTEPATIENT") {
		session_start();
		$uKeyword = $_SESSION["username"];
	} else if ($action == "SEARCHNOTESPECIFIC") {
		session_start();
		$uKeyword = $_SESSION["patient_id"];
	}

	$response = attemptNotes($action, $uKeyword);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestNote()
{
	session_start();
	$data = $_SESSION["note_id"];

	$response = attemptNote($data);

	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestModifyNote()
{
	parse_str(file_get_contents("php://input"), $_PUT);
	session_start();
	$unote_id = $_SESSION["note_id"];

	$arrayData = array(
		"note_id" => $unote_id,
		"evolution" => $_PUT['evolution'],
		"treatment" => $_PUT['treatment'],
	);

	$response = attemptModifyNote($arrayData);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestDrPatientSESSION()
{
	$upatient_id = filter_var($_GET["patient_id"], FILTER_SANITIZE_STRING);
	$udo = filter_var($_GET["do"], FILTER_SANITIZE_STRING);

	session_start();

	$_SESSION["patient_id"] = $upatient_id;

	if (isset($_SESSION["patient_id"])) {
		$response = array("Patient" => $_SESSION["patient_id"], "do" => $udo);
		echo json_encode($response);
	} else {
		errorHandler("not set yet.", "409");
	}
}

function requestNotePatient()
{
	session_start();
	$data = $_SESSION["patient_id"];

	$response = attemptNotePatient($data);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}

function requestDrNoteSESSION()
{
	$unote_id = filter_var($_GET["note_id"], FILTER_SANITIZE_STRING);
	$udo = filter_var($_GET["do"], FILTER_SANITIZE_STRING);

	session_start();

	$_SESSION["note_id"] = $unote_id;

	if (isset($_SESSION["note_id"])) {
		$response = array("Note" => $_SESSION["note_id"], "do" => $udo);
		echo json_encode($response);
	} else {
		errorHandler("not set yet.", "409");
	}
}

function requestTrashSQL($action)
{

	parse_str(file_get_contents("php://input"), $_DELETE);
	session_start();
	if ($action == "TRASHNOTE") {
		$data = $_SESSION["note_id"];

	} else if ($action == "TRASHPACIENTE") {
		$data = $_SESSION["patient_id"];
	}


	$response = attemptTrashSQL($action, $data);
	if ($response["status"] == "SUCCESS") {
		echo json_encode($response["response"]);
	} else {
		errorHandler($response["status"], $response["code"]);
	}
}
function requestDrSession()
{
	session_start();
	if (isset($_SESSION["rol"])) {
		$uRol = $_SESSION["rol"];
		if ($uRol == "Doctor") {
			$response = array("Security" => "YES");
			echo json_encode($response);
		} else {
			session_destroy();
			errorHandler("Not Doctor.", "409");
		}

	} else {
		session_destroy();
		errorHandler("Not Active.", "409");
	}
}

function requestDrSessionFunc()
{
	session_start();
	if (isset($_SESSION["rol"])) {
		$uRol = $_SESSION["rol"];
		if ($uRol == "Doctor") {
			return true;
		} else {
			session_destroy();
			return false;
		}
	} else {
		session_destroy();
		return false;
	}
}

function requestPtSession()
{
	session_start();
	if (isset($_SESSION["rol"])) {
		$uRol = $_SESSION["rol"];
		if ($uRol == "Paciente") {
			$response = array("Security" => "YES");
			echo json_encode($response);
		} else {
			session_destroy();
			errorHandler("Not Pacient.", "409");
		}

	} else {
		session_destroy();
		errorHandler("Not Active.", "409");
	}
}

function logout()
{
	session_start();
	unset($_SESSION["username"]);
	unset($_SESSION["rol"]);
	unset($_SESSION["patient_id"]);
	unset($_SESSION["note_id"]);
	session_unset();
	session_destroy();
	$response = array("status" => "success");
	echo json_encode($response);
}

function errorHandler($status, $code)
{
	switch ($code) {
		case 406:
			header("HTTP/1.1 $code User $status");
			die("Wrong credentials provided");
			break;
		case 407:
			header("HTTP/1.1 $code Cookie $status");
			die("No cookies saved on this site");
			break;
		case 408:
			header("HTTP/1.1 $code User $status");
			die("Username already in use.");
			break;
		case 409:
			header("HTTP/1.1 $code Session $status");
			die("Your session has expired.");
			break;
		case 500:
			header("HTTP/1.1 $code $status. Bad connection, portal is down.");
			die("The server is down, we couldn't retrieve data from the data base");
			break;
	}
}

?>
