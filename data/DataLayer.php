<?php

function connect()
{
	$serverName = "localhost";
	$serverUserName = "root";
	$serverPassword = "UBvVavk62ZUnU4w";
	$databaseName = "dermasite";

	$connection = new mysqli($serverName, $serverUserName, $serverPassword, $databaseName);

	if ($connection->connect_error) {
		return null;
	} else {
		return $connection;
	}
}

function attemptLogin($username, $password)
{
	$conn = connect();

	if ($conn != null) {
		$sql = "SELECT U.username, U.passwrd, R.rol
							FROM User U, Rol R
							WHERE U.username='$username' AND R.username = U.username";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				if (password_verify($password, $row["passwrd"])) {
					$response = array("username" => $row["username"], "rol" => $row["rol"]);
					$conn->close();
					return array("status" => "SUCCESS", "response" => $response);
				} else {
					$conn->close();
					return array("status" => "WRONG_CREDENTIALS", "code" => 406);
				}
			}
		} else {
			$conn->close();
			return array("status" => "NOT_FOUND", "code" => 406);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR", "code" => 500);
	}
}

function attemptRegisterUser($arrayData)
{
	$conn = connect();
	if ($conn != null) {
		$uUsername = $arrayData['username'];

		$sql = "SELECT username
							FROM User
							WHERE username = '$uUsername'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$conn->close();
			return array("status" => "ALREADY_EXISTS", "code" => 408);
		} else {
			$uPassword = $arrayData['password'];
			$encriptedPassword = password_hash($uPassword, PASSWORD_DEFAULT);
			$sql = "INSERT INTO User (username, passwrd)
								VALUES ('$uUsername', '$encriptedPassword')";

			if (mysqli_query($conn, $sql)) {
				$response = array("status" => "Registered User", "username" => $uUsername);
				$conn->close();
				return array("status" => "SUCCESS", "response" => $response);
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_U", "code" => 500);
			}
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_U2", "code" => 500);
	}
}

function attemptRegisterRol($arrayData)
{
	$conn = connect();
	if ($conn != null) {
		$uUsername = $arrayData['username'];

		$sql = "SELECT username
							FROM Rol
							WHERE username = '$uUsername'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$conn->close();
			return array("status" => "ALREADY_EXISTS", "code" => 408);
		} else {
			$uRol = $arrayData['rol'];
			$sql = "INSERT INTO Rol (username, rol)
								VALUES ('$uUsername', '$uRol')";

			if (mysqli_query($conn, $sql)) {
				$response = array("status" => "Registered Rol", "username" => $uUsername);
				$conn->close();
				return array("status" => "SUCCESS", "response" => $response);
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_R", "code" => 500);
			}
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_R2", "code" => 500);
	}
}

function attemptRegisterPatient($arrayData)
{
	$conn = connect();
	if ($conn != null) {
		$uUsername = $arrayData['username'];

		$sql = "SELECT username
							FROM Patient
							WHERE username = '$uUsername'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$conn->close();
			return array("status" => "ALREADY_EXISTS", "code" => 408);
		} else {
			$ufirst_name = $arrayData['first_name'];
			$ulast_name_father = $arrayData['last_name_father'];
			$ulast_name_mother = $arrayData['last_name_mother'];
			$ubirth_date = $arrayData['birth_date'];
			$uemail = $arrayData['email'];
			$ugender = $arrayData['gender'];
			$ucivil_status = $arrayData['civil_status'];
			$uoccupation = $arrayData['occupation'];
			$uphone = $arrayData['phone'];
			$ustreet = $arrayData['street'];
			$ucolony = $arrayData['colony'];
			$uzip_code = $arrayData['zip_code'];
			$ucity = $arrayData['city'];
			$upatient_state = $arrayData['patient_state'];
			$urfc = $arrayData['rfc'];
			$uconsult_reason = $arrayData['consult_reason'];

			$sql = "INSERT INTO Patient (username, first_name, last_name_father, last_name_mother, birth_date,
																		 email, gender, civil_status, occupation, phone, street,
																		 colony, zip_code, city, patient_state, rfc, consult_reason)
								VALUES ('$uUsername', '$ufirst_name','$ulast_name_father','$ulast_name_mother', '$ubirth_date',
												'$uemail','$ugender','$ucivil_status','$uoccupation','$uphone','$ustreet',
												'$ucolony','$uzip_code','$ucity','$upatient_state','$urfc','$uconsult_reason')";

			if (mysqli_query($conn, $sql)) {
				$response = array("status" => "Registered Patient", "username" => $uUsername);
				$conn->close();
				return array("status" => "SUCCESS", "response" => $response);
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_P", "code" => 500);
			}
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_P2", "code" => 500);
	}
}

