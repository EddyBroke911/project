<?php 
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    header("Location: dashboard.php");
    exit;
}

$id = $_SESSION['id'];

$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE id='$id'")
);

/* =========================
   TOTAL SEMUA ORDER
========================= */

$q = mysqli_query($conn, 
    "SELECT COUNT(*) as total FROM orders"
);

$total = mysqli_fetch_assoc($q);

/* =========================
   ORDER TERAKHIR
========================= */

$last = mysqli_query($conn, 
    "SELECT * FROM orders 
     ORDER BY tanggal DESC 
     LIMIT 1"
);

$order = mysqli_fetch_assoc($last);

/* =========================
   STATISTIK STATUS
========================= */

$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders 
WHERE status='Menunggu Pembayaran'"));

$proses = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders 
WHERE status='Diproses'"));

$dicetak = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders 
WHERE status='Dicetak'"));

$dikirim = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders 
WHERE status='Dikirim'"));

$selesai = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM orders 
WHERE status='Selesai'"));

/* =========================
   UPDATE STATUS
========================= */

if(isset($_POST['update_status'])){
    
    $order_id = $_POST['order_id'];
    $status_baru = $_POST['status'];

    mysqli_query($conn,
    "UPDATE orders 
     SET status='$status_baru' 
     WHERE id='$order_id'");

    echo "
    <script>
        alert('Status berhasil diupdate!');
        window.location='dashboard_admin.php';
    </script>
    ";
}

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
    width:500px;
    height:500px;
    background:#ef4444;
    filter:blur(180px);
    animation:move 12s infinite alternate;
    z-index:-1;
}

@keyframes move{
    0%{
        transform:translate(-150px,-150px);
    }
    100%{
        transform:translate(300px,300px);
    }
}

/* HEADER */

.header{
    padding:20px;
    font-size:24px;
    font-weight:bold;
}

/* CARD */

.card{
    background:rgba(30,41,59,0.6);
    backdrop-filter:blur(20px);
    margin:15px;
    margin-bottom:25px;
    padding:20px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.5);
}

/* GRID */

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    padding: 15px;
    margin-bottom: 10px;
}

