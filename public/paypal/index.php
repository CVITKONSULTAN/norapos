<?php

    require __DIR__  . '/vendor/autoload.php';

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    header('Content-Type: application/json; charset=utf-8');

    $servername = "localhost";
    $username = "root";
    $password = "ctiOusTHoATi";
    $dbname = "dashboard";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    //sandbox config
    $config = [
        "account"=>"sb-43enur8666691@personal.example.com",
        "client_id"=>"ARoDZw2MeRPYVUEk3LpMIgl927eRCesbm5-QB5uiSa3lGJnF7cR3wwA6Xq8g5yojKieTfTKXWGJ_3mMa",
        "secret"=>"EPxPjDwNwvur8n6abO03Wux5ODPOUmwbGPr18ZKEWbo3sarXojpiOvWCUZOityk9FCtDvOwLuhgisj2Z"
    ];

    $request = file_get_contents("php://input"); // gets the raw data
    $params = json_decode($request,true);

    $user_id = $params["user_id"] ?? 1;

    if(!isset($params["order_id"])){
        echo json_encode(["status"=>false,"message"=>"ERROR","data"=>"Bad Request"]);
        exit;
    }

    $url = 'https://tastypoints.io/akm/restapi.php';
    $api_key = "4425eff4dhsS@#";

    $body = $params;
    $body["api_key"] = $api_key;
    $body["payment_method"] = "Paypal";

    $ch = curl_init( $url );
    # Setup request to send json via POST.
    $payload = json_encode( ["input"=>$body] );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($result,true);
    $result = json_decode($result["data"],true);
    $total = $result["order_amount"];

    $live = true;

    if($live){
        //live config
        $config = [
            "account"=>"heru.m175@gmail.com",
            "client_id"=>"AXGmev3TUGdIiF7yok56Gq2Iy6ZAoxjJJJn-FB9BNrIEwYQkWWYSCW3wh-kKpcRqLqmnq83PIy9mLppY",
            "secret"=>"EMOn5BUQy0IFdH3KnCF2m5kxQ_UDMlk2JQMfb0mdfdvtGT1mb7iHL5t63gKfnu0HSRubYbc-1lG6nKNA"
        ];
    }

    $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $config["client_id"],
                $config["secret"]
            )
    );

    if($live){
        $apiContext->setConfig(
            array(
              'mode' => 'live'
            )
        );
    }

    $slug = generateRandomString(8);

    // After Step 2
    $payer = new \PayPal\Api\Payer();
    $payer->setPaymentMethod('paypal');

    $currency = 'USD';
    // echo $amount;
    $amount = new \PayPal\Api\Amount();
    $amount->setTotal($total);
    $amount->setCurrency($currency);

    $transaction = new \PayPal\Api\Transaction();
    $transaction->setAmount($amount);

    $main_url = "https://dashboard.tastypoints.io";
    $return_url = $main_url."/tastypointsapi/paypal/success/".$slug;
    $cancel_url = $main_url."/tastypointsapi/paypal/failed/".$slug;

    $redirectUrls = new \PayPal\Api\RedirectUrls();
    $redirectUrls->setReturnUrl($return_url)
        ->setCancelUrl($cancel_url);

    $payment = new \PayPal\Api\Payment();
    $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions(array($transaction))
        ->setRedirectUrls($redirectUrls);

    // After Step 3
    try {
        $payment->create($apiContext);
        $response = json_encode($payment->toArray());
        $sql = "INSERT INTO wallet_user_log_tests (user_id, origin, slug, id_payment, type,response) VALUES (".
        $user_id.", 'Paypal', '".
        $slug."','".
        $payment->id."','paypal', '".
        $response."' )";

        if ($conn->query($sql) === TRUE) {
            // echo json_encode($payment->toArray());
            echo json_encode([
                "status"=>true,
                "message"=>"OK",
                "url"=>$payment->getApprovalLink()
            ]);
        } else {
            $message = $sql . "<br>" . $conn->error;
            echo json_encode([
                "status"=>false,
                "message"=>"ERROR",
                "data"=>$message
            ]);
        }
        
        $conn->close();
        // echo $payment;
        // header('Location: '.$payment->getApprovalLink());
        // echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        // echo json_encode(["url"=>$payment->getApprovalLink()]);
    }
    catch (\PayPal\Exception\PayPalConnectionException $ex) {
        // This will print the detailed information on the exception.
        //REALLY HELPFUL FOR DEBUGGING
        $message = $ex->getData();
        echo json_encode([
            "status"=>false,
            "message"=>"ERROR",
            "data"=>$message
        ]);
    }


?>