function attemptRegisterDr($arrayData)
{
	$conn = connect();
	if ($conn != null) {
		$uUsername = $arrayData['username'];

		$sql = "SELECT username
							FROM Doctor
							WHERE username = '$uUsername'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$conn->close();
			return array("status" => "ALREADY_EXISTS", "code" => 408);
		} else {
			$ufirst_name = $arrayData['first_name'];
			$ulast_name_father = $arrayData['last_name_father'];
			$ulast_name_mother = $arrayData['last_name_mother'];

			$sql = "INSERT INTO Doctor (username, doctor_name, doctor_last_name_father, doctor_last_name_mother)
								VALUES ('$uUsername', '$ufirst_name','$ulast_name_father','$ulast_name_mother')";

			if (mysqli_query($conn, $sql)) {
				$response = array("status" => "Registered Doctor", "username" => $uUsername);
				$conn->close();
				return array("status" => "SUCCESS", "response" => $response);
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_P", "code" => 500);
			}
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_P2", "code" => 500);
	}
}

function attemptRegisterCheckUp($arrayData)
{
	$conn = connect();
	if ($conn != null) {
		$uUsername = $arrayData['username'];

		$sql = "SELECT username
							FROM Checkup
							WHERE username = '$uUsername'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$conn->close();
			return array("status" => "ALREADY_EXISTS", "code" => 408);
		} else {
			$sql = "SELECT patient_id
								FROM Patient
								WHERE username = '$uUsername'";

			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$uPatient_id = $row["patient_id"];
				}

				$family_diabetes = $arrayData['family_diabetes'];
				$family_arterial_hypertension = $arrayData['family_arterial_hypertension'];
				$family_cancer = $arrayData['family_cancer'];
				$family_comment = $arrayData['family_comment'];
				$diabetes = $arrayData['diabetes'];
				$arterial_hypertension = $arrayData['arterial_hypertension'];
				$cancer = $arrayData['cancer'];
				$comment = $arrayData['comment'];
				$alergies = $arrayData['alergies'];
				$surgeries = $arrayData['surgeries'];
				$results = $arrayData['results'];
				$diagnosis = $arrayData['diagnosis'];
				$treatment = $arrayData['treatment'];

				$sql = "INSERT INTO Checkup (patient_id, username, family_diabetes, family_arterial_hypertension,
																			 family_cancer, family_comment, diabetes, arterial_hypertension,
																			 cancer, comment, alergies, surgeries, results, diagnosis, treatment)
									VALUES ('$uPatient_id', '$uUsername','$family_diabetes','$family_arterial_hypertension',
													'$family_cancer','$family_comment','$diabetes','$arterial_hypertension',
													'$cancer','$comment','$alergies','$surgeries','$results','$diagnosis','$treatment')";
				if (mysqli_query($conn, $sql)) {
					$response = array("status" => "Registered CheckUP", "username" => $uUsername);
					$conn->close();
					return array("status" => "SUCCESS", "response" => $response);
				} else {
					return array("status" => "INTERNAL_SERVER_ERROR_C", "code" => 500);
				}
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_CP", "code" => 500);
			}
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_P2", "code" => 500);
	}
}

function attemptAllPatients()
{
	$conn = connect();
	if ($conn != null) {

		$sql = "SELECT patient_id, first_name, last_name_father, last_name_mother, gender, birth_date
							FROM Patient
							ORDER BY patient_id";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$response = array();
			while ($row = $result->fetch_assoc()) {
				array_push($response, array(
					"patient_id" => $row["patient_id"],
					"first_name" => $row["first_name"],
					"last_name_father" => $row["last_name_father"],
					"last_name_mother" => $row["last_name_mother"],
					"gender" => $row["gender"],
					"birth_date" => $row["birth_date"]
				));
			}
			return array("status" => "SUCCESS", "response" => $response);
		} else {
			return array("status" => "INTERNAL_SERVER_ERROR", "code" => 500);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR", "code" => 500);
	}
}

