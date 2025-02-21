<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Config\Database;

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

date_default_timezone_set('America/Sao_Paulo'); // ou o fuso que for adequado

// Atualiza o last_activity do usuário logado para o horário atual
$db = Database::getInstance()->getConnection();
$stmtUpdate = $db->prepare("UPDATE users SET last_activity = NOW() WHERE id = :id");
$stmtUpdate->execute(['id' => $_SESSION['user']['id']]);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat - Messenger</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }
    .sidebar {
      background: #0078d7;
      width: 250px;
      color: #fff;
      padding: 20px;
      box-sizing: border-box;
    }
    .sidebar h2 {
      margin-top: 0;
    }
    .contact {
      display: flex;
      align-items: center;
      padding: 10px 0;
      border-bottom: 1px solid rgba(255,255,255,0.3);
      cursor: pointer;
    }
    .contact:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    .contact img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }
    .status {
      font-size: 12px;
      margin-left: auto;
    }
    .chat-container {
      flex: 1;
      display: flex;
      flex-direction: column;
    }
    .chat-header {
      background: #0078d7;
      color: #fff;
      padding: 10px 20px;
      position: relative;
    }
    .chat-header button {
      position: absolute;
      right: 20px;
      top: 10px;
      background: red;
      color: #fff;
      border: none;
      padding: 5px 10px;
      border-radius: 4px;
      cursor: pointer;
      display: none;
    }
    .chat-messages {
      flex: 1;
      padding: 20px;
      background: #e5ddd5;
      overflow-y: auto;
    }
    .message {
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 10px;
      max-width: 60%;
      clear: both;
    }
    .message.sent {
      background: #dcf8c6;
      float: right;
    }
    .message.received {
      background: #fff;
      float: left;
    }
    .message small {
      display: block;
      text-align: right;
      font-size: 10px;
      color: #555;
    }
    .chat-input {
      padding: 10px 20px;
      background: #f0f0f0;
      display: flex;
    }
    .chat-input input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .chat-input button {
      background: #0078d7;
      color: #fff;
      border: none;
      padding: 10px 15px;
      margin-left: 10px;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Contatos</h2>
    <?php
    // Consulta de contatos incluindo o campo last_activity
    $stmt = $db->prepare("SELECT id, username, last_activity FROM users WHERE id != :user_id");
    $stmt->bindValue(':user_id', $_SESSION['user']['id']);
    $stmt->execute();
    $contacts = $stmt->fetchAll();

    foreach ($contacts as $contact) {
        // Se o usuário esteve ativo nos últimos 5 minutos, considere online
        $online = (time() - strtotime($contact['last_activity']) < 300) ? "Online" : "Offline";
        echo '<div class="contact" onclick="openChat('.$contact['id'].', \''.addslashes($contact['username']).'\')">
                <img src="public/IMG/msn.png" alt="Avatar">
                <span>'.$contact['username'].'</span>
                <span class="status">'.$online.'</span>
              </div>';
    }
    ?>
  </div>

  <div class="chat-container">
    <div class="chat-header" id="chatHeader">
      Selecione um contato
      <button id="deleteConversationBtn" onclick="deleteConversation()" style="display: none;">Excluir Conversa</button>
    </div>
    <div class="chat-messages" id="chatMessages">
    </div>
    <div class="chat-input">
      <input type="text" id="messageInput" placeholder="Digite sua mensagem..." disabled>
      <button id="sendBtn" onclick="sendMessage()" disabled>Enviar</button>
    </div>
  </div>

  <script>
    let currentUserId = <?php echo json_encode($_SESSION['user']['id']); ?>;
    let selectedUserId = null;
    
    function openChat(userId, username) {
      selectedUserId = userId;
      document.getElementById("chatHeader").innerText = "Chat com " + username;
      
      // Verifica se o botão existe antes de alterar seu estilo
      let btn = document.getElementById("deleteConversationBtn");
      if (btn) {
          btn.style.display = "inline-block";
      }
      
      document.getElementById("messageInput").disabled = false;
      document.getElementById("sendBtn").disabled = false;

      // Carrega as mensagens da conversa
      fetch("get_messages.php?receiver_id=" + userId)
        .then(response => response.json())
        .then(messages => {
          let chatMessages = document.getElementById("chatMessages");
          chatMessages.innerHTML = "";
          messages.forEach(msg => {
            let messageDiv = document.createElement("div");
            messageDiv.className = msg.sender_id == currentUserId ? "message sent" : "message received";
            let timeSent = msg.time_sent ? msg.time_sent : "";
            messageDiv.innerHTML = "<p>" + msg.message + "</p><small>" + timeSent + "</small>";
            chatMessages.appendChild(messageDiv);
          });
        });
    }

    function sendMessage() {
      let messageInput = document.getElementById("messageInput");
      let messageText = messageInput.value.trim();
      
      if (messageText === "" || !selectedUserId) return;

      fetch("send_message.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "receiver_id=" + selectedUserId + "&message=" + encodeURIComponent(messageText)
      }).then(() => {
        let chatMessages = document.getElementById("chatMessages");
        let messageDiv = document.createElement("div");
        messageDiv.className = "message sent";
        // Formata o horário local em HH:MM para mensagens recém-enviadas
        let now = new Date();
        let hours = now.getHours().toString().padStart(2, '0');
        let minutes = now.getMinutes().toString().padStart(2, '0');
        let localTime = hours + ":" + minutes;
        messageDiv.innerHTML = "<p>" + messageText + "</p><small>" + localTime + "</small>";
        chatMessages.appendChild(messageDiv);
        messageInput.value = "";
      });
    }

    function deleteConversation() {
      if (!selectedUserId) return;
      if (!confirm("Tem certeza que deseja excluir esta conversa?")) return;

      fetch("delete_conversation.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "receiver_id=" + selectedUserId
      })
      .then(response => response.json())
      .then(result => {
          if (result.success) {
              alert("Conversa excluída com sucesso.");
              document.getElementById("chatMessages").innerHTML = "";
          } else {
              alert("Erro ao excluir a conversa: " + result.error);
          }
      });
    }
  </script>
</body>
</html>
