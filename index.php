<?php
require_once 'config/config.php';
$pageTitle = 'Dashboard Moderno - Início';
include 'includes/header.php';
?>

<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <!-- Header -->
    <header class="glass-effect border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Dashboard Moderno
                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="login.php" class="px-4 py-2 text-gray-700 hover:text-gray-900 transition-colors">
                        Entrar
                    </a>
                    <a href="cadastro.php" class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Cadastrar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-6">
                Gerencie seus dados com
                <span class="block bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Inteligência e Estilo
                </span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Uma plataforma moderna e segura para gerenciar usuários, visualizar métricas e acompanhar o crescimento do
                seu negócio em tempo real.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="cadastro.php" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-lg font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                    Começar Agora
                    <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                </a>
                <a href="login.php" class="inline-flex items-center px-8 py-3 border-2 border-gray-300 text-gray-700 text-lg font-medium rounded-lg hover:border-gray-400 transition-all">
                    Fazer Login
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white/50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Por que escolher nosso Dashboard?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Desenvolvido com as melhores práticas de segurança e experiência do usuário
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="glass-effect rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mb-4">
                        <i data-lucide="shield" class="w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Segurança Avançada</h3>
                    <p class="text-gray-600">Criptografia de ponta e autenticação segura para proteger seus dados</p>
                </div>

                <div class="glass-effect rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center mb-4">
                        <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Performance Otimizada</h3>
                    <p class="text-gray-600">Interface rápida e responsiva construída com tecnologias modernas</p>
                </div>

                <div class="glass-effect rounded-xl p-6 shadow-lg">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                        <i data-lucide="users" class="w-6 h-6 text-white"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Gestão Intuitiva</h3>
                    <p class="text-gray-600">Interface amigável para gerenciar usuários e visualizar métricas</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xl font-bold">Dashboard Moderno</span>
                </div>
                <p class="text-gray-400 mb-6">Transformando dados em insights valiosos para o seu negócio</p>
                <div class="flex justify-center gap-6">
                    <a href="login.php" class="text-gray-400 hover:text-white transition-colors">Login</a>
                    <a href="cadastro.php" class="text-gray-400 hover:text-white transition-colors">Cadastro</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php include 'includes/footer.php'; ?>