function attemptSearchPatient($userSearch)
{
	$conn = connect();
	if ($conn != null) {
		$sql = "SELECT *
							FROM Patient
							WHERE patient_id = '$userSearch' OR first_name = '$userSearch'
										OR last_name_father = '$userSearch'
										OR last_name_mother = '$userSearch'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$response = array();
			while ($row = $result->fetch_assoc()) {
				array_push($response, array(
					"patient_id" => $row["patient_id"],
					"first_name" => $row["first_name"],
					"last_name_father" => $row["last_name_father"],
					"last_name_mother" => $row["last_name_mother"],
					"gender" => $row["gender"],
					"birth_date" => $row["birth_date"]
				));
			}
			return array("status" => "SUCCESS", "response" => $response);
		} else {
			$conn->close();
			return array("status" => "NOT_FOUND", "code" => 406);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERRORSP", "code" => 500);
	}
}

function attemptPatientInfo($action, $data)
{
	$conn = connect();
	if ($conn != null) {
		if ($action == "SELFPATIENTINFO") {
			$sql = "SELECT username
								FROM Patient
								WHERE username = '$data'";

		} else {
			$sql = "SELECT username
								FROM Patient
								WHERE patient_id = '$data'";
		}

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$userSearch = $row["username"];
			}

			if ($action == "PATIENTINFO" || $action == "SELFPATIENTINFO") {
				$sql = "SELECT U.username, R.rol
									FROM User U, Rol R
									WHERE U.username = R.username AND
									U.username = '$userSearch' AND
									R.Rol = 'Paciente'";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$sql = "SELECT *
										FROM Patient
										WHERE username = '$userSearch'";

					$response = array();
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						array_push($response, array(
							"patient_id" => $row["patient_id"],
							"username" => $row["username"],
							"creation_date" => $row["creation_date"],
							"first_name" => $row["first_name"],
							"last_name_father" => $row["last_name_father"],
							"last_name_mother" => $row["last_name_mother"],
							"email" => $row["email"],
							"gender" => $row["gender"],
							"birth_date" => $row["birth_date"],
							"civil_status" => $row["civil_status"],
							"occupation" => $row["occupation"],
							"phone" => $row["phone"],
							"street" => $row["street"],
							"colony" => $row["colony"],
							"zip_code" => $row["zip_code"],
							"city" => $row["city"],
							"patient_state" => $row["patient_state"],
							"rfc" => $row["rfc"],
							"consult_reason" => $row["consult_reason"],
						));
					}
					return array("status" => "SUCCESS", "response" => $response);
				} else {
					$conn->close();
					return array("status" => "NOT_FOUND", "code" => 406);
				}
			} else if ($action == "PATIENTCHECKUP") {
				$sql = "SELECT *
									FROM Checkup
									WHERE username = '$userSearch'";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$response = array();
					while ($row = $result->fetch_assoc()) {
						array_push($response, array(
							"family_diabetes" => $row["family_diabetes"],
							"family_arterial_hypertension" => $row["family_arterial_hypertension"],
							"family_cancer" => $row["family_cancer"],
							"family_comment" => $row["family_comment"],
							"diabetes" => $row["diabetes"],
							"arterial_hypertension" => $row["arterial_hypertension"],
							"cancer" => $row["cancer"],
							"comment" => $row["comment"],
							"alergies" => $row["alergies"],
							"surgeries" => $row["surgeries"],
							"results" => $row["results"],
							"diagnosis" => $row["diagnosis"],
							"treatment" => $row["treatment"],
						));
					}
					return array("status" => "SUCCESS", "response" => $response);
				} else {
					$conn->close();
					return array("status" => "NOT_FOUND", "code" => 406);
				}
			}
		} else {
			return array("status" => "INTERNAL_SERVER_ERRORPIN", "code" => 500);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERRORPI", "code" => 500);
	}
}

