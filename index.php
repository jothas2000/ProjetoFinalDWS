<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

// Se o usuário já estiver logado, redireciona para o chat
if (isset($_SESSION['user'])) {
    header("Location: chat.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização das entradas
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $authController = new App\Controllers\AuthController();
    if ($authController->login($email, $password)) {
        header("Location: chat.php");
        exit;
    } else {
        $error = "Credenciais inválidas.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Chat</title>
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
    .login-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 8px;
      width: 300px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .login-container h1 {
      color: #0078d7;
      margin-bottom: 20px;
    }
    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .login-container button {
      background-color: #0078d7;
      color: #fff;
      border: none;
      padding: 10px;
      width: 100%;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    .login-container button:hover {
      background-color: #005fa3;
    }
    .error {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Entrar</h1>
    <?php if ($error): ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
    <form action="register.php" method="get">
      <button type="submit" style="background-color: #28a745;">Registrar</button>
    </form>
  </div>
</body>
</html>
