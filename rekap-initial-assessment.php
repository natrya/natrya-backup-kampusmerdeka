<?php

require_once "vendor/autoload.php";
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include "function.php";
$cfg = parse_ini_file("config.txt", true);
$token = $cfg["init"]["token"];
$nama = $cfg["init"]["nama"];
$activity_id=$cfg["init"]["activity_id"];
$mentee = parse_ini_file("mentee.txt", true);
$jmlmentee=sizeof($mentee);
echo "ambil initial assessment\n";
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('rangkuman.xls');
$worksheet = $spreadsheet->setActiveSheetIndexByName('initial');
for ($i=0;$i<$jmlmentee;$i++){
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.kampusmerdeka.kemdikbud.go.id/v1alpha1/mentors/me/mentees/".$mentee[$i]["id"]."/activities/".$activity_id."/assessment",
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
            "User-Agent: Mozilla/5.0"
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
            $worksheet->getCell('A'.($i+4))->setValue($i+1);
            $worksheet->getCell('B'.($i+4))->setValue($mentee[$i]["idkegiatan"]);
            $worksheet->getCell('C'.($i+4))->setValue($mentee[$i]["nama"]);
            $worksheet->getCell('D'.($i+4))->setValue("Studi Independen Bersertifikat : Digital Transformation in The Government ");
            $worksheet->getCell('E'.($i+4))->setValue($nama);
            $jumlah=sizeof($hasil["data"]["modules"]);
            //if ($i==0){
                for ($j=0;$j<$jumlah;$j++){
                    $head[$j]=$hasil["data"]["modules"][$j]["name"];
                    $worksheet->getCell(chr(70+$j)."3")->setValue($hasil["data"]["modules"][$j]["name"]);   
                }
            //}
            $jumhead=sizeof($head);
            for ($j=0;$j<$jumhead;$j++){
                for ($k=0;$k<$jumlah;$k++){
                    if ($hasil["data"]["modules"][$k]["name"]==$head[$j]){
                        $worksheet->getCell(chr(70+$j).($i+4))->setValue($hasil["data"]["modules"][$k]["score"]);
                        break;
                    }
                }
            }
        }
    }
}
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
$filerekap='rangkuman.xls';
$writer->save($filerekap);