function attemptModifyData($action, $arrayData, $data, $rol)
{
	$conn = connect();
	if ($conn != null) {
		if ($rol == "Paciente") {
		} else {
			$sql = "SELECT username
								FROM Patient
								WHERE patient_id = '$data'";

			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$data = $row["username"];
				}
			}
		}
		if ($action == "MODIFYANYUSERPASSWORD") {

			$uPassword = $arrayData['password'];
			$encriptedPassword = password_hash($uPassword, PASSWORD_DEFAULT);
			$sql = "UPDATE User
								SET passwrd = '$encriptedPassword'
								WHERE username = '$data'";

			if (mysqli_query($conn, $sql)) {
				$conn->close();
				$response = array("status" => "SUCCESS", "action" => "Password Modified");
				return $response;
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_MDPP", "code" => 500);
			}
		} else if ($action == "MODIFYPATIENTINFO") {
			$ufirst_name = $arrayData['first_name'];
			$ulast_name_father = $arrayData['last_name_father'];
			$ulast_name_mother = $arrayData['last_name_mother'];
			$ubirth_date = $arrayData['birth_date'];
			$uemail = $arrayData['email'];
			$ugender = $arrayData['gender'];
			$ucivil_status = $arrayData['civil_status'];
			$uoccupation = $arrayData['occupation'];
			$uphone = $arrayData['phone'];
			$ustreet = $arrayData['street'];
			$ucolony = $arrayData['colony'];
			$uzip_code = $arrayData['zip_code'];
			$ucity = $arrayData['city'];
			$upatient_state = $arrayData['patient_state'];
			$urfc = $arrayData['rfc'];
			$uconsult_reason = $arrayData['consult_reason'];

			$sql = "UPDATE Patient
								SET first_name = '$ufirst_name', last_name_father = '$ulast_name_father',
										last_name_mother= '$ulast_name_mother', birth_date = '$ubirth_date',
										email = '$uemail', gender = '$ugender', civil_status = '$ucivil_status',
										occupation = '$uoccupation', phone = '$uphone', street = '$ustreet',
										colony = '$ucolony', zip_code = '$uzip_code', city = '$ucity',
										patient_state = '$upatient_state', rfc = '$urfc',
										consult_reason = '$uconsult_reason'
								WHERE username = '$data'";

			if (mysqli_query($conn, $sql)) {
				$conn->close();
				$response = array("status" => "SUCCESS", "action" => "Patient Modified");
				return $response;
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_MDPI", "code" => 500);
			}
		} else if ($action == "MODIFYPATIENTCHECKUP") {
			$family_diabetes = $arrayData['family_diabetes'];
			$family_arterial_hypertension = $arrayData['family_arterial_hypertension'];
			$family_cancer = $arrayData['family_cancer'];
			$family_comment = $arrayData['family_comment'];
			$diabetes = $arrayData['diabetes'];
			$arterial_hypertension = $arrayData['arterial_hypertension'];
			$cancer = $arrayData['cancer'];
			$comment = $arrayData['comment'];
			$alergies = $arrayData['alergies'];
			$surgeries = $arrayData['surgeries'];
			$results = $arrayData['results'];
			$diagnosis = $arrayData['diagnosis'];
			$treatment = $arrayData['treatment'];

			$sql = "SELECT username
							FROM Checkup
							WHERE username = '$data'";

			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				$sql = "UPDATE Checkup
						SET family_diabetes = '$family_diabetes', family_arterial_hypertension = '$family_arterial_hypertension',
								family_cancer = '$family_cancer', family_comment = '$family_comment',
								diabetes = '$diabetes', arterial_hypertension = '$arterial_hypertension',
								cancer = '$cancer', comment = '$comment', alergies = '$alergies',
								surgeries = '$surgeries', results = '$results', diagnosis = '$diagnosis',treatment = '$treatment'
						WHERE username = '$data'";

				if (mysqli_query($conn, $sql)) {
					$conn->close();
					$response = array("status" => "SUCCESS", "action" => "CheckUp Modified");
					return $response;
				} else {
					return array("status" => "INTERNAL_SERVER_ERROR_MDPC", "code" => 500);
				}
			} else {
				$sql = "SELECT patient_id
								FROM Patient
								WHERE username = '$data'";

				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$uPatient_id = $row["patient_id"];
					}

					$sql = "INSERT INTO Checkup (patient_id, username, family_diabetes, family_arterial_hypertension,
																			 family_cancer, family_comment, diabetes, arterial_hypertension,
																			 cancer, comment, alergies, surgeries, results, diagnosis, treatment)
									VALUES ('$uPatient_id', '$data','$family_diabetes','$family_arterial_hypertension',
													'$family_cancer','$family_comment','$diabetes','$arterial_hypertension',
													'$cancer','$comment','$alergies','$surgeries','$results', '$diagnosis', '$treatment')";
					if (mysqli_query($conn, $sql)) {
						$response = array("status" => "Registered CheckUP", "username" => $data);
						$conn->close();
						return array("status" => "SUCCESS", "response" => $response);
					} else {
						return array("status" => "INTERNAL_SERVER_ERROR_X", "code" => 500);
					}
				} else {
					$conn->close();
					return array("status" => "INTERNAL_SERVER_ERROR_Y", "code" => 500);
				}
			}
		} else {
			return array("status" => "INTERNAL_SERVER_ERROR_MD", "code" => 500);
		}
	}
}

