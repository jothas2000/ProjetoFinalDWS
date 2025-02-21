<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Config\Database;

session_start();
if (!isset($_SESSION['user']) || !isset($_POST['receiver_id']) || !isset($_POST['message'])) exit;

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
$stmt->execute([$_SESSION['user']['id'], $_POST['receiver_id'], $_POST['message']]);
