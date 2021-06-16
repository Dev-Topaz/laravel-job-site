<?php
  require '../vendor/autoload.php';

  use Stripe\Stripe;

  $servername = env('DB_HOST', 'localhost');
  $username = env('DB_USERNAME', 'flueqdmm_fluenser');
  $password = env('DB_PASSWORD', 'o5BY9zL%V3ER');
  $dbname = env('DB_DATABASE', 'flueqdmm_fluenser');

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $q = "SELECT * FROM wallet_action WHERE status=0";
  $result = $conn->query($q);

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $stripe = new \Stripe\StripeClient("sk_test_51HtrYKJyHziuhAX0uMQgZHEge3g1aZgdaqKLLbg7mfIFbtfY9q9SAizZ2Ubm31YGAbBScwOx16TjcvLABGBvWKl500mudZwvxu");
      $transaction = $stripe->balanceTransactions->retrieve(
        $row['trans_id'],
        []
      );
      if($transaction->status == 'available') {
        $query = "UPDATE wallet_action SET status=1 WHERE trans_id='" .$row['trans_id'] . "';";
        if($conn->query($query) === TRUE) {
          echo 'SUCCESS';
        } else {
          echo "FAILED";
        }
      }
    }
  }

?>