function attemptRegisterNote($arrayData)
{
	$conn = connect();
	if ($conn != null) {
		$uUpatientID = $arrayData['patient_id'];

		$sql = "SELECT username
							FROM Patient
							WHERE patient_id = '$uUpatientID'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$udoctorID = $arrayData['doctorID'];
			$uevolution = $arrayData['evolution'];
			$utreatment = $arrayData['treatment'];

			$sql = "INSERT INTO Note (doctor_id, patient_id, evolution, treatment)
								VALUES ('$udoctorID', '$uUpatientID', '$uevolution', '$utreatment')";

			if (mysqli_query($conn, $sql)) {
				$response = array("status" => "Registered Note", "patient_id" => $uUpatientID);
				$conn->close();
				return array("status" => "SUCCESS", "response" => $response);
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_N1", "code" => 500);
			}

		} else {
			$conn->close();
			return array("status" => "PATIENT_MISSING", "code" => 408);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_N2", "code" => 500);
	}
}

function attemptNotes($action, $uKeyword)
{
	$conn = connect();
	if ($conn != null) {
		if ($action == "ALLNOTES") {
			$sql = "SELECT P.patient_id, P.first_name, P.last_name_father,
											 P.last_name_mother, N.evolution, N.treatment,
											 N.creation_date, N.note_id
							  FROM Patient P, Note N
								WHERE P.patient_id = N.patient_id
								ORDER BY P.patient_id, N.creation_date";
		} else if ($action == "SEARCHNOTE") {
			$sql = "SELECT P.patient_id, P.first_name, P.last_name_father,
											 P.last_name_mother, N.evolution, N.treatment,
											 N.creation_date, N.note_id
							  FROM Patient P, Note N
								WHERE P.patient_id = N.patient_id AND ((P.patient_id = '$uKeyword')
								OR (P.first_name = '$uKeyword') OR (P.last_name_father = '$uKeyword')
								OR (P.last_name_mother = '$uKeyword'))
								ORDER BY P.patient_id, N.creation_date";
		} else if ($action == "SEARCHNOTEPATIENT") {
			$sql = "SELECT P.patient_id, P.first_name, P.last_name_father,
											 P.last_name_mother, N.evolution, N.treatment,
											 N.creation_date, N.note_id
								FROM Patient P, Note N
								WHERE P.patient_id = N.patient_id AND P.username = '$uKeyword'
								ORDER BY P.patient_id, N.creation_date";
		} else if ($action == "SEARCHNOTESPECIFIC") {
			$sql = "SELECT P.patient_id, P.first_name, P.last_name_father,
											 P.last_name_mother, N.evolution, N.treatment,
											 N.creation_date, N.note_id
								FROM Patient P, Note N
								WHERE P.patient_id = N.patient_id AND N.patient_id ='$uKeyword'
								ORDER BY P.patient_id, N.creation_date";
		}
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$response = array();
			while ($row = $result->fetch_assoc()) {
				array_push($response, array(
					"patient_id" => $row["patient_id"],
					"first_name" => $row["first_name"],
					"last_name_father" => $row["last_name_father"],
					"last_name_mother" => $row["last_name_mother"],
					"evolution" => $row["evolution"],
					"treatment" => $row["treatment"],
					"note_id" => $row["note_id"],
					"creation_date" => $row["creation_date"]
				));
			}
			return array("status" => "SUCCESS", "response" => $response);
		} else {
			return array("status" => "INTERNAL_SERVER_ERRORANQ", "code" => 500);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERRORAN", "code" => 500);
	}
}

