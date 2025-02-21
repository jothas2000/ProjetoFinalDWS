<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Chat</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #0078d7;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .register-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 8px;
      width: 300px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .register-container h1 {
      color: #0078d7;
      margin-bottom: 20px;
    }
    .register-container input[type="text"],
    .register-container input[type="email"],
    .register-container input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .register-container button {
      background-color: #0078d7;
      color: #fff;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    .register-container button:hover {
      background-color: #005fa3;
    }
    .back-link {
      display: block;
      margin-top: 15px;
      color: #0078d7;
      text-decoration: none;
      font-size: 14px;
    }
    .error {
      color: red;
      margin-bottom: 10px;
    }
    .success {
      color: green;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h1>Registrar</h1>
    <?php
      session_start();
      if(isset($_SESSION['error'])) {
        echo '<p class="error">'. $_SESSION['error'] .'</p>';
        unset($_SESSION['error']);
      }
      if(isset($_SESSION['message'])) {
        echo '<p class="success">'. $_SESSION['message'] .'</p>';
        unset($_SESSION['message']);
      }
    ?>
    <form action="register_process.php" method="post">
      <input type="text" name="username" placeholder="Nome de usuário" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Senha" required>
      <input type="password" name="confirm_password" placeholder="Confirmar Senha" required>
      <button type="submit">Registrar</button>
    </form>
    <a class="back-link" href="index.php">Voltar para Login</a>
  </div>
</body>
</html>
