<?php
  require './vendor/autoload.php';

  use Stripe\Stripe;

  $servername = env('DB_DATABASE', 'fluensen');
  $username = env('DB_USERNAME', 'root');
  $password = env('DB_PASSWORD', '');

  // Create connection
  $conn = new mysqli($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $q = "SELECT * FROM wallet_action WHERE status=0;";
  $result = $conn->query($q);

  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
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
