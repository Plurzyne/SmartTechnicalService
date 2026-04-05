<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "db.php";

/* ===== AJAX ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {

    header("Content-Type: application/json");

    $user_id    = $_SESSION['user_id'] ?? null;
    $request_id = (int)($_POST['request_id'] ?? 0);
    $message    = trim($_POST['message']);

    if (!$user_id || !$request_id || $message === '') {
        echo json_encode(["reply" => "Error"]);
        exit;
    }

    // USER mesaj
    $stmt = $conn->prepare("
        INSERT INTO chat_messages (request_id, sender, message)
        VALUES (?, 'user', ?)
    ");
    $stmt->bind_param("is", $request_id, $message);
    $stmt->execute();

    // AI REQUEST
    $reply = "AI cavab vermədi";

    $ch = curl_init("http://localhost:8080/api/chat/message");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS => json_encode([
            "sessionId" => "request_" . $request_id,
            "message"   => $message
        ])
    ]);

    $response = curl_exec($ch);

    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['reply'])) {
            $reply = $data['reply'];
        }
    }

    curl_close($ch);

    // AI mesaj DB
    $stmt = $conn->prepare("
        INSERT INTO chat_messages (request_id, sender, message)
        VALUES (?, 'ai', ?)
    ");
    $stmt->bind_param("is", $request_id, $reply);
    $stmt->execute();

    echo json_encode(["reply" => $reply]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <title>Online Chat</title>
    <link rel="stylesheet" href="./css/OnlineChat.css">
</head>

<body>

    <?php
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) header("Location: HomePage.php");

    $request_id = $_GET['request_id'] ?? 0;

    $stmt = $conn->prepare("
SELECT dr.problem, d.device_name, d.device_type
FROM device_requests dr
JOIN devices d ON dr.device_id = d.id
WHERE dr.id=? AND dr.user_id=?
");
    $stmt->bind_param("ii", $request_id, $user_id);
    $stmt->execute();
    $request = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("
SELECT sender, message 
FROM chat_messages 
WHERE request_id=? 
ORDER BY created_at ASC
");
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $messages = $stmt->get_result();
    ?>

    <div class="chatWrapper">

        <div class="chat-container">
            <div class="chat-header">Online Chat</div>

            <div class="chat-messages" id="messages">
                <?php while ($row = $messages->fetch_assoc()): ?>
                    <div class="<?= $row['sender'] == 'user' ? 'user-message' : 'ai-message' ?>">
                        <?= htmlspecialchars($row['message']) ?>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="chat-input">
                <input id="input" placeholder="Mesaj yaz...">
                <button onclick="send()">➤</button>
            </div>

        </div>

        <div class="infoCard">
            <h3>Sorğu məlumatı</h3>
            <p><b>Cihaz:</b> <?= $request['device_name'] ?></p>
            <p><b>Tip:</b> <?= $request['device_type'] ?></p>
            <p><b>Problem:</b> <?= $request['problem'] ?></p>

            <div class="infoBtns">
                <button class="contactBtn">Usta ilə əlaqə</button>
                <button class="stopBtn" onclick="stopAI()">AI dayandır</button>
            </div>
        </div>

    </div>

    <script>
        const requestId = <?= (int)$request_id ?>;
    </script>
    <script src="./js/OnlineChat.js"></script>

</body>

</html>