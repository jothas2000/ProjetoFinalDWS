<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Config\Database;

session_start();

if (!isset($_SESSION['user']) || !isset($_GET['receiver_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user']['id'];
$receiver_id = intval($_GET['receiver_id']);

$db = Database::getInstance()->getConnection();

// Seleciona as mensagens e formata o horário de envio (HH:MM)
$stmt = $db->prepare("
    SELECT sender_id, receiver_id, message, DATE_FORMAT(created_at, '%H:%i') AS time_sent
    FROM messages
    WHERE (sender_id = :user_id AND receiver_id = :receiver_id)
       OR (sender_id = :receiver_id AND receiver_id = :user_id)
    ORDER BY created_at ASC
");

$stmt->execute([
    'user_id' => $user_id,
    'receiver_id' => $receiver_id
]);

$messages = $stmt->fetchAll();
echo json_encode($messages);
?>