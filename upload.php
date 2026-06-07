<?php 
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit;
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

/* CONTAINER */
.container {
    padding: 15px;
}

/* UPLOAD BOX */
.upload-box {
    background: rgba(30,41,59,0.6);
    backdrop-filter: blur(15px);
    border: 2px dashed #334155;
    padding: 40px;
    text-align: center;
    border-radius: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.upload-box:hover {
    transform: scale(1.02);
    border-color: #ef4444;
}

/* PREVIEW */
.preview {
    margin-top: 15px;
    text-align: center;
    animation: fadeUp 0.5s ease;
}

.preview img {
    max-width: 100%;
    border-radius: 10px;
}

/* INPUT */
input, select {
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    border-radius: 10px;
    border: none;
    background: rgba(15,23,42,0.8);
    color: white;
}

/* BUTTON */
button {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    border-radius: 10px;
    margin-top: 15px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.05);
}

/* SUCCESS */
.success {
    text-align: center;
    margin-top: 15px;
    animation: fadeUp 0.5s ease;
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

/* ANIMATION */
@keyframes fadeUp {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
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
    
    .container {
        padding: 12px;
        padding-bottom: 100px;
    }
    
    .upload-box {
        padding: 30px;
    }
    
    input, select {
        padding: 11px;
        font-size: 14px;
    }
    
    button {
        padding: 12px;
        font-size: 14px;
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
    
    .container {
        padding: 10px;
        padding-bottom: 20px;
    }
    
    .upload-box {
        padding: 25px;
        border-radius: 15px;
    }
    
    .upload-box h3 {
        font-size: 16px;
        margin-bottom: 8px;
    }
    
    .upload-box p {
        font-size: 12px;
    }
    
    .preview {
        margin-top: 12px;
    }
    
    .preview img {
        max-width: 100%;
        max-height: 200px;
    }
    
    input, select {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        font-size: 16px;
        border-radius: 10px;
    }
    
    button {
        width: 100%;
        padding: 12px;
        font-size: 14px;
        min-height: 44px;
        margin-top: 12px;
    }
    
    button:hover {
        transform: scale(1.02);
    }
    
    .navbar {
        padding: 8px 0;
    }
    
    .navbar a {
        font-size: 10px;
        padding: 0 2px;
    }
    
    .success {
        font-size: 13px;
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
    
    .container {
        padding: 8px;
    }
    
    .upload-box {
        padding: 20px;
    }
    
    input, select {
        padding: 10px;
        font-size: 16px;
        margin-top: 8px;
    }
    
    button {
        padding: 11px;
        font-size: 13px;
    }
}
</style>

</head>

<body>

<div class="header">📤 Upload Dokumen</div>

<div class="container">

<form method="POST" enctype="multipart/form-data">

    <div class="upload-box" onclick="document.getElementById('file').click()">
        <h3>📁 Upload File</h3>
        <p>Klik atau drag file ke sini</p>
        <input type="file" id="file" name="file" hidden onchange="previewFile()">
    </div>

    <div class="preview" id="preview"></div>

    <input type="number" name="jumlah" placeholder="Jumlah cetak" required>

    <select name="jenis">
        <option>Hitam Putih</option>
        <option>Berwarna</option>
    </select>

    <button name="upload">🚀 Kirim Pesanan</button>

</form>

<?php
if(isset($_POST['upload'])){
    $file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $jumlah = $_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $user_id = $_SESSION['id'];

    $allowed = ['pdf','docx','jpg','png'];
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        echo "<div class='success'>❌ Format tidak didukung!</div>";
    } else {
        $newName = time() . "_" . $file;

        move_uploaded_file($tmp, "uploads/".$newName);

        mysqli_query($conn,"INSERT INTO orders VALUES('', '$user_id','$newName','$jumlah','$jenis','Diproses',NOW())");

        echo "<div class='success'>✅ Pesanan berhasil dikirim!</div>";
    }
}
?>

</div>

<div class="navbar">
    <a href="dashboard.php">🏠 Home</a>
    <a href="upload.php">📤 Cetak</a>
    <a href="history.php">📄 Riwayat</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<script>
function previewFile() {
    const file = document.getElementById('file').files[0];
    const preview = document.getElementById('preview');

    preview.innerHTML = "";

    if(file){
        if(file.type.startsWith("image/")){
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            preview.appendChild(img);
        } else {
            preview.innerHTML = "📄 " + file.name;
        }
    }
}
</script>

</body>
</html>