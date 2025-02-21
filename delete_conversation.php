<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Config\Database;

session_start();

if (!isset($_SESSION['user']) || !isset($_POST['receiver_id'])) {
    echo json_encode(['success' => false, 'error' => 'Parâmetros inválidos']);
    exit;
}

$user_id = $_SESSION['user']['id'];
$receiver_id = intval($_POST['receiver_id']);

$db = Database::getInstance()->getConnection();

$stmt = $db->prepare("
    DELETE FROM messages 
    WHERE (sender_id = :user_id AND receiver_id = :receiver_id)
       OR (sender_id = :receiver_id AND receiver_id = :user_id)
");

if ($stmt->execute([
    'user_id' => $user_id,
    'receiver_id' => $receiver_id
])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Falha ao excluir a conversa']);
}
