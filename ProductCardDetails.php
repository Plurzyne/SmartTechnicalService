<link rel="stylesheet" href="./css//ProductCardDetails.css">
<?php
// session_start();
require_once __DIR__ . "/ElectProduct_Data.php";

$id = $_GET['id'] ?? null;

if (!$id || !isset($Cards[$id])) {
    echo "Məhsul tapılmadı!";
    exit;
}

$Card = $Cards[$id];

$discountedPrice = $Card['realPrice'] * (1 - $Card['discountPercent'] / 100);
$discountAmount  = $Card['realPrice'] - $discountedPrice;
?>

<div class="contant">
    <div class="product-details">
        <img class="cardImg" src="<?php echo $Card['img']; ?>" alt="<?php echo $Card['productName']; ?>">
        <div class="card">
            <div class="information">
                <h5><?php echo $Card['ElectType']; ?></h5>
                <h1><?php echo $Card['productName']; ?></h1>
                <div class="commentStar">
                    <div class="review-count">0 rəy</div>
                    <div>⭐ <span class="rating-value">0</span></div>
                </div>
                <div class="redCard"><?php echo number_format($discountAmount)  ?>₼</div>
                <p class="price">
                    <strong class="discountPercent"><?php echo number_format($discountedPrice, 2); ?> AZN</strong>
                    <span class="real-price"><?php echo number_format($Card['realPrice'], 2); ?> AZN</span>
                </p>
                <div>Məlumat</div>
                <div class="productAbout">
                    <div class="productAboutTextImg">
                        <img style="width: 25px;" src="./icon//productAbout-Page-icon.png" alt="">
                        <p>Xüsusiyyetlər</p>
                    </div>
                    <p class="plus">+</p>
                </div>
                <div class="comment">
                    <div class="productCommentTextImg">
                        <img style="width: 25px;" src="./icon//commentPage-icon.png" alt="">
                        <p>Rəylər </p>
                    </div>
                    <p class="plus">+</p>
                </div>
            </div>

            <button class="add-to-cart"
                data-id="<?= $id ?>"
                data-name="<?= $Card['productName'] ?>"
                data-price="<?= number_format($discountedPrice, 2, '.', '') ?>">
                Səbətə əlavə et
            </button>
            <button class="shareBtn">paylaş</button>
        </div>
    </div>
</div>
<script src="./js/ProductCardDetails.js"></script>