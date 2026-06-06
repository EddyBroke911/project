<?php 
include 'koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

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
    background: #38bdf8;
    filter: blur(150px);
    animation: move 12s infinite alternate;
}

@keyframes move {
    0% { transform: translate(-150px, -150px); }
    100% { transform: translate(250px, 250px); }
}

/* CARD */
.card {
    position: relative;
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(20px);
    padding: 30px;
    border-radius: 20px;
    width: 340px;
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
    margin-bottom: 15px;
    color: white;
}

/* INPUT GROUP */
.input-group {
    position: relative;
    margin-top: 18px;
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

/* PASSWORD TOGGLE */
.show {
    margin-top: 10px;
    font-size: 12px;
    color: #94a3b8;
}
</style>
</head>

<body>

<div class="card">
    <h2>✨ Daftar Akun</h2>

    <form method="POST">

        <div class="input-group">
            <input type="text" name="nama" required>
            <label>Nama Lengkap</label>
        </div>

        <div class="input-group">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="input-group">
            <input type="password" id="pass" name="password" required>
            <label>Password</label>
        </div>

        <div class="input-group">
            <input type="password" id="confirm" name="confirm" required>
            <label>Konfirmasi Password</label>
        </div>

        <div class="show">
            <input type="checkbox" onclick="toggle()"> Lihat Password
        </div>

        <button name="register">Daftar</button>

    </form>

    <p style="text-align:center; margin-top:10px;">
        Sudah punya akun? 
        <a href="index.php">Login</a>
    </p>

    <div class="msg">

        <?php

        if(isset($_POST['register'])){

            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $confirm = $_POST['confirm'];

            // PASSWORD TIDAK SAMA
            if($pass != $confirm){

                echo "❌ Password tidak sama!";

            } else {

                // CEK EMAIL
                $cek = mysqli_query($conn, "
                    SELECT * FROM users 
                    WHERE email='$email'
                ");

                if(mysqli_num_rows($cek) > 0){

                    echo "❌ Email sudah terdaftar!";

                } else {

                    // HASH PASSWORD
                    $hash = password_hash(
                        $pass, 
                        PASSWORD_DEFAULT
                    );

                    // INSERT USER + ROLE
                    mysqli_query($conn,"
                        INSERT INTO users(
                            nama,
                            email,
                            password,
                            role
                        ) VALUES(
                            '$nama',
                            '$email',
                            '$hash',
                            'user'
                        )
                    ");

                    echo "✅ Registrasi berhasil! 🎉";

                }
            }
        }

        ?>

    </div>
</div>

<script>

function toggle(){

    let p1 = document.getElementById("pass");
    let p2 = document.getElementById("confirm");

    p1.type = p1.type === "password" 
        ? "text" 
        : "password";

    p2.type = p2.type === "password" 
        ? "text" 
        : "password";
}

</script>

</body>
</html>