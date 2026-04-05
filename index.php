<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechStore</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>

    <?php
    session_start();

    // Səbət session varsa saxlayır, yoxdursa boş array
    if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = [];
    }
    ?>

    <?php
    $HeaderNavbar = [
        "Ana səhifə" => "HomePage.php",
        "Haqqımızda" => "AboutPage.php",
        "Xidmətlər" => [
            "İT Dəstək" => "ItSupportPage.php",
        ],
        "Həllər" => "SolutionsPage.php",
        "Məhsullar" => "Products.php",
        ["icon" => "./icon/shopping-basket-icon.png", "link" => "#"],
        ["icon" => "./icon/telephone-icon.png", "link" => "Telephone.php"]
    ];
    ?>

    <div id="sidePanel" class="side-panel">
        <div class="panel-content">
            <button id="closePanel" class="close-btn">X</button>
            <h2>Səbət (<span id="basketCount">0</span>)</h2>

            <div id="basketItems"></div>

            <p id="emptyBasket">Hələki heç bir məhsul seçilməyib</p>

            <p id="totalPrice">Ümumi: 0 AZN</p>
        </div>
    </div>


    <div class="header">
        <div class="headerLogo">
            <h1>TechStore</h1>
        </div>

        <div class="headerSearch">
            <input type="text" placeholder="Search...">
        </div>

        <div class="headerNavbar">
            <?php
            foreach ($HeaderNavbar as $name => $link) {

                /* ICON BUTTONLAR (SƏNİN PROBLEMİN BURDAYDI 🔥) */
                if (is_int($name) && isset($link["icon"])) {

                    // səbət üçün dəyişmirik (# qalır)
                    if ($link["link"] === "#") {
                        echo "<a href='#' class='iconBtn'>
                        <img src='{$link['icon']}' alt='icon' class='imgIcon'>
                    </a>";
                    } else {
                        // TELEFON ARTIQ SPA KİMİ AÇILIR
                        echo "<a href='index.php?page={$link['link']}' class='iconBtn'>
                        <img src='{$link['icon']}' alt='icon' class='imgIcon'>
                    </a>";
                    }

                    continue;
                }

                /* DROPDOWN */
                if (is_array($link)) {
                    echo "<div class='dropdown'>
                    <button class='dropbtn'>$name</button>
                    <div class='dropdown-content'>";

                    foreach ($link as $subName => $subLink) {
                        echo "<a href='index.php?page=$subLink'>$subName</a>";
                    }

                    echo "</div></div>";
                    continue;
                }

                /* NORMAL LINK */
                echo "<a href='index.php?page=$link'>$name</a>";
            }
            ?>
        </div>
    </div>


    <main>
        <?php
        if (isset($_GET['page']) && file_exists($_GET['page'])) {
            include $_GET['page'];
        } else {
            include "HomePage.php";
        }
        ?>
    </main>

    <script src="./js/index.js"></script>

</body>

</html>