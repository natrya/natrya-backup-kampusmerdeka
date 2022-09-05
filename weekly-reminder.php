<?php

include "function.php";
$cfg = parse_ini_file("config.txt", true);
$token = $cfg["init"]["token"];
$activity_id=$cfg["init"]["activity_id"];
$mentee = parse_ini_file("mentee.txt", true);
$jmlmentee=sizeof($mentee);
for ($i=0;$i<$jmlmentee;$i++){
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.kampusmerdeka.kemdikbud.go.id/v1alpha1/mentors/me/mentees/".$mentee[$i]["id"]."/activities/".$activity_id."/weekly-reports",
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
            "User-Agent: Mozilla/5.0 "
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $hasil=json_decode($response,true);
        if (isset($hasil["error"])){
            if ($hasil["error"]["code"]==16)
            {
                echo("\nsilahkan login terlebih dahulu. php login.php\n");
            }
        }else{
            $jumlah=sizeof($hasil["data"]);
            $draft=0;
            for ($j=0;$j<$jumlah;$j++){
                if ($hasil["data"][$j]["status"]=="DRAFT"){
                    $draft++;
                }
            }
            echo $mentee[$i]["nama"]." kurang ".$draft."\n";
        }
    }
}

