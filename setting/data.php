<?php
$dataFile = 'data.json';

// Baca data dari file JSON
$data = json_decode(file_get_contents($dataFile), true);

// Hapus email yang jumlah result-nya telah mencapai batas maksimum
foreach ($data as $key => $emailData) {
    if ($emailData['jumlahResult'] <= 0) {
        unset($data[$key]);
    }
}

// Simpan data yang telah difilter kembali ke file JSON
file_put_contents($dataFile, json_encode(array_values($data)));

// Kembalikan data sebagai respons JSON
echo json_encode(array_values($data));
?>
