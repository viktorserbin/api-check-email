<?php
/**
 * Created by PhpStorm.
 * User: sinor
 * Date: 08.03.2018
 * Time: 16:32
 */
function mailboxlayer($email_address) {
    $access_key = ACCESS_KEY;

    $ch = curl_init('http://apilayer.net/api/check?access_key='.$access_key.'&email='.$email_address.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json = curl_exec($ch);
    curl_close($ch);

    $validationResult = json_decode($json, true);

    return $validationResult;
}