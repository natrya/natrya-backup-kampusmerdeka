<?php

include "function.php";
require_once "confirm.php";
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
            $k=0;
            $submit=array();
            for ($j=0;$j<$jumlah;$j++){
                if ($hasil["data"][$j]["status"]=="SUBMITTED"){
                    echo "autoconfirm ".$mentee[$i]["nama"]."\n";
                    echo "Minggu ke-".$hasil["data"][$j]["counter"].PHP_EOL;
                    $kurang = 0;
                    $totalchild = sizeof ($hasil["data"][$j]["daily_reports"]); 
                    for ($k=0;$k < $totalchild;$k++)
                    {
                        if (str_word_count($hasil["data"][$j]["daily_reports"][$k]["report"]) < 20)
                        {
                            $kurang =1;
                            echo date('d F Y', strtotime($hasil["data"][$j]["daily_reports"][$k]["report_date"]))." kurang dari 20 kata".PHP_EOL;
                        }
                    }
                    if ($kurang == 0)
                    {
                        $submit[$k]=$hasil["data"][$j]["id"];
                        $k++;
                    }
                }
            }
            $jumsubmit=sizeof($submit);
            if ($jumsubmit > 0){
                foreach($submit as $key => $value)
                {
                   set_confirm($token,$submit[$key]); 
                }
            }
        }
    }
}

