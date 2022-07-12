<?php

function get_logs($token){
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.kampusmerdeka.kemdikbud.go.id/v1alpha1/mentors/monthly-logs",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8",
            "Authorization: Bearer ".$token,
            "Cache-Control: no-cache",
            "Connection: keep-alive",
            "Host: api.kampusmerdeka.kemdikbud.go.id",
            "Origin: https://mentor.kampusmerdeka.kemdikbud.go.id",
            "Pragma: no-cache",
            "Referer: https://mentor.kampusmerdeka.kemdikbud.go.id/",
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.4 Safari/605.1.15"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
        return null;
    } else {
        return $response;
    }
}
