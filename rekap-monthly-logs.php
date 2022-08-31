<?php
require_once "vendor/autoload.php";
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
include "function.php";
require_once "daftarlogs.php";

$cfg = parse_ini_file("config.txt", true);
$token = $cfg["init"]["token"];
echo "ambil monthly logs\n";
$balikan=json_decode(get_logs($token),true);
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('rangkuman.xls');
$worksheet = $spreadsheet->setActiveSheetIndexByName('monthly');
for ($i=0;$i<sizeof($balikan["data"]);$i++){
    $idlogs = $balikan["data"][$i]["id"];
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.kampusmerdeka.kemdikbud.go.id/v1alpha1/mentors/monthly-logs/".$idlogs,
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
            echo("silahkan login terlebih dahulu\nphp login.php");
        }else{
            $worksheet->getCell('A'.($i+4))->setValue($hasil["data"]["period"]);
            $worksheet->getCell('B'.($i+4))->setValue(str_replace("- ","",$hasil["data"]["projects"],$hitung));
            $worksheet->getStyle('B'.($i+4))->getAlignment()->setWrapText(true);
            $worksheet->getCell('C'.($i+4))->setValue(str_replace("- ","",$hasil["data"]["guidances"],$hitung2));
            $worksheet->getStyle('C'.($i+4))->getAlignment()->setWrapText(true);
            $worksheet->getCell('D'.($i+4))->setValue($hasil["data"]["hours_spent"]);
        }
    }
}
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
$filerekap='rangkuman.xls';
$writer->save($filerekap);