.box {
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(15px);
    padding: 50px 20px;
    border-radius: 30px;
    text-align: center;
    transition: 0.3s;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

.box:hover {
    transform: translateY(-5px);
}

.box h2{
    font-size: 55px;
    margin-bottom: 10px;
}

/* BUTTON */

.btn{
    display:block;
    background:linear-gradient(135deg,#ef4444,#dc2626);
    padding:12px;
    border-radius:12px;
    text-align:center;
    color:white;
    text-decoration:none;
    margin-top:10px;
    border:none;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.03);
}

/* STATUS */

.status{
    padding:6px 12px;
    border-radius:12px;
    font-size:12px;
    display:inline-block;
    margin-top:5px;
}

.proses{
    background:orange;
}

.selesai{
    background:#22c55e;
}

.batal{
    background:#ef4444;
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table tr td{
    padding:15px;
    border-bottom:1px solid rgba(255,255,255,0.1);
    font-size:14px;
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
    background:rgba(30,41,59,0.85);
    backdrop-filter:blur(15px);
    display:flex;
    justify-content:space-around;
    padding:14px 0;
}

.navbar a{
    color:white;
    text-decoration:none;
    font-size:12px;
}

/* ========== MOBILE RESPONSIVE ========== */

/* TABLETS (768px and below) */
@media (max-width: 768px) {
    body {
        padding-bottom: 100px;
    }
    
    body::before {
        width: 350px;
        height: 350px;
    }
    
    .header {
        padding: 15px;
        font-size: 20px;
    }
    
    .card {
        margin: 12px;
        padding: 15px;
    }
    
    .grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        padding: 12px;
    }
    
    .box {
        padding: 30px 15px;
    }
    
    .box h2 {
        font-size: 40px;
    }
    
    table tr td {
        padding: 12px;
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
        font-size: 13px;
        padding-bottom: 90px;
    }
    
    body::before {
        width: 280px;
        height: 280px;
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
        margin-bottom: 15px;
    }
    
    .card h3 {
        font-size: 16px;
        margin-bottom: 8px;
    }
    
    .card h4 {
        font-size: 14px;
        margin-bottom: 8px;
    }
    
    .card p {
        font-size: 12px;
    }
    
    .grid {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 8px;
    }
    
    .box {
        padding: 20px 10px;
        border-radius: 12px;
    }
    
    .box h2 {
        font-size: 28px;
        margin-bottom: 5px;
    }
    
    .box p {
        font-size: 11px;
    }
    
    .btn {
        padding: 11px;
        font-size: 12px;
        min-height: 40px;
        margin-top: 8px;
    }
    
    .status {
        padding: 5px 10px;
        font-size: 10px;
    }
    
    table {
        font-size: 12px;
    }
    
    table tr td {
        padding: 10px;
        font-size: 11px;
    }
    
    select {
        padding: 10px;
        font-size: 14px;
    }
    
    .navbar {
        padding: 10px 0;
    }
    
    .navbar a {
        font-size: 10px;
        padding: 0 2px;
    }
}

/* SMALL PHONES (360px and below) */
@media (max-width: 360px) {
    body {
        padding-bottom: 80px;
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
        grid-template-columns: 1fr;
    }
    
    .box {
        padding: 15px 10px;
    }
    
    .box h2 {
        font-size: 24px;
    }
    
    table tr td {
        padding: 8px;
        font-size: 10px;
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
    <h2>🚀 Percetakan Online</h2>
    <p>Platform cetak modern tanpa antre</p>
</div>

<!-- STATISTIK -->

<div class="grid">

    <div class="box">
        <h2><?= $pending['total']; ?></h2>
        <p>Pending</p>
    </div>

    <div class="box">
        <h2><?= $proses['total']; ?></h2>
        <p>Diproses</p>
    </div>

    <div class="box">
        <h2><?= $dicetak['total']; ?></h2>
        <p>Dicetak</p>
    </div>

    <div class="box">
        <h2><?= $dikirim['total']; ?></h2>
        <p>Dikirim</p>
    </div>

    <div class="box">
        <h2><?= $selesai['total']; ?></h2>
        <p>Selesai</p>
    </div>

    <div class="box">
        <h2><?= $total['total']; ?></h2>
        <p>Total Pesanan</p>
    </div>

</div>

<!-- ORDER TERAKHIR -->

<div class="card">

    <h3>📦 Pesanan Terakhir</h3>

    <?php if($order){ ?>

        <p>
            <b>📁 <?= $order['file']; ?></b>
        </p>

        <p>
            🖨️ <?= $order['jumlah']; ?> |
            <?= $order['jenis']; ?>
        </p>

        <p>
            Status:
            <span class="status <?= $statusClass ?>">
                <?= $order['status']; ?>
            </span>
        </p>

        <p style="font-size:12px;opacity:0.7;">
            🕒 <?= $order['tanggal']; ?>
        </p>

        <a href="history_admin.php" class="btn">
            📄 Lihat Riwayat
        </a>

    <?php } else { ?>

        <p>Belum ada pesanan 😴</p>

    <?php } ?>

</div>

<!-- DAFTAR ORDER -->

<div class="card">

    <h3>📋 Daftar Semua Order</h3>

    <table>

    <?php
    $orders = mysqli_query($conn,
    "SELECT * FROM orders 
     ORDER BY tanggal DESC");

    while($o = mysqli_fetch_assoc($orders)){
    ?>

    <tr>
        <td>

            <b><?= $o['file']; ?></b><br>

            <?= $o['jenis']; ?><br>

            <small>
                <?= $o['tanggal']; ?>
            </small>

            <br><br>

            <span class="status">
                <?= $o['status']; ?>
            </span>

            <div style="
                margin-top:10px;
                font-size:13px;
                opacity:0.8;
            ">
                Jumlah: <?= $o['jumlah']; ?><br>
                User ID: <?= $o['user_id']; ?>
            </div>

            <!-- FORM UPDATE -->

            <form method="POST">

                <input 
                    type="hidden"
                    name="order_id"
                    value="<?= $o['id']; ?>"
                >

                <select name="status">

                    <option value="Menunggu Pembayaran">
                        Menunggu Pembayaran
                    </option>

                    <option value="Diproses">
                        Diproses
                    </option>

                    <option value="Dicetak">
                        Dicetak
                    </option>

                    <option value="Dikirim">
                        Dikirim
                    </option>

                    <option value="Selesai">
                        Selesai
                    </option>

                </select>

                <button 
                    type="submit"
                    name="update_status"
                    class="btn"
                >
                    🔄 Update Status
                </button>

            </form>

        </td>
    </tr>

    <?php } ?>

    </table>

</div>

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