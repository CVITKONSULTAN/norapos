<?php

    require __DIR__  . '/vendor/autoload.php';

    //sandbox config
    $config = [
        "account"=>$_GET["account"],
        "client_id"=>$_GET["client_id"],
        "secret"=>$_GET["secret"]
    ];

    $live = false;

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

    // After Step 2
    $payer = new \PayPal\Api\Payer();
    $payer->setPaymentMethod('paypal');

    $currency = 'USD';
    $total = $_GET["total"] ?? "1.00";
    // echo $amount;
    $amount = new \PayPal\Api\Amount();
    $amount->setTotal($total);
    $amount->setCurrency($currency);

    $transaction = new \PayPal\Api\Transaction();
    $transaction->setAmount($amount);

    $main_url = "https://tastypos.onprocess.work";
    $return_url = $main_url."/your_redirect_url.html";
    $cancel_url = $main_url."/your_cancel_url.html";

    $return_url = $_GET["return_url"];
    $cancel_url = $_GET["cancel_url"];


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
        echo $payment;
        // header('Location: '.$payment->getApprovalLink());
        // echo "\n\nRedirect user to approval_url: " . $payment->getApprovalLink() . "\n";
        // echo json_encode(["url"=>$payment->getApprovalLink()]);
    }
    catch (\PayPal\Exception\PayPalConnectionException $ex) {
        // This will print the detailed information on the exception.
        //REALLY HELPFUL FOR DEBUGGING
        echo $ex->getData();
    }


?>
