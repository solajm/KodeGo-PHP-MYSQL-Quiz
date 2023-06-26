<?php



include "../api/config.php";


$query = "SELECT tweets.id, tweets.content, tweets.date_tweeted, users.firstname, users.lastname, tweets.user_id
          FROM tweets 
          INNER JOIN users ON tweets.user_id = users.id";
$result = $conn->query($query);

$tweets = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tweet = [
            'id' => $row['id'],
            'content' => $row['content'],
            'date_tweeted' => $row['date_tweeted'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'user_id' => $row['user_id']
        ];

        $tweets[] = $tweet;
    }
}


header('Content-Type: application/json');
echo json_encode($tweets);
?>
