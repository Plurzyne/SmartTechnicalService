<link rel="stylesheet" href="./css//HomePage.css">

<div class="poster">
    <div class="advertising">
        <img src="./img/ChatGPT Image.png" alt="">
    </div>

    <div class="login-box">
        <h1>Ai ilə texniki xidmət sisteminə giriş</h1>
        <p class="subtitle">Hesabınıza daxil olun</p>

        <form id="loginForm">

            <label>Login</label>
            <input type="text" id="tel" placeholder="Telefon nömrəniz" required>

            <label>Parol</label>
            <input type="password" id="parol" placeholder="••••••••" required>

            <div class="btn">
                <button type="submit" class="btn-primary">Daxil ol</button>

                <a href="./AI_register.php">
                    <button type="button" class="btn-secondary">Qeydiyyatdan keç</button>
                </a>
            </div>

        </form>
    </div>
</div>

<br>

<div class="title">
    <h2>Məhsullar</h2>
    <div> <a href="index.php?page=Products.php">Daha çox</a></div>
</div>

<?php
require_once __DIR__ . "/AllElectProduct_Data.php";
?>

<script>
    const form = document.getElementById("loginForm");

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const phone = document.getElementById("tel").value;
        const password = document.getElementById("parol").value;

        try {
            const response = await fetch("/api/users/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    phone: phone,
                    password: password
                })
            });

            const data = await response.json();

            if (response.ok) {
                alert("Giriş uğurludur!");
                window.location.href = "./AI_login_users.php?id=" + data.id;
            } else {
                alert(data || "Login uğursuz oldu!");
            }

        } catch (error) {
            console.error(error);
            alert("Serverə qoşulmaq mümkün olmadı!");
        }
    });
</script>