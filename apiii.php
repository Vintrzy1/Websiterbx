<?php
$subjek = $_POST['subjek'];
$pesan = $_POST['pesan'];

include 'setting/ser.php';

$sender = 'From: '.$nik.'<'.$sender.'>';
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= ''.$sender.'' . "\r\n";

$read = file_get_contents('setting/data.json');
$json = json_decode($read, true);

foreach ($json as $key => $emailData) {
    $result = mail($emailData['email'], $subjek, $pesan, $headers);

    if ($result) {
        $json[$key]['jumlahResult'] -= 1;
        
        if ($json[$key]['jumlahResult'] <= 0) {
            unset($json[$key]);
        }
    }
}

file_put_contents('setting/data.json', json_encode(array_values($json)));
?>
