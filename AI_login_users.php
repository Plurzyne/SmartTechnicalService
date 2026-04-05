<?php
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    header("Location: index.php");
    exit();
}

$page = $_GET['page'] ?? 'home';
?>

<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css//AI_login.css">
</head>

<script>
    window.userId = <?= json_encode($user_id) ?>;
</script>

<body>

    <div class="dashboard">

        <!-- SOL SIDEBAR -->
        <div class="sidebar">

            <div class="user-panel">
                <img src="data:image/png;base64,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"
                    alt="">

                <div class="user-text">
                    <div class="fullname" id="name"></div>
                    <div class="lastname" id="surname"></div>
                    <div class="status" id="role"></div>
                </div>
            </div>

            <div class="menu">
                <a href="?page=home&id=<?= $user_id ?>">ƏSAS SƏHİFƏ</a>
                <a href="?page=məlumatlarım&id=<?= $user_id ?>">Verilənlərim</a>
                <a href="?page=qurgular&id=<?= $user_id ?>">Qurğular</a>
                <a href="?page=sorgular&id=<?= $user_id ?>">Sorğular</a>
                <a href="?page=qaydalar&id=<?= $user_id ?>">İsdifadə qaydaları</a>
                <a href="?page=kampanyalar&id=<?= $user_id ?>">Aİ kampanyaları</a>
            </div>
        </div>

        <!-- SAĞ -->
        <div class="main">

            <div class="topbar">
                <div class="left">
                    <span>
                        Azərbaycan Respublikası<br>
                        Əmək və Əhalinin Sosial Müdafiəsi Nazirliyi
                    </span>
                </div>

                <!-- <div class="right">
                    <div class="icon"><img src="./img//icons8-bell-48.png"><span class="count">0</span></div>
                    <div class="flag">🇦🇿</div>
                </div> -->
            </div>

            <div class="content-area">
                <?php
                echo $page;
                if ($page == "qurgular") {
                    include "AI_login_Devices.php";
                } elseif ($page == "sorgular") {
                    include "AI_login_Queries.php";
                } elseif ($page == "home") {
                    include "Dashboard_home.php";
                } elseif ($page == "məlumatlarım") {
                    include "Dashboard_user_info.php";
                } elseif ($page == "qaydalar") {
                    include "Dashboard_rules.php";
                } elseif ($page == "kampanyalar") {
                    include "Dashboard_camp.php";
                } else {
                    include "Dashboard_home.php"; // default
                }
                ?>
            </div>

        </div>

    </div>
    <script>
        async function loadUser() {
            try {
                const nameEl = document.getElementById("name");
                const surnameEl = document.getElementById("surname");
                const roleEl = document.getElementById("role");

                if (!nameEl || !surnameEl || !roleEl) return;

                const res = await fetch(`/api/users/${window.userId}`);
                if (!res.ok) throw new Error("Failed to fetch user");

                const user = await res.json();

                nameEl.innerText = (user.name || "").toUpperCase();
                surnameEl.innerText = (user.surname || "").toUpperCase();
                roleEl.innerText = user.usta ? "Usta" : "İstifadəçi";

            } catch (err) {
                console.error("User load error:", err);
            }
        }

        loadUser();
    </script>
</body>

</html>