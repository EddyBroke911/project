<?php 
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit;
}

/* CEK ADMIN */
if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit;
}

/* AMBIL SEMUA ORDER */
$data = mysqli_query($conn,
"SELECT * FROM orders ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#0f172a,#020617);
    color:white;
    overflow-x:hidden;
    padding-bottom:100px;
}

/* BACKGROUND */

body::before{
    content:"";
    position:absolute;
    width:400px;
    height:400px;
    background:#ef4444;
    filter:blur(150px);
    animation:move 12s infinite alternate;
    z-index:-1;
}

@keyframes move{
    0%{
        transform:translate(-150px,-150px);
    }

    100%{
        transform:translate(200px,200px);
    }
}

/* HEADER */

.header{
    padding:20px;
    font-size:22px;
    font-weight:bold;
    animation:fadeDown 0.8s ease;
}

@keyframes fadeDown{
    from{
        opacity:0;
        transform:translateY(-20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* CARD */

.card{
    background:rgba(30,41,59,0.6);
    backdrop-filter:blur(20px);
    margin:15px;
    padding:20px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
    animation:fadeUp 0.6s ease;
    transition:0.3s;
}

.card:hover{
    transform:scale(1.02);
}

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(30px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* FILE */

.file{
    font-size:14px;
    color:#38bdf8;
}

/* STATUS */

.status{
    padding:6px 12px;
    border-radius:12px;
    font-size:12px;
    display:inline-block;
    margin-top:5px;
}

.pending{
    background:#f59e0b;
}

.proses{
    background:#3b82f6;
}

.dicetak{
    background:#8b5cf6;
}

.dikirim{
    background:#06b6d4;
}

.selesai{
    background:#22c55e;
}

.batal{
    background:#ef4444;
}

/* EMPTY */

.empty{
    text-align:center;
    margin-top:60px;
    opacity:0.8;
    animation:fadeUp 1s ease;
}

/* BUTTON */

.btn{
    display:inline-block;
    margin-top:10px;
    padding:10px 15px;
    border-radius:10px;
    background:linear-gradient(135deg,#ef4444,#dc2626);
    text-decoration:none;
    color:white;
    font-size:12px;
    border:none;
    cursor:pointer;
}

/* SELECT */

select{
    width:100%;
    padding:12px;
    border-radius:12px;
    border:none;
    margin-top:10px;
    background:#1e293b;
    color:white;
}

/* NAVBAR */

.navbar{
    position:fixed;
    bottom:0;
    width:100%;
    background:rgba(30,41,59,0.8);
    backdrop-filter:blur(15px);
    display:flex;
    justify-content:space-around;
    padding:12px 0;
}

.navbar a{
    color:white;
    text-decoration:none;
    font-size:12px;
}

/* ========== MOBILE RESPONSIVE ========== */

/* TABLETS (768px and below) */
@media (max-width: 768px) {
    body::before {
        width: 300px;
        height: 300px;
    }
    
    .header {
        padding: 15px;
        font-size: 18px;
    }
    
    .card {
        margin: 12px;
        padding: 15px;
    }
    
    .status {
        font-size: 11px;
        padding: 5px 10px;
    }
    
    .btn {
        padding: 9px 12px;
        font-size: 11px;
    }
    
    .navbar a {
        font-size: 11px;
    }
}

/* MOBILE (480px and below) */
@media (max-width: 480px) {
    * {
        -webkit-tap-highlight-color: transparent;
    }
    
    body {
        font-size: 13px;
        padding-bottom: 80px;
    }
    
    body::before {
        width: 250px;
        height: 250px;
    }
    
    .header {
        padding: 12px;
        font-size: 16px;
        margin-bottom: 10px;
    }
    
    .card {
        margin: 10px;
        padding: 12px;
        border-radius: 15px;
    }
    
    .card p {
        font-size: 12px;
        margin: 5px 0;
        word-break: break-word;
    }
    
    .file {
        font-size: 12px;
        word-break: break-all;
    }
    
    .status {
        padding: 5px 8px;
        border-radius: 8px;
        font-size: 10px;
        display: inline-block;
        margin: 5px 2px 5px 0;
    }
    
    .btn {
        display: inline-block;
        margin-top: 8px;
        margin-right: 5px;
        padding: 8px 10px;
        font-size: 10px;
    }
    
    select {
        padding: 10px;
        font-size: 14px;
        margin-top: 8px;
    }
    
    .navbar {
        padding: 8px 0;
    }
    
    .navbar a {
        font-size: 10px;
        padding: 0 2px;
    }
    
    .empty {
        margin-top: 40px;
        font-size: 13px;
    }
    
    .empty h2 {
        font-size: 16px;
    }
}

/* SMALL PHONES (360px and below) */
@media (max-width: 360px) {
    body {
        padding-bottom: 70px;
    }
    
    .header {
        font-size: 14px;
        padding: 10px;
    }
    
    .card {
        margin: 8px;
        padding: 10px;
    }
    
    .btn {
        padding: 7px 9px;
        font-size: 9px;
        display: block;
        margin-top: 6px;
        margin-right: 0;
    }
    
    .navbar a {
        font-size: 9px;
    }
}


</style>

</head>

<body>

<div class="header">
    📄 Riwayat Semua Pesanan
</div>

<?php if(mysqli_num_rows($data) == 0){ ?>

<div class="empty">
    <h2>😴 Belum ada pesanan</h2>
</div>

<?php } ?>

<?php while($d = mysqli_fetch_array($data)){ 
    
    $statusClass = "pending";

    if($d['status'] == "Diproses") $statusClass = "proses";
    if($d['status'] == "Dicetak") $statusClass = "dicetak";
    if($d['status'] == "Dikirim") $statusClass = "dikirim";
    if($d['status'] == "Selesai") $statusClass = "selesai";
    if($d['status'] == "Batal") $statusClass = "batal";
?>

<div class="card">

    <p class="file">
        📁 <?= $d['file']; ?>
    </p>

    <p>
        🖨️ <?= $d['jumlah']; ?> cetak
    </p>

    <p>
        🎨 <?= $d['jenis']; ?>
    </p>

    <p>
        👤 User ID: <?= $d['user_id']; ?>
    </p>

    <p>
        Status:
        <span class="status <?= $statusClass ?>">
            <?= $d['status']; ?>
        </span>
    </p>

    <p style="font-size:12px; opacity:0.7;">
        🕒 <?= $d['tanggal']; ?>
    </p>

    <a href="uploads/<?= $d['file']; ?>" 
       class="btn" 
       download>
       ⬇ Download
    </a>

</div>

<?php } ?>

<!-- NAVBAR -->

<div class="navbar">

    <a href="dashboard_admin.php">
        🏠 Home
    </a>

    <a href="history_admin.php">
        📄 Riwayat
    </a>

    <a href="logout.php">
        🚪 Logout
    </a>

</div>

</body>
</html>