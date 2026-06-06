<?php 
session_start();
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', sans-serif;
    height: 100vh;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

/* BACKGROUND ANIMATION */
body::before {
    content: "";
    position: absolute;
    width: 500px;
    height: 500px;
    background: #ef4444;
    filter: blur(150px);
    animation: move 10s infinite alternate;
}

@keyframes move {
    0% { transform: translate(-100px, -100px); }
    100% { transform: translate(200px, 200px); }
}

/* CARD GLASS */
.card {
    position: relative;
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(20px);
    padding: 30px;
    border-radius: 20px;
    width: 320px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    animation: fadeIn 1s ease;
    z-index: 1;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(40px);}
    to {opacity: 1; transform: translateY(0);}
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: white;
}

/* FLOATING INPUT */
.input-group {
    position: relative;
    margin-top: 20px;
}

.input-group input {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    outline: none;
    background: #0f172a;
    color: white;
}

.input-group label {
    position: absolute;
    left: 12px;
    top: 12px;
    font-size: 12px;
    color: #94a3b8;
    transition: 0.3s;
}

.input-group input:focus + label,
.input-group input:valid + label {
    top: -8px;
    font-size: 10px;
    color: #38bdf8;
}

/* BUTTON */
button {
    width: 100%;
    padding: 12px;
    margin-top: 20px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    transform: scale(1.05);
}

/* LINK */
a {
    color: #38bdf8;
    text-decoration: none;
}

/* MESSAGE */
.msg {
    text-align: center;
    margin-top: 10px;
    color: white;
}

/* TOGGLE PASSWORD */
.show {
    margin-top: 10px;
    font-size: 12px;
    color: #94a3b8;
}
</style>
</head>

<body>

<div class="card">
    <h2>🚀 Login</h2>

    <form method="POST">

        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="input-group">
            <input type="password" id="pass" name="password" required>
            <label>Password</label>
        </div>

        <div class="show">
            <input type="checkbox" onclick="toggle()"> Lihat Password
        </div>

        <button name="login">Masuk</button>

    </form>

    <p style="text-align:center; margin-top:10px;">
        Belum punya akun? 
        <a href="register.php">Daftar</a>
    </p>

    <div class="msg">

        <?php

        if(isset($_POST['login'])){

            $email = $_POST['email'];
            $pass = $_POST['password'];

            $data = mysqli_query($conn,"
                SELECT * FROM users 
                WHERE email='$email'
            ");

            $user = mysqli_fetch_assoc($data);

            // LOGIN BERHASIL
            if($user && password_verify($pass, $user['password'])){

                $_SESSION['id'] = $user['id'];

                // SIMPAN ROLE
                $_SESSION['role'] = $user['role'];

                // CEK ROLE
                if($user['role'] == 'admin'){

                    header("Location: dashboard_admin.php");

                } else {

                    header("Location: dashboard.php");

                }

                exit;

            } else {

                echo "❌ Email atau password salah!";

            }
        }

        ?>

    </div>

</div>

<script>

function toggle(){

    var x = document.getElementById("pass");

    if(x.type === "password"){

        x.type = "text";

    } else {

        x.type = "password";

    }

}

</script>

</body>
</html>