function attemptNote($data)
{
	$conn = connect();
	if ($conn != null) {

		$sql = "SELECT P.patient_id, P.first_name, P.last_name_father,
										 P.last_name_mother, N.evolution, N.treatment
							FROM Patient P, Note N
							WHERE P.patient_id = N.patient_id AND N.note_id = '$data'
							ORDER BY P.patient_id, N.creation_date";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$response = array();
			while ($row = $result->fetch_assoc()) {
				array_push($response, array(
					"complete_name" => ($row["first_name"] . " " . $row["last_name_father"]
						. " " . $row["last_name_mother"]),
					"evolution" => $row["evolution"],
					"treatment" => $row["treatment"]
				));
			}
			return array("status" => "SUCCESS", "response" => $response);
		} else {
			$conn->close();
			return array("status" => "NOT_FOUND_NOTE", "code" => 406);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERRORAN", "code" => 500);
	}
}

function attemptModifyNote($arrayData)
{
	$conn = connect();
	if ($conn != null) {

		$unote_id = $arrayData['note_id'];
		$uevolution = $arrayData['evolution'];
		$utreatment = $arrayData['treatment'];

		$sql = "UPDATE Note
							SET evolution = '$uevolution', treatment = '$utreatment'
							WHERE note_id = '$unote_id'";

		if (mysqli_query($conn, $sql)) {
			$conn->close();
			$response = array("status" => "SUCCESS", "action" => "NOTE Modified");
			return $response;
		} else {
			return array("status" => "INTERNAL_SERVER_ERROR_MN", "code" => 500);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_MN2", "code" => 500);
	}
}

function attemptNotePatient($data)
{
	$conn = connect();
	if ($conn != null) {

		$sql = "SELECT first_name, last_name_father, last_name_mother
							FROM Patient
							WHERE patient_id = '$data'";

		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$response = array("name" => $row["first_name"] . " " .
					$row["last_name_father"] . " " . $row["last_name_mother"]);
			}
			return array("status" => "SUCCESS", "response" => $response);
		} else {
			$conn->close();
			return array("status" => "NOT_FOUND_PATIENTNP", "code" => 406);
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERRORNP", "code" => 500);
	}
}

function attemptTrashSQL($action, $data)
{
	$conn = connect();
	if ($conn != null) {
		if ($action == "TRASHNOTE") {

			$sql = "DELETE
								FROM Note
								WHERE note_id = '$data'";

			if (mysqli_query($conn, $sql)) {
				$conn->close();
				$response = array("status" => "SUCCESS", "action" => "NOTE DELETED");
				return $response;
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_TSQ", "code" => 500);
			}
		} else if ($action == "TRASHPACIENTE") {

			$sql = "SELECT username
								FROM Patient
								WHERE patient_id = '$data'";

			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$uUsername = $row["username"];
				}
				$sql = "DELETE
									FROM Note
									WHERE patient_id = '$data';";

				$sql .= "DELETE
									FROM Checkup
									WHERE patient_id = '$data';";

				$sql .= "DELETE
									FROM Patient
									WHERE patient_id = '$data';";

				$sql .= "DELETE
									FROM Rol
									WHERE username = '$uUsername';";

				$sql .= "DELETE
								  FROM User
								  WHERE username = '$uUsername'";

				if (mysqli_multi_query($conn, $sql)) {
					$response = array("status" => "SUCCESS", "action" => "PATIENT DELETED");
					return $response;
				} else {
					return array("status" => "INTERNAL_SERVER_ERROR_TSQ", "code" => 500);
				}
			} else {
				return array("status" => "INTERNAL_SERVER_ERROR_TSP", "code" => 500);
			}
		}
	} else {
		return array("status" => "INTERNAL_SERVER_ERROR_TSQC", "code" => 500);
	}
}
?>
