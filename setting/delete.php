<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailToDelete = $_POST['email'];

    // Baca data email dari file JSON
    $dataFile = 'data.json';
    $data = json_decode(file_get_contents($dataFile), true);

    // Cari dan hapus email
    foreach ($data as $key => $emailData) {
        if ($emailData['email'] === $emailToDelete) {
            unset($data[$key]);
            break;
        }
    }

    file_put_contents($dataFile, json_encode(array_values($data)));

    echo json_encode(['status' => 'success', 'message' => 'Email Berhasil Di Delete.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Makanya Ganteng.']);
}
?>
