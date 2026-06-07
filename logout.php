<?php
session_start();
session_destroy();
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
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    overflow: hidden;
}

/* BACKGROUND GLOW */
body::before {
    content: "";
    position: absolute;
    width: 400px;
    height: 400px;
    background: #ef4444;
    filter: blur(150px);
    animation: move 10s infinite alternate;
}

@keyframes move {
    0% { transform: translate(-150px, -150px); }
    100% { transform: translate(200px, 200px); }
}

/* CARD */
.card {
    position: relative;
    text-align: center;
    background: rgba(30,41,59,0.6);
    backdrop-filter: blur(20px);
    padding: 35px;
    border-radius: 20px;
    width: 300px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    animation: fadeIn 0.8s ease;
    z-index: 1;
}

@keyframes fadeIn {
    from {opacity: 0; transform: scale(0.9);}
    to {opacity: 1; transform: scale(1);}
}

/* LOADER */
.loader {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255,255,255,0.1);
    border-top: 4px solid #ef4444;
    border-radius: 50%;
    margin: auto;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    100% { transform: rotate(360deg); }
}

/* TEXT */
h3 {
    margin-top: 15px;
}

p {
    margin-top: 10px;
    font-size: 13px;
    opacity: 0.7;
}

/* PROGRESS BAR */
.progress {
    margin-top: 15px;
    height: 6px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #ef4444, #dc2626);
    animation: load 2s linear forwards;
}

@keyframes load {
    100% { width: 100%; }
}

/* ========== MOBILE RESPONSIVE ========== */

/* TABLETS (768px and below) */
@media (max-width: 768px) {
    .card {
        width: 90%;
        max-width: 350px;
        padding: 30px;
    }
    
    .loader {
        width: 45px;
        height: 45px;
    }
    
    h3 {
        font-size: 18px;
    }
    
    p {
        font-size: 12px;
    }
}

/* MOBILE (480px and below) */
@media (max-width: 480px) {
    * {
        -webkit-tap-highlight-color: transparent;
    }
    
    body {
        height: auto;
        min-height: 100vh;
        padding: 20px;
    }
    
    body::before {
        width: 250px;
        height: 250px;
    }
    
    .card {
        width: 100%;
        padding: 25px;
        margin: 20px auto;
    }
    
    .loader {
        width: 40px;
        height: 40px;
        border-width: 3px;
    }
    
    h3 {
        font-size: 16px;
        margin-top: 12px;
    }
    
    p {
        font-size: 12px;
        margin-top: 8px;
    }
    
    .progress {
        margin-top: 12px;
        height: 5px;
    }
}

/* SMALL PHONES (360px and below) */
@media (max-width: 360px) {
    .card {
        padding: 20px;
    }
    
    .loader {
        width: 35px;
        height: 35px;
    }
    
    h3 {
        font-size: 14px;
    }
    
    p {
        font-size: 11px;
    }
}

</style>

</head>

<body>

<div class="card">
    <div class="loader"></div>
    <h3>Logout berhasil 👋</h3>
    <p>Terima kasih sudah menggunakan aplikasi</p>

    <div class="progress">
        <div class="progress-bar"></div>
    </div>

    <p>Mengalihkan ke login...</p>
</div>

<script>
setTimeout(function(){
    window.location.href = "index.php";
}, 2000);
</script>

</body>
</html>