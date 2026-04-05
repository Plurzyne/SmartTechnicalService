<?php
require_once __DIR__ . "/ElectProduct_Data.php";
?>
<link rel="stylesheet" href="./css//AllElectProduct_Data.css">
<div class="allCard">
    <?php
    foreach ($Cards as $id => $Card) {
        $discountedPrice = $Card['realPrice'] * (1 - $Card['discountPercent'] / 100);
    ?>
        <a style="text-decoration: none;"
            href="index.php?page=ProductCardDetails.php&id=<?= $id ?>">
            <div class="product-card">
                <div class="card-image">
                    <img src="<?php echo $Card['img']; ?>" alt="<?php echo $Card['productName']; ?>">
                    <span class="discount-percent">-<?php echo $Card['discountPercent']; ?>%</span>
                </div>
                <div class="card-info">
                    <h5><?php echo $Card["ElectType"] ?></h5>
                    <h3><?php echo $Card['productName']; ?></h3>
                    <p class="price">
                        <strong class="discountPercent"><?php echo number_format($discountedPrice, 2); ?> AZN</strong>
                        <span class="real-price"><?php echo number_format($Card['realPrice'], 2); ?> AZN</span>
                    </p>


                    <button class="add-to-cart"
                        data-id="<?= $id ?>"
                        data-name="<?= $Card['productName'] ?>"
                        data-price="<?= number_format($discountedPrice, 2, '.', '') ?>">
                        Səbətə əlavə et
                    </button>

                </div>
            </div>
        </a>
    <?php } ?>
</div>