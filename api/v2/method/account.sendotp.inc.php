<?php

/*!
 * https://raccoonsquare.com
 * raccoonsquare@gmail.com
 *
 * Copyright 2012-2021 Demyanchuk Dmitry (raccoonsquare@gmail.com)
 */;

if (!defined("APP_SIGNATURE")) {

    header("Location: /");
    exit;
}

require_once 'sys/addons/vendor/autoload.php';

use Kreait\Firebase\Factory;

use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\ServiceAccount;

if (!empty($_POST)) {
    $phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';

    $phoneNumber = helper::clearText($phoneNumber);
    $phoneNumber = helper::escapeText($phoneNumber);

    if (empty($phoneNumber) || !ctype_digit($phoneNumber) || strlen($phoneNumber) < 10) {
        $result = array(
            "error" => true,
            "message" => 'Please Enter a valid Mobile Number ',
        );
    } else{
        $otp = rand(1111, 9999);

        $_SESSION['otp_' . $phoneNumber] = $otp;
    
        $result = array(
            "error" => false,
            "otp" => $otp,
        );
    }
    

   

    echo json_encode($result);
    exit;
}

