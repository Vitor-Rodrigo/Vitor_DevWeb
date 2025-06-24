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
    $email = sanitize($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if (empty($email) || empty($senha)) {
        $erro = 'Email e senha são obrigatórios';
    } else {
        $auth = new Auth();
        $resultado = $auth->login(['email' => $email, 'senha' => $senha]);
        
        if ($resultado['sucesso']) {
            redirect('dashboard.php');
        } else {
            $erro = $resultado['mensagem'];
        }
    }
}

$pageTitle = 'Login - Dashboard Moderno';
include 'includes/header.php';
?>

<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md space-y-6">
        <div class="text-center space-y-2">
            <div class="mx-auto w-16 h-16 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="log-in" class="w-8 h-8 text-white"></i>
            </div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                Bem-vindo de volta
            </h1>
            <p class="text-gray-600">Entre com suas credenciais para acessar o dashboard</p>
        </div>

        <div class="glass-effect rounded-xl shadow-xl p-6">
            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Login</h2>
                <p class="text-gray-600 text-sm">
                    Não tem uma conta? 
                    <a href="cadastro.php" class="text-emerald-600 hover:text-emerald-700 font-medium">Cadastre-se</a>
                </p>
            </div>

            <form method="POST" class="space-y-4">
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
                        class="w-full h-11 px-3 border border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-20 outline-none transition-all"
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
                        placeholder="Sua senha"
                        required
                        class="w-full h-11 px-3 border border-gray-200 rounded-lg focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-20 outline-none transition-all"
                    />
                </div>

                <?php if ($erro): ?>
                    <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 text-sm"><?php echo htmlspecialchars($erro); ?></p>
                    </div>
                <?php endif; ?>

                <button
                    type="submit"
                    class="w-full h-11 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-medium rounded-lg transition-all"
                >
                    Entrar
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="#" class="text-sm text-gray-600 hover:text-gray-800">Esqueceu sua senha?</a>
            </div>
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
