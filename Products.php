<?php
$catalog = [
    [
        "name" => "Noutbuklar",
        "icon" => "",
        "sub" => ["Gaming", "Ofis", "Ultrabook"]
    ],

    [
        "name" => "Monitorlar",
        "icon" => "",
        "sub" => []
    ],

    [
        "name" => "Komputer hissələri",
        "icon" => "",
        "sub" => ["Prosessor", "RAM", "Video kart"]
    ],
    [
        "name" => "Aksesuarlar",
        "icon" => "",
        "sub" => ["Klaviatura", "Mouse", "Qulaqlıq"]
    ],
    [
        "name" => "Printerlər",
        "icon" => "",
        "sub" => []
    ],
    [
        "name" => "Şəbəkə Avadanlıqları",
        "icon" => "",
        "sub" => []
    ],

];
?>
<link rel="stylesheet" href="./css/Products.css">
<div class="layout">
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="./icon//icons8-menu-48.png" alt="" class="menu-icon">
            <span>Məhsul Kataloqu</span>
        </div>

        <?php foreach ($catalog as $item): ?>
            <div class="category hover-item">
                <div class="category-head">
                    <span class="icon"><?php echo $item["icon"]; ?></span>
                    <span class="title"><?php echo $item["name"]; ?></span>
                    <?php if (!empty($item["sub"])): ?>
                        <span class="arrow">›</span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($item["sub"])): ?>
                    <div class="submenu">
                        <?php foreach ($item["sub"] as $sub): ?>
                            <a href="#"><?php echo $sub; ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

</div>
<?php
require_once __DIR__ . "/AllElectProduct_Data.php";



?>