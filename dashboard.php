<?php
require_once 'config/config.php';
require_once 'classes/Auth.php';

// Proteger página
requireLogin();

// Processar logout
if (isset($_GET['logout'])) {
    $auth = new Auth();
    $auth->logout();
}

$auth = new Auth();
$usuario = $auth->getUsuario($_SESSION['usuario_id']);
$stats = $auth->getDashboardStats();

if (!$usuario) {
    session_destroy();
    redirect('login.php');
}

$pageTitle = 'Dashboard - Dashboard Moderno';
include 'includes/header.php';

// Função para obter iniciais do nome
function getIniciais($nome) {
    $partes = explode(' ', $nome);
    $iniciais = '';
    foreach ($partes as $parte) {
        if (!empty($parte)) {
            $iniciais .= strtoupper($parte[0]);
        }
    }
    return substr($iniciais, 0, 2);
}

$iniciais = getIniciais($usuario['nome_completo']);
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header -->
    <header class="glass-effect border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-white"></i>
                    </div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Dashboard Moderno
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                    </button>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium"><?php echo $iniciais; ?></span>
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($usuario['nome_completo']); ?></p>
                            <p class="text-xs text-gray-500"><?php echo htmlspecialchars($usuario['email']); ?></p>
                        </div>
                    </div>

                    <a href="?logout=1" class="p-2 text-gray-600 hover:text-gray-900 transition-colors" title="Sair">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                Olá, <?php echo htmlspecialchars(explode(' ', $usuario['nome_completo'])[0]); ?>! 👋
            </h2>
            <p class="text-gray-600">
                Bem-vindo ao seu dashboard. Aqui você pode acompanhar todas as métricas importantes.
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Total de Usuários</h3>
                    <i data-lucide="users" class="w-4 h-4 opacity-90"></i>
                </div>
                <div class="text-2xl font-bold"><?php echo number_format($stats['total_usuarios']); ?></div>
                <p class="text-xs opacity-90">Usuários cadastrados</p>
            </div>

            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Usuários Ativos</h3>
                    <i data-lucide="user-check" class="w-4 h-4 opacity-90"></i>
                </div>
                <div class="text-2xl font-bold"><?php echo number_format($stats['usuarios_ativos']); ?></div>
                <p class="text-xs opacity-90">Contas ativas</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Novos Usuários</h3>
                    <i data-lucide="user-plus" class="w-4 h-4 opacity-90"></i>
                </div>
                <div class="text-2xl font-bold"><?php echo number_format($stats['novos_usuarios_mes']); ?></div>
                <p class="text-xs opacity-90">Este mês</p>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-medium opacity-90">Crescimento</h3>
                    <i data-lucide="trending-up" class="w-4 h-4 opacity-90"></i>
                </div>
                <div class="text-2xl font-bold">+12%</div>
                <p class="text-xs opacity-90">Vs. mês anterior</p>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Activity -->
            <div class="lg:col-span-2 glass-effect rounded-xl p-6 shadow-lg">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-2">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                        Atividade Recente
                    </h3>
                    <p class="text-gray-600 text-sm">Últimas ações realizadas no sistema</p>
                </div>

                <div class="space-y-4">
                    <?php
                    $atividades = [
                        ['acao' => 'Novo usuário cadastrado', 'tempo' => '2 minutos atrás', 'tipo' => 'success'],
                        ['acao' => 'Login realizado', 'tempo' => '5 minutos atrás', 'tipo' => 'info'],
                        ['acao' => 'Configuração atualizada', 'tempo' => '1 hora atrás', 'tipo' => 'warning'],
                        ['acao' => 'Backup realizado', 'tempo' => '2 horas atrás', 'tipo' => 'success']
                    ];

                    foreach ($atividades as $item):
                        $corClass = $item['tipo'] === 'success' ? 'bg-green-500' : 
                                   ($item['tipo'] === 'warning' ? 'bg-yellow-500' : 'bg-blue-500');
                    ?>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50">
                            <div class="w-2 h-2 rounded-full <?php echo $corClass; ?>"></div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo $item['acao']; ?></p>
                                <p class="text-xs text-gray-500"><?php echo $item['tempo']; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-effect rounded-xl p-6 shadow-lg">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 mb-2">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        Ações Rápidas
                    </h3>
                    <p class="text-gray-600 text-sm">Acesso rápido às principais funcionalidades</p>
                </div>

                <div class="space-y-3">
                    <button class="w-full flex items-center gap-2 p-3 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Adicionar Usuário
                    </button>
                    <button class="w-full flex items-center gap-2 p-3 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Buscar Dados
                    </button>
                    <button class="w-full flex items-center gap-2 p-3 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                        Configurações
                    </button>
                    <button class="w-full flex items-center gap-2 p-3 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                        Relatórios
                    </button>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="mt-6 glass-effect rounded-xl p-6 shadow-lg">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Informações da Conta</h3>
                <p class="text-gray-600 text-sm">Detalhes da sua conta no sistema</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nome Completo</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($usuario['nome_completo']); ?></p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($usuario['email']); ?></p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Data de Cadastro</p>
                    <p class="text-lg font-semibold text-gray-900">
                        <?php echo date('d/m/Y', strtotime($usuario['data_criacao'])); ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Último Acesso</p>
                    <p class="text-lg font-semibold text-gray-900">
                        <?php 
                        echo $usuario['ultimo_acesso'] 
                            ? date('d/m/Y H:i', strtotime($usuario['ultimo_acesso']))
                            : 'Primeiro acesso';
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
