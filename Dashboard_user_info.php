<link rel="stylesheet" href="./css//Dashboard_user_info.css">
<?php
include "db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: HomePage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 👉 ƏGƏR FORM GÖNDƏRİLİBSƏ (UPDATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users_register SET name=?, surname=?, email=?, tel=?, parol=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $surname, $email, $tel, $hashedPassword, $user_id);
    } else {
        $sql = "UPDATE users_register SET name=?, surname=?, email=?, tel=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $surname, $email, $tel, $user_id);
    }

    $stmt->execute();

    header("Location: AI_login_users.php?page=home");
    exit();
}

// 👉 ƏKS HALDA (DATA GÖSTƏR)
$sql = "SELECT * FROM users_register WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <title>Məlumatları yenilə</title>
</head>

<body>


    <div class="editContainer">

        <form method="POST" class="editForm">

            <h2>Məlumatları yenilə</h2>

            <div class="inputGroup">
                <label>Ad</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
            </div>

            <div class="inputGroup">
                <label>Soyad</label>
                <input type="text" name="surname" value="<?= htmlspecialchars($user['surname']) ?>">
            </div>

            <div class="inputGroup">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
            </div>

            <div class="inputGroup">
                <label>Nömrə</label>
                <input type="text" name="tel" value="<?= htmlspecialchars($user['tel']) ?>">
            </div>

            <div class="inputGroup">
                <label>Yeni parol</label>
                <input type="password" name="password" placeholder="********">
            </div>

            <button type="submit" class="saveBtn">Yadda saxla</button>

        </form>

    </div>
</body>

</html>