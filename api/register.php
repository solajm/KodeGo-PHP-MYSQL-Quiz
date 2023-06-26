<?php

include "../api/config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $email = $data['email'];
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $birthdate = $data['birthdate'];
    $password = $data['password'];


    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, birthdate, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstName, $lastName, $birthdate, $email, $password);
        $stmt->execute();

    
        if ($stmt->affected_rows > 0) {

            setcookie('loggedIn', 'true', time() + (86400 * 30), '/');

            $response = array(
                'success' => true,
                'message' => 'Registration successful.',
                'redirect' => 'index.html'
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            );
        }


        $stmt->close();
    } else {
        $response = array(
            'success' => false,
            'message' => 'Email already exists.'
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
