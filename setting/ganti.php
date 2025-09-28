<?php
header('Content-Type: application/json');

// Ambil dan filter input dari query string
$nik = isset($_GET['nick']) ? filter_var($_GET['nick'], FILTER_SANITIZE_STRING) : null;
$sender = isset($_GET['sender']) ? filter_var($_GET['sender'], FILTER_SANITIZE_STRING) : null;

if ($nik !== null && $sender !== null) {
    $pertama = "<?php \n";
    $terakhir = "?>";
    $path = "ser.php"; // Mengubah path file

    // Debugging: Menampilkan parameter yang diterima
    error_log("nick: " . $nik);
    error_log("sender: " . $sender);

    // Buka file dalam mode write (tulis)
    if ($put = fopen($path, "w")) {
        fwrite($put, $pertama);
        fwrite($put, "\n\$nik = \"$nik\";");
        fwrite($put, "\n\$sender = \"$sender\";");
        fwrite($put, "\n" . $terakhir);
        fclose($put);
        echo json_encode(['success' => true, 'message' => 'Data berhasil diubah.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal membuka file untuk ditulis.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parameter tidak valid atau kosong.']);
}
?>
