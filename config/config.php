<?php
// Configurações gerais
define('SITE_URL', 'http://localhost');
define('SITE_NAME', 'Dashboard Moderno');

// Configurações de sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Mudar para 1 em HTTPS

// Iniciar sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload das classes
spl_autoload_register(function ($class_name) {
    $directories = ['config/', 'classes/', 'includes/'];
    
    foreach ($directories as $directory) {
        $file = $directory . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Função para sanitizar dados
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Função para redirecionar
function redirect($url) {
    header("Location: $url");
    exit();
}

// Função para verificar se está logado
function isLoggedIn() {
    return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
}

// Função para proteger páginas
function requireLogin() {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
}
?>
