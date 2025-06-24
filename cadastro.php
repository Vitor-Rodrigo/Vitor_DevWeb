<?php
require_once 'config/config.php';
require_once 'classes/Auth.php';

// Redirecionar se já estiver logado
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo = sanitize($_POST['nome_completo'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Validações
    if (strlen($nome_completo) < 2) {
        $erro = 'Nome deve ter pelo menos 2 caracteres';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Email inválido';
    } elseif (strlen($senha) < 6) {
        $erro = 'Senha deve ter pelo menos 6 caracteres';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'Senhas não coincidem';
    } else {
        $auth = new Auth();
        $resultado = $auth->cadastrar([
            'nome_completo' => $nome_completo,
            'email' => $email,
            'senha' => $senha
        ]);
        
        if ($resultado['sucesso']) {
            // Login automático após cadastro
            $_SESSION['usuario_id'] = $resultado['usuario']['id'];
            $_SESSION['usuario_nome'] = $resultado['usuario']['nome_completo'];
            $_SESSION['usuario_email'] = $resultado['usuario']['email'];
            redirect('dashboard.php');
        } else {
            $erro = $resultado['mensagem'];
        }
    }
}

$pageTitle = 'Cadastro - Dashboard Moderno';
include 'includes/header.php';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-6">
        <div class="text-center space-y-2">
            <div class="mx-auto w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="user-plus" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Criar Conta
            </h1>
            <p class="text-gray-600">Preencha os dados abaixo para criar sua conta</p>
        </div>

        <div class="glass-effect rounded-xl shadow-xl p-6">
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Cadastro</h2>
                <p class="text-gray-600 text-sm">
                    Já tem uma conta? 
                    <a href="login.php" class="text-blue-600 hover:text-blue-700 font-medium">Faça login</a>
                </p>
            </div>

            <form method="POST" class="space-y-4">
                <div class="space-y-2">
                    <label for="nome_completo" class="text-sm font-medium flex items-center gap-2 text-gray-700">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        Nome Completo
                    </label>
                    <input
                        id="nome_completo"
                        name="nome_completo"
                        type="text"
                        placeholder="Seu nome completo"
                        required
                        value="<?php echo htmlspecialchars($_POST['nome_completo'] ?? ''); ?>"
                        class="w-full h-11 px-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 outline-none transition-all"
                    />
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium flex items-center gap-2 text-gray-700">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="seu@email.com"
                        required
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                        class="w-full h-11 px-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 outline-none transition-all"
                    />
                </div>

                <div class="space-y-2">
                    <label for="senha" class="text-sm font-medium flex items-center gap-2 text-gray-700">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                        Senha
                    </label>
                    <input
                        id="senha"
                        name="senha"
                        type="password"
                        placeholder="Mínimo 6 caracteres"
                        required
                        class="w-full h-11 px-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 outline-none transition-all"
                    />
                </div>

                <div class="space-y-2">
                    <label for="confirmar_senha" class="text-sm font-medium flex items-center gap-2 text-gray-700">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                        Confirmar Senha
                    </label>
                    <input
                        id="confirmar_senha"
                        name="confirmar_senha"
                        type="password"
                        placeholder="Digite a senha novamente"
                        required
                        class="w-full h-11 px-3 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-20 outline-none transition-all"
                    />
                </div>

                <?php if ($erro): ?>
                    <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($erro); ?></p>
                    </div>
                <?php endif; ?>

                <button
                    type="submit"
                    class="w-full h-11 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all"
                >
                    Criar Conta
                </button>
            </form>
        </div>

        <div class="text-center">
            <a href="index.php" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Voltar ao início
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
