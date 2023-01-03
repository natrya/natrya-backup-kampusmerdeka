<?php

require_once "vendor/autoload.php";
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include "function.php";
$cfg = parse_ini_file("config.txt", true);
$token = $cfg["init"]["token"];
$programid = $cfg["init"]["programid"];
$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.kampusmerdeka.kemdikbud.go.id/v1alpha1/mentors/me/mentees?program_id=".$programid."&offset=0&limit=50",
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
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
$worksheet = $spreadsheet->setActiveSheetIndexByName('mentee');

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
        echo("ambil data mentee\n");
        $mentee="id kegiatan peserta,nama,email,universitas\n";
        $activity_id="";
        $jumlah=sizeof($hasil["data"]);
        for ($i=0;$i<$jumlah;$i++){
            $mentee.=$hasil["data"][$i]["id_reg_penawaran"].",".$hasil["data"][$i]["name"].",".$hasil["data"][$i]["email"].",".$hasil["data"][$i]["university_name"]."\n";
            $idmentee[$i]["id"]=$hasil["data"][$i]["id"];
            $idmentee[$i]["idkegiatan"]=$hasil["data"][$i]["id_reg_penawaran"];
            $idmentee[$i]["nama"]=$hasil["data"][$i]["name"];
            $activity_id=$hasil["data"][$i]["activity_id"];
            $activity=$hasil["data"][$i]["activity"];
            $worksheet->getCell('A'.($i+2))->setValue($i+1);
            $worksheet->getCell('B'.($i+2))->setValue($hasil["data"][$i]["id_reg_penawaran"]);
            $worksheet->getCell('C'.($i+2))->setValue($hasil["data"][$i]["name"]);
            $worksheet->getCell('D'.($i+2))->setValue($hasil["data"][$i]["email"]);
            $worksheet->getCell('E'.($i+2))->setValue($hasil["data"][$i]["university_name"]);
        }
        $cfg["init"]["activity_id"]=$activity_id;
        $cfg["init"]["activity"]=$activity;
        write_ini_file($cfg, 'config.txt', true);
        write_ini_file($idmentee, 'mentee.txt', true);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
		$filerekap='rangkuman.xls';
        $writer->save($filerekap);
    }
}
