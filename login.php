<?php
include "function.php";
error_reporting(0);
require_once "profil.php";
if (getenv("MERDEKAUN")==""){
    echo "silahkan isi variabel environment MERDEKAUN.\nexport MERDEKAUN=email-mentor\n";
}else{
    if (getenv("MERDEKAPSS")==""){
        echo "silahkan isi variabel environment MERDEKAUN.\nexport MERDEKAPSS=password-mentor\n";
    }else{
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.kampusmerdeka.kemdikbud.go.id/v1alpha1/mentors/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"email\":\"".getenv("MERDEKAUN")."\",\"password\":\"".getenv("MERDEKAPSS")."\"}",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 63",
                "Content-Type: application/json",
                "Host: api.kampusmerdeka.kemdikbud.go.id",
                "Origin: https://mentor.kampusmerdeka.kemdikbud.go.id",
                "Pragma: no-cache",
                "Referer: https://mentor.kampusmerdeka.kemdikbud.go.id/",
                "User-Agent: Mozilla/5.0 "
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        //echo $response;
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $hasil=json_decode($response,true);
            if (isset($hasil["error"])){
                echo("username dan password tidak cocok\n");
            }else{
                echo("Login berhasil\n");
                $token=$hasil["data"]["access_token"];
                $cfg = parse_ini_file("config.txt", true);
                $cfg["init"]["token"]=$token;
                write_ini_file($cfg, 'config.txt', true);
                get_profile($token);
            }
        }
    }
}
