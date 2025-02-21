<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização dos dados
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $confirm  = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);

    // Valida se todos os campos foram preenchidos
    if (!$username || !$email || !$password || !$confirm) {
        $_SESSION['error'] = "Por favor, preencha todos os campos.";
        header("Location: register.php");
        exit;
    }

    // Verifica se as senhas conferem
    if ($password !== $confirm) {
        $_SESSION['error'] = "As senhas não conferem.";
        header("Location: register.php");
        exit;
    }

    // Aqui você pode adicionar validações adicionais (por exemplo, tamanho do nome ou complexidade da senha)
    
    try {
        // Cria uma instância do controlador de autenticação
        $auth = new App\Controllers\AuthController();

        // Prepara os dados para registro (o método register deve fazer o hash da senha internamente)
        $userData = [
            'username' => $username,
            'email'    => $email,
            'password' => $password
        ];

        $result = $auth->register($userData);

        if ($result) {
            $_SESSION['message'] = "Registro realizado com sucesso. Agora você pode fazer login.";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Falha ao registrar. Tente novamente.";
            header("Location: register.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Erro: " . $e->getMessage();
        header("Location: register.php");
        exit;
    }
} else {
    header("Location: register.php");
    exit;
}
