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
    $userInputOTP = isset($_POST['userInputOTP']) ? $_POST['userInputOTP'] : '';
    $clientId = isset($_POST['clientId']) ? $_POST['clientId'] : 0;
    $appType = isset($_POST['appType']) ? $_POST['appType'] : 2; // 2 = APP_TYPE_ANDROID
    $fcm_regId = isset($_POST['fcm_regId']) ? $_POST['fcm_regId'] : '';
    $lang = isset($_POST['lang']) ? $_POST['lang'] : '';
    // $accountId = isset($_POST['accountId']) ? $_POST['accountId'] : '';

    $phoneNumber = helper::clearText($phoneNumber);
    $phoneNumber = helper::escapeText($phoneNumber);

    $sessionKey = 'otp_' . $phoneNumber;
    $storedOTP = isset($_SESSION[$sessionKey]) ? $_SESSION[$sessionKey] : '';

    $ip_addr = helper::ip_addr();
    $currentTime = time();

    $accountModerateAt = 0;
    $accountPostModerateAt = $currentTime;

    $clientId = helper::clearInt($clientId);
    $appType = helper::clearInt($appType);

    $fcm_regId = helper::clearText($fcm_regId);
    $fcm_regId = helper::escapeText($fcm_regId);

    $lang = helper::clearText($lang);
    $lang = helper::escapeText($lang);


    if ($userInputOTP == $storedOTP) {
        

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $checkQuery = "SELECT users.*, access_data.accessToken
        FROM users 
        JOIN access_data ON users.id = access_data.accountId 
        WHERE users.phone = '$phoneNumber'";
        $checkResult = $conn->query($checkQuery);


        if ($checkResult->num_rows > 0) {
            $userInfo = $checkResult->fetch_assoc();
        
            if ($userInfo['fullname'] == null && $userInfo['dob'] == null) {
                $result = array(
                    "error" => false,
                    "user_info" => "Name and Dob is empty"
                );
               
                
            }
        
            // Phone number already exists in the database
            if ($userInfo['fullname'] != null && $userInfo['dob'] != null) {
            $result = array(
                "error" => false,
                "user_info" => $userInfo
            );
        }
           
        }
        
        
        else {
            $insertQuery = "INSERT INTO users (phone,otpVerified,ip_addr,accountPostModerateAt) VALUES ('$phoneNumber',1,'$ip_addr','$accountPostModerateAt')";
            $conn->query($insertQuery);
            
            // Getting the last inserted ID
            $accountId = $conn->insert_id;

            // $auth = new auth($conn);
            $result = $auth->create($accountId, $clientId, $appType, $fcm_regId, $lang);
            $accessToken = $result['accessToken'];
            
            

            $result = array(
                "error" => false,
                "message" => "OTP verification successful",
                "account_id"=>$accountId,
                "accessToken"=>$accessToken
                
            );
            unset($_SESSION[$sessionKey]);
        }

        $conn->close();
    } else {
        // Incorrect OTP
        $result = array(
            "error" => true,
            "message" => "Incorrect OTP"
        );
    }

    echo json_encode($result);
    exit;
}
