<?php
// KONFIGURASI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "percetakan";

// BUAT KONEKSI
$conn = mysqli_connect($host, $user, $pass, $db);

// CEK KONEKSI
if (!$conn) {
    die("
    <style>
        body {
            font-family: sans-serif;
            background: #0f172a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .error {
            background: #1e293b;
            padding: 30px;
            border-radius: 20px;
        }
    </style>

    <div class='error'>
        <h2>❌ Koneksi Gagal</h2>
        <p>" . mysqli_connect_error() . "</p>
        <small>Cek database & XAMPP kamu bro 😅</small>
    </div>
    ");
}

// SET TIMEZONE (BIAR TANGGAL SESUAI)
date_default_timezone_set("Asia/Jayapura");

// OPTIONAL: SET CHARACTER (BIAR SUPPORT UTF-8)
mysqli_set_charset($conn, "utf8mb4");
?>