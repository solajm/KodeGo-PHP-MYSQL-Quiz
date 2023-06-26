<?php

include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $content = $data['content'];
    $date_tweeted = $data['date_tweeted'];
    $user_id = $data['user_id'];

    $sql = "INSERT INTO tweets (content, date_tweeted, user_id) VALUES ('$content', '$date_tweeted', '$user_id')";

    if ($conn->query($sql)) {
        $response = array(
            'success' => true,
            'message' => 'Post successful.'
        );
        echo json_encode($response);
    } else {
        $response = array(   
            'success' => false,
            'message' => 'Failed to create post.'
        );
        echo json_encode($response);
    }
} else {
    echo "Invalid request! Only POST requests are allowed.";
}
?>