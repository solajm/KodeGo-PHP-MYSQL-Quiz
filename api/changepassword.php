<?php

include "config.php";


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  $password = $data['password'];
  $newPassword = $data['newPassword'];


  $userId = $_POST['userId']; 

  $sql = "SELECT password FROM users WHERE id = $userId";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

  
    if (password_verify($password, $storedPassword)) {

      $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

      $updateSql = "UPDATE users SET password = '$newPasswordHash' WHERE id = $userId";

      if ($conn->query($updateSql)) {
        $response = array(
          'success' => true,
          'message' => 'Change password successful.'
        );
      } else {
        $response = array(
          'success' => false,
          'message' => 'Failed to update password.'
        );
      }
    } else {
      $response = array(
        'success' => false,
        'message' => 'Invalid current password.'
      );
    }
  } else {
    $response = array(
      'success' => false,
      'message' => 'User not found.'
    );
  }

  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  echo "Invalid request! Only POST requests are allowed.";
}
?>
