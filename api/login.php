<?php

include "../api/config.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the email, password, and birthdate from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];
    $password = $data['password'];

    // Prepare the statement
    $stmt = $conn->prepare("SELECT id, password, firstname, lastname, birthdate FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        $user_id = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $birthdate = $row['birthdate'];

        // Verify the provided password with the stored hashed password
        if (password_verify($password, $hashedPassword)) {
            // Fetch user information and associated tweets
            $stmt_user = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt_user->bind_param("s", $user_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();

            if ($result_user->num_rows === 1) {
                $user_row = $result_user->fetch_assoc();

                // Fetch tweets associated with the user
                $stmt_tweets = $conn->prepare("SELECT * FROM tweets WHERE user_id = ?");
                $stmt_tweets->bind_param("s", $user_id);
                $stmt_tweets->execute();
                $result_tweets = $stmt_tweets->get_result();

                $tweets = array();
                while ($tweet_row = $result_tweets->fetch_assoc()) {
                    $tweets[] = $tweet_row;
                }

                $response = array(
                    'success' => true,
                    'message' => 'Login successful.',
                    'redirect' => 'index.html', // Redirect to index.html
                    'user' => $user_row,
                    'tweets' => $tweets,
                    'user_id' => $user_id
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'User not found.'
                );
            }

            // Close the statement for user and tweets retrieval
            $stmt_user->close();
            $stmt_tweets->close();
        } else {
            $response = array(
                'success' => false,
                'message' => 'Invalid email or password.'
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Invalid email or password.'
        );
    }

    // Close the statement for email and password retrieval
    $stmt->close();
} else {
    $response = array(
        'success' => false,
        'message' => 'Invalid request! Only POST requests are allowed.'
    );
}

if ($response['success']) {
    setcookie('loggedIn', 'true', time() + (86400 * 30), '/'); 
    setcookie('user_id', $user_id, time() + (86400 * 30), '/'); 
    setcookie('firstname', $firstname, time() + (86400 * 30), '/'); 
    setcookie('lastname', $lastname, time() + (86400 * 30), '/'); 
    setcookie('email', $email, time() + (86400 * 30), '/'); 
    setcookie('birthdate', $birthdate, time() + (86400 * 30), '/'); 
} else {
    setcookie('loggedIn', '', time() - 3600, '/'); 
    setcookie('user_id', '', time() - 3600, '/'); 
    setcookie('firstname', '', time() - 3600, '/'); 
    setcookie('lastname', '', time() - 3600, '/'); 
    setcookie('email', '', time() - 3600, '/'); 
    setcookie('birthdate', '', time() - 3600, '/'); 
}


header('Content-Type: application/json');
echo json_encode($response);



?>
