<?php 
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit;
}

if($_SESSION['role'] == 'admin'){
    header("Location: admin_dashboard.php");
    exit;
}

$id = $_SESSION['id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));

$q = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE user_id='$id'");
$total = mysqli_fetch_assoc($q);

$last = mysqli_query($conn, "SELECT * FROM orders WHERE user_id='$id' ORDER BY tanggal DESC LIMIT 1");
$order = mysqli_fetch_assoc($last);

$statusClass = "proses";
if($order){
    if($order['status'] == "Selesai") $statusClass = "selesai";
    if($order['status'] == "Batal") $statusClass = "batal";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #0f172a, #020617);
    color: white;
    overflow-x: hidden;
}

/* BACKGROUND GLOW */
body::before {
    content: "";
    position: absolute;
    width: 400px;
    height: 400px;
    background: #ef4444;
    filter: blur(150px);
    animation: move 12s infinite alternate;
}

@keyframes move {
    0% { transform: translate(-150px, -150px); }
    100% { transform: translate(200px, 200px); }
}

/* HEADER */
.header {
    padding: 20px;
    font-size: 22px;
    font-weight: bold;
    animation: fadeDown 0.8s ease;
}

@keyframes fadeDown {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
}

/* CARD GLASS */
.card {
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(20px);
    margin: 15px;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    animation: fadeUp 1s ease;
}

@keyframes fadeUp {
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
}

/* GRID */
.grid {
    display: flex;
    gap: 10px;
    padding: 0 15px;
}

.box {
    flex: 1;
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(15px);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    transition: 0.3s;
}

.box:hover {
    transform: scale(1.05);
}

/* BUTTON */
.btn {
    display: block;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    padding: 12px;
    border-radius: 10px;
    text-align: center;
    color: white;
    text-decoration: none;
    margin-top: 10px;
    transition: 0.3s;
}

.btn:hover {
    transform: scale(1.05);
}

/* STATUS */
.status {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 12px;
}

.proses { background: orange; }
.selesai { background: #22c55e; }
.batal { background: #ef4444; }

/* NAVBAR */
.navbar {
    position: fixed;
    bottom: 0;
    width: 100%;
    background: rgba(30, 41, 59, 0.8);
    backdrop-filter: blur(15px);
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
}

.navbar a {
    color: white;
    text-decoration: none;
    font-size: 12px;
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
    
    .grid {
        padding: 0 10px;
        gap: 8px;
    }
    
    .box {
        padding: 15px;
        font-size: 14px;
    }
    
    .navbar {
        padding: 10px 0;
    }
    
    .navbar a {
        font-size: 11px;
    }
    
    .btn {
        padding: 11px;
        font-size: 13px;
    }
}

/* MOBILE (480px and below) */
@media (max-width: 480px) {
    * {
        -webkit-tap-highlight-color: transparent;
    }
    
    body {
        padding-bottom: 80px;
        font-size: 14px;
    }
    
    body::before {
        width: 250px;
        height: 250px;
    }
    
    .header {
        padding: 12px;
        font-size: 16px;
        margin-bottom: 8px;
    }
    
    .card {
        margin: 10px;
        padding: 12px;
        border-radius: 15px;
    }
    
    .card h3 {
        font-size: 16px;
        margin-bottom: 5px;
    }
    
    .card h4 {
        font-size: 14px;
    }
    
    .card p {
        font-size: 12px;
        margin: 3px 0;
    }
    
    .grid {
        flex-wrap: wrap;
        padding: 0 8px;
        gap: 8px;
        margin-bottom: 10px;
    }
    
    .box {
        flex: 1;
        min-width: calc(50% - 4px);
        padding: 12px;
        font-size: 12px;
    }
    
    .box h2 {
        font-size: 18px;
        margin-bottom: 5px;
    }
    
    .box p {
        font-size: 11px;
    }
    
    .navbar {
        padding: 8px 0;
        gap: 2px;
    }
    
    .navbar a {
        font-size: 10px;
        padding: 0 2px;
        flex: 1;
        text-align: center;
    }
    
    .btn {
        padding: 11px;
        font-size: 12px;
        min-height: 44px;
    }
    
    .btn:hover {
        transform: scale(1.02);
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
    
    .grid {
        flex-direction: column;
    }
    
    .box {
        min-width: 100%;
        padding: 10px;
    }
    
    .navbar a {
        font-size: 9px;
    }
}
</style>

</head>

<body>

<div class="header">
    Halo, <?= $user['nama']; ?> 👋
</div>

<div class="card">
    <h3>🚀 Percetakan Online</h3>
    <p>Platform cetak modern tanpa antre</p>
</div>

<div class="grid">
    <div class="box">
        <h2><?= $total['total']; ?></h2>
        <p>Total Pesanan</p>
    </div>

    <div class="box">
        <h2>⚡</h2>
        <p>Aktif</p>
    </div>
</div>

<div class="card">
    <h4>⚡ Aksi Cepat</h4>
    <a href="upload.php" class="btn">📤 Upload Dokumen</a>
</div>

<div class="navbar">
    <a href="dashboard.php">🏠 Home</a>
    <a href="upload.php">📤 Cetak</a>
    <a href="history.php">📄 Riwayat</a>
    <a href="logout.php">🚪 Logout</a>
</div>

</body>
</html>