<?php

include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_null($data)) {

        $email = isset($data['email']) ? $data['email'] : '';
        $firstname = isset($data['firstname']) ? $data['firstname'] : '';
        $lastname = isset($data['lastname']) ? $data['lastname'] : '';
        $birthdate = isset($data['birthdate']) ? $data['birthdate'] : '';


        if (!empty($email) || !empty($firstname) || !empty($lastname) || !empty($birthdate)) {

            $checkUserQuery = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($checkUserQuery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {

                $updateQuery = "UPDATE users SET ";

                $updateParams = [];
                $updateFields = [];

                if (!empty($firstname)) {
                    $updateFields[] = "firstname = ?";
                    $updateParams[] = $firstname;
                    setcookie('firstname', $firstname, time() + (86400 * 30), "/");
                }

                if (!empty($lastname)) {
                    $updateFields[] = "lastname = ?";
                    $updateParams[] = $lastname;
                    setcookie('lastname', $lastname, time() + (86400 * 30), "/");
                }

                if (!empty($birthdate)) {
                    $updateFields[] = "birthdate = ?";
                    $updateParams[] = $birthdate;
                    setcookie('birthdate', $birthdate, time() + (86400 * 30), "/");
                }

                $updateQuery .= implode(", ", $updateFields);
                $updateQuery .= " WHERE email = ?";
                $updateParams[] = $email;

                $stmt = $conn->prepare($updateQuery);
                $stmt->bind_param(str_repeat('s', count($updateParams)), ...$updateParams);

                if ($stmt->execute()) {
                 
                    $response = array(
                        'success' => true,
                        'message' => 'Profile updated.'
                    );
                } else {
                    // Failed to update profile
                    $response = array(
                        'success' => false,
                        'message' => 'Failed to update profile.',
                        'error' => $stmt->error
                    );
                }
            } else {
                
                $response = array(
                    'success' => false,
                    'message' => 'User does not exist.'
                );
            }
        } else {

            $response = array(
                'success' => false,
                'message' => 'Please provide at least one field for update.'
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Please provide valid input.'
        );
    }
} else {
    $response = array(
        'success' => false,
        'message' => 'Invalid request! Only POST requests are allowed.'
    );
}


header('Content-Type: application/json');
echo json_encode($response);
?>
