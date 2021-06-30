<?php
  require '../vendor/autoload.php';

  use Stripe\Stripe;

  $servername = env('DB_HOST', 'localhost');
  $username = env('DB_USERNAME', 'kei');
  $password = env('DB_PASSWORD', '123456789');
  $dbname = env('DB_DATABASE', 'fluensen');

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
      $stripe = new \Stripe\StripeClient("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");
      $transaction = $stripe->balanceTransactions->retrieve(
        $row['trans_id'],
        []
      );
      if($transaction->status == 'available') {
        $query = "UPDATE wallet_action SET status=1 WHERE trans_id='" .$row['trans_id'] . "';";
        echo $query;
        if($conn->query($query) === TRUE) {
          $wallet_id = $row['wallet_id'];
          $query = "SELECT users.stripe_id
                    FROM users
                    LEFT JOIN wallet_user ON users.id=wallet_user.user_id
                    WHERE wallet_id = " . $wallet_id . ";";
          $result = $conn->query($query);
          if($result->num_rows > 0) {
            while($userRow = $result->fetch_assoc()) {
              $stripe_id = $userRow['stripe_id'];
              \Stripe\Stripe::setApiKey('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');
              $transfer = \Stripe\Transfer::create([
                'amount' => $row['amount'] * 100,
                'currency' => strtolower($row['currency']),
                'destination' => $stripe_id,
              ]);
              $trans_id = $transfer->balance_transaction;
              $updateQuery = "UPDATE wallet_action
                              SET status = 2, trans_id = '" . $trans_id . "'
                              WHERE id =" . $row['id'] . ";";
              if($conn->query($updateQuery) === TRUE) {
                echo "SUCCESS";
              } else {
                echo "UPDATE FAILED";
              }
            }
          }
        } else {
          echo "FAILED";
        }
      } else {
        echo 'not avaliable';
      }
    }
  }
?>
