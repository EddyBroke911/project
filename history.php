<?php 
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit;
}

$id = $_SESSION['id'];
$data = mysqli_query($conn,"SELECT * FROM orders WHERE user_id='$id' ORDER BY tanggal DESC");
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
    background: #38bdf8;
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

/* CARD */
.card {
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(20px);
    margin: 15px;
    padding: 20px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    animation: fadeUp 0.6s ease;
    transition: 0.3s;
}

.card:hover {
    transform: scale(1.02);
}

@keyframes fadeUp {
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
}

/* FILE */
.file {
    font-size: 14px;
    color: #38bdf8;
}

/* STATUS */
.status {
    padding: 6px 12px;
    border-radius: 12px;
    font-size: 12px;
    display: inline-block;
}

.proses { background: orange; }
.selesai { background: #22c55e; }
.batal { background: #ef4444; }

/* EMPTY */
.empty {
    text-align: center;
    margin-top: 60px;
    opacity: 0.8;
    animation: fadeUp 1s ease;
}

/* BUTTON */
.btn {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    border-radius: 10px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    text-decoration: none;
    color: white;
    font-size: 12px;
}

/* NAVBAR */
.navbar {
    position: fixed;
    bottom: 0;
    width: 100%;
    background: rgba(30,41,59,0.8);
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
    
    .status {
        font-size: 11px;
        padding: 5px 10px;
    }
    
    .btn {
        padding: 10px;
        font-size: 12px;
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
        font-size: 14px;
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
    }
    
    .status {
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 11px;
        display: inline-block;
        margin: 5px 0;
    }
    
    .file {
        font-size: 12px;
        word-break: break-all;
    }
    
    .btn {
        display: inline-block;
        margin-top: 8px;
        padding: 9px 12px;
        font-size: 11px;
        min-height: auto;
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
        margin-bottom: 8px;
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
        padding: 8px 10px;
        font-size: 10px;
    }
    
    .navbar a {
        font-size: 9px;
    }
}
</style>

</head>

<body>

<div class="header">📄 Riwayat Pesanan</div>

<?php if(mysqli_num_rows($data) == 0){ ?>
    <div class="empty">
        <h2>😴 Belum ada pesanan</h2>
        <p>Ayo mulai cetak sekarang!</p>
        <a href="upload.php" class="btn">📤 Cetak Sekarang</a>
    </div>
<?php } ?>

<?php while($d = mysqli_fetch_array($data)){ 
    $statusClass = "proses";
    if($d['status'] == "Selesai") $statusClass = "selesai";
    if($d['status'] == "Batal") $statusClass = "batal";
?>

<div class="card">
    <p class="file">📁 <?= $d['file']; ?></p>

    <p>🖨️ <?= $d['jumlah']; ?> cetak</p>
    <p>🎨 <?= $d['jenis']; ?></p>

    <p>
        Status:
        <span class="status <?= $statusClass ?>">
            <?= $d['status']; ?>
        </span>
    </p>

    <p style="font-size:12px; opacity:0.7;">
        🕒 <?= $d['tanggal']; ?>
    </p>

    <a href="uploads/<?= $d['file']; ?>" class="btn" download>⬇ Download</a>
</div>

<?php } ?>

<div class="navbar">
    <a href="dashboard.php">🏠 Home</a>
    <a href="upload.php">📤 Cetak</a>
    <a href="history.php">📄 Riwayat</a>
    <a href="logout.php">🚪 Logout</a>
</div>

</body>
</html>