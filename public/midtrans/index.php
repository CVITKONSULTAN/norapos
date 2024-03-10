<?php

    require_once "../../vendor_midtrans/midtrans/midtrans-php/Midtrans.php";
    // require_once "./vendor/midtrans/midtrans-php/Midtrans.php";
    header('Content-Type: application/json');

    try {
        
        // $ip = $_SERVER['REMOTE_ADDR'];

        $live = false;

        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = $live;

        $key = "SB-Mid-server-LOrTnklwFV5riW1uZxbpncvT";
        $clientKey = "SB-Mid-client-ahMgqbw_plJKTikD";

        if($live){
            $clientKey = "Mid-client-M8TMyN1Sxyu7_bY2";
            $key = "Mid-server-KsRsdl6rXk-AUlI8WRkQqbfy";
        }

        $req_json = json_decode(file_get_contents('php://input'), true);
        if(!empty($req_json)) $_POST = $req_json;

        // if(
        //     !isset($_POST["key"]) ||
        //     !isset($_POST["data"]) 
        // ){
        //     echo json_encode(
        //         ["status"=>false,"message"=>"Bad request","data"=>$_POST]
        //     );
        //     exit;
        // }


        // if($clientKey !== $_POST["key"]) {
        //     echo json_encode(
        //         ["status"=>false,"message"=>"Your key declined"]
        //     );
        //     exit;
        // }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = $key;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $transaction_details = array(
            'order_id'    => time(),
            'gross_amount'  => 200000
        );

        // Populate items
        $items = array(
            array(
                'id'       => 'item1',
                'price'    => 100000,
                'quantity' => 1,
                'name'     => 'Adidas f50'
            ),
            array(
                'id'       => 'item2',
                'price'    => 50000,
                'quantity' => 2,
                'name'     => 'Nike N90'
            ));

        // Populate customer's billing address
        $billing_address = array(
            'first_name'   => "Muhammad",
            'last_name'    => "Khairudin",
            'address'      => "Karet Belakang 15A, Setiabudi.",
            'city'         => "Jakarta",
            'postal_code'  => "51161",
            'phone'        => "081322311801",
            'country_code' => 'IDN'
        );

        // Populate customer's shipping address
        $shipping_address = array(
            'first_name'   => "John",
            'last_name'    => "Watson",
            'address'      => "Bakerstreet 221B.",
            'city'         => "Jakarta",
            'postal_code'  => "51162",
            'phone'        => "081322311801",
            'country_code' => 'IDN'
        );

        // Populate customer's info
        $customer_details = array(
            'first_name'       => "Muhammad",
            'last_name'        => "Khairudin",
            'email'            => "m.khairudin@untanpay.com",
            'phone'            => "082255985321",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Token ID from checkout page
        $token_id = rand(1000,9999);

        // Transaction data to be sent
        $transaction_data = array(
            'transaction_details' => $transaction_details,
            'item_details'        => $items,
            'customer_details'    => $customer_details
        );

        $transaction_data = $_POST["data"] ?? $transaction_data;

        if(isset($transaction_data['item_details'])){
            unset($transaction_data['item_details']);
        }

        $response = \Midtrans\Snap::createTransaction($transaction_data)->redirect_url;
        $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);

        echo json_encode([
            "status"=>true,
            "token"=>$snapToken,
            "token_url"=>$response,
        ]);
    } catch (\Exception $e) {
        echo json_encode([
            "status"=>false,
            "message"=> $e->getMessage(),
            "data"=>$_POST
        ]);
    }
?>
