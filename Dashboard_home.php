<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css//Dashboard_home.css">
</head>

<body>
    <div class="homePage">

        <!-- PROFILE CARD -->

        <div class="profileCard">

            <div class="profileTop">

                <div class="profileImg"></div>

                <h2><?= htmlspecialchars($user['name']) ?> <?= htmlspecialchars($user['surname']) ?></h2>

            </div>


            <div class="profileInfo">

                <p><b>Vəzifə:</b> <?= $user['usta'] == 1 ? 'usta' : 'istifadəçi' ?></p>
                <p><b>Email:</b> <?= htmlspecialchars($user['email']) ?></p>
                <p><b>Nömrə:</b> <?= htmlspecialchars($user['tel']) ?></p>
                <p><b>Parol:</b> *******</p>

            </div>

            <a href="?page=məlumatlarım">
                <button class="editBtn">Məlumatlarda yenilik et</button>
            </a>

        </div>


        <!-- NEWS SLIDER -->



        <!-- <script src="./js//Dashboard_home.js"></script> -->
</body>

</html>