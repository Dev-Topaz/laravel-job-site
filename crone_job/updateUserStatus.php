<?php

require '../vendor/autoload.php';

$servername = env('DB_HOST', 'localhost');
$username = env('DB_USERNAME', 'root');
$password = env('DB_PASSWORD', '');
$dbname = env('DB_DATABASE', 'fluensen');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$q = "SELECT * FROM sessions";
$result = $conn->query($q);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $now = gmdate("U");
    echo $now.'<br/>';
    echo $row['last_activity'].'<br/>';
    $interval = abs($now - $row['last_activity']);

    if ($interval >= 300 && isset($row['user_id'])) {
      $user_id = $row['user_id'];
      $query = "UPDATE users SET loggedIn=0 WHERE id=" . $user_id . ";";
      echo $query;
      echo $interval;
      if ($conn->query($query) === TRUE) {
        echo "INACTIVE SUCCESS<br/>";
      } else {
        echo "INACTIVE FAILED<br/>";
      }
    }
    if ($interval < 300 && isset($row['user_id'])) {
      echo $interval;
      $user_id = $row['user_id'];
      $query = "UPDATE users SET loggedIn=1 WHERE id=" . $user_id . ";";
      if ($conn->query($query) === TRUE) {
        echo "ACTIVE SUCCESS<br/>";
      } else {
        echo "ACTIVE FALIED<br/>";
      }
    }
  }
}
?>
