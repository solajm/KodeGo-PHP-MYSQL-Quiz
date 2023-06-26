<?php

include "../api/config.php";


$tweetID = $_POST['tweet_id'];
$userID = $_POST['user_id'];




$checkQuery = "SELECT * FROM tweets WHERE id = '$tweetID' AND user_id = '$userID'";
$checkResult = $conn->query($checkQuery);

if ($checkResult->num_rows > 0) {

    $deleteQuery = "DELETE FROM tweets WHERE id = '$tweetID'";

    if ($conn->query($deleteQuery) === TRUE) {

        $response = [
            'status' => 'success',
            'message' => 'Tweet deleted successfully'
        ];
    } else {

        $response = [
            'status' => 'error',
            'message' => 'Failed to delete tweet'
        ];
    }
} else {

    $response = [
        'status' => 'error',
        'message' => 'User does not own the tweet'
    ];
}


$conn->close();


header('Content-Type: application/json');
echo json_encode($response);
?>
