<?php
include 'ser.php';
$config = include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Panel | Murni Putra</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Google Font (Roboto Condensed) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        body {
    font-family: 'Roboto Condensed', sans-serif;
    background: #d3d3d3; /* Set the background to light grey */
    color: #fff;
    padding-top: 20px;
    margin: 0;
}

.form-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
}

.jumbotron {
    padding: 16px;
    margin-bottom: 20px;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    text-align: center;
}

.navbar {
    background-color: rgba(0, 0, 0, 0.5);
    margin-bottom: 20px;
}

.form-control {
    background-color: rgba(0, 0, 0, 0.3);
    border: 1px solid #000;
    color: #fff;
}

.table-container {
    overflow-x: auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    background-color: rgba(0, 0, 0, 0.7);
    margin-top: 20px;
}

.table {
    background-color: rgba(0, 0, 0, 0.7);
    color: #fff;
    font-size: 14px;
}

.table th, .table td {
    border-color: #fff;
    padding: 8px;
    border: 1px solid #fff;
}

.btn {
    background-color: #28a745;
    border-color: #28a745;
    font-size: 14px;
    padding: 8px 16px;
    margin-bottom: 10px;
}

.btn:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

/* Gaya khusus untuk kolom Email Sender */
#panelMurni {
    background-color: rgba(0, 0, 0, 0.3);
}

/* Gaya untuk div tambah email */
.email-container {
    margin-bottom: 1rem;
}

.email-container input[type="email"],
.email-container input[type="number"] {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #fff;
    background-color: rgba(0, 0, 0, 0.3);
    color: #fff;
}

.email-container button {
    width: calc(100% - 20px);
}

/* Gaya untuk div container */
.container {
    margin-bottom: 1rem;
    max-width: 800px;
    margin: 60px auto;
    padding: 20px;
    border-radius: 8px;
}

.container input[type="text"],
.container input[type="number"] {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #fff;
    background-color: rgba(0, 0, 0, 0.3);
    color: #fff;
}

.container button {
    width: calc(100% - 20px);
}
    </style>
</head>
<body>

<div class="container">
    <div class="jumbotron">
        <label class="mt-3 block" for="namaResult">Nama Yang Diinginkan</label>
        <input type="text" id="namaResult" class="form-control rounded-lg mb-3" value="<?= htmlspecialchars($nik); ?>">
        <label class="block" for="panelMurni">Panel Murni</label>
        <input type="text" id="panelMurni" class="form-control rounded-lg mb-3" value="<?= htmlspecialchars($sender); ?>" readonly>
        <button id="gantiButton" class="btn btn-success btn-block mb-3">Ganti Data</button>
    </div>

    <div class="email-container">
        <div class="jumbotron">
            <label for="email" class="block mb-2">Tambah Email:</label>
            <input type="email" id="email" name="email" class="form-control rounded-lg mb-3" required>
            <label for="jumlahResult" class="block mb-2">Jumlah Result</label>
            <input type="number" id="jumlahResult" name="jumlahResult" class="form-control rounded-lg mb-3" value="1" required>
            <button id="addEmailButton" class="btn btn-success btn-block mb-3">Tambah Email</button>
        </div>

        <div style="background-color: rgba(0, 0, 0, 0.5); padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); margin-top: 20px;">
            <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">Emails:</h2>
            <div style="overflow-x: auto;">
                <table id="emailTable" class="table table-striped table-bordered" style="width: 100%; border-collapse: collapse;">
                    <thead style="background-color: rgba(0, 0, 0, 0.7); color: #fff;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #fff;">Email</th>
                        <th style="padding: 8px; border: 1px solid #fff;">Jumlah Result</th>
                        <th style="padding: 8px; border: 1px solid #fff;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody id="emailData"></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('gantiButton').addEventListener('click', function() {
            const namaResult = document.getElementById('namaResult').value.trim();
            const panelMurni = document.getElementById('panelMurni').value.trim();

            if (namaResult === "" || panelMurni === "") {
                alert("Nama Result dan Panel Murni tidak boleh kosong.");
                return;
            }

            gantiNamaResult(namaResult, panelMurni);
        });

        function gantiNamaResult(namaResult, panelMurni) {
            const url = `ganti.php?nick=${encodeURIComponent(namaResult)}&sender=${encodeURIComponent(panelMurni)}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            location.reload(); // Refresh halaman setelah mengganti data
                        });
                    } else {
                        Swal.fire({
                            title: "Gagal!",
                            text: data.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                })
                .catch(error => {
                    console.error('Error changing data:', error);
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan saat mengganti data.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });
        }

        fetchEmails();

        document.getElementById('addEmailButton').addEventListener('click', function() {
            const email = document.getElementById('email').value.trim();
            const jumlahResult = document.getElementById('jumlahResult').value.trim();

            if (email === "" || jumlahResult === "") {
                alert("Email dan Jumlah Result tidak boleh kosong.");
                return;
            }

            addEmail(email, jumlahResult);
        });
    });

    function fetchEmails() {
        fetch('data.php')
            .then(response => response.json())
            .then(data => {
                const emailData = document.getElementById('emailData');
                emailData.innerHTML = '';
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td style="padding: 8px; border: 1px solid #fff;">${item.email}</td>
                        <td style="padding: 8px; border: 1px solid #fff;">${item.jumlahResult}</td>
                        <td style="padding: 8px; border: 1px solid #fff;"><button class="btn btn-danger btn-sm" onclick="deleteEmail('${item.email}')">Hapus</button></td>
                    `;
                    emailData.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching emails:', error);
                Swal.fire({
                    title: "Error!",
                    text: "Terjadi kesalahan saat mengambil data email.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
    }

    function addEmail(email, jumlahResult) {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('jumlahResult', jumlahResult);

        fetch('add.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: "Berhasil!",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    fetchEmails(); // Refresh list email setelah tambah email berhasil
                });
            } else {
                Swal.fire({
                    title: "Gagal!",
                    text: data.message,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        })
        .catch(error => {
            console.error('Error adding email:', error);
            Swal.fire({
                title: "Error!",
                text: "Terjadi kesalahan saat menambah email.",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    }

    function deleteEmail(email) {
            fetch('delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}`,
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    fetchEmails(); // Refresh data setelah penghapusan
                })
                .catch(error => console.error('Error deleting email:', error));
        }
</script>

</body>
</html>
