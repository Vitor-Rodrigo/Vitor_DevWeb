"use client"

import type { Usuario, DashboardStats } from "@/types/auth"
import { logoutAction } from "@/app/actions/auth"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Avatar, AvatarFallback } from "@/components/ui/avatar"
import {
  Users,
  UserCheck,
  UserPlus,
  Activity,
  LogOut,
  Settings,
  Bell,
  Search,
  BarChart3,
  TrendingUp,
} from "lucide-react"

interface DashboardContentProps {
  usuario: Usuario
  stats: DashboardStats
}

export function DashboardContent({ usuario, stats }: DashboardContentProps) {
  const iniciais = usuario.nome_completo
    .split(" ")
    .map((nome) => nome[0])
    .join("")
    .toUpperCase()
    .slice(0, 2)

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
      {/* Header */}
      <header className="bg-white/80 backdrop-blur-sm border-b border-gray-200 sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center gap-4">
              <div className="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                <BarChart3 className="w-5 h-5 text-white" />
              </div>
              <h1 className="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                Dashboard Moderno
              </h1>
            </div>

            <div className="flex items-center gap-4">
              <Button variant="ghost" size="icon" className="relative">
                <Bell className="w-5 h-5" />
                <span className="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
              </Button>

              <div className="flex items-center gap-3">
                <Avatar className="w-8 h-8">
                  <AvatarFallback className="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm">
                    {iniciais}
                  </AvatarFallback>
                </Avatar>
                <div className="hidden sm:block">
                  <p className="text-sm font-medium text-gray-900">{usuario.nome_completo}</p>
                  <p className="text-xs text-gray-500">{usuario.email}</p>
                </div>
              </div>

              <form action={logoutAction}>
                <Button variant="ghost" size="icon" type="submit">
                  <LogOut className="w-5 h-5" />
                </Button>
              </form>
            </div>
          </div>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Welcome Section */}
        <div className="mb-8">
          <h2 className="text-3xl font-bold text-gray-900 mb-2">Olá, {usuario.nome_completo.split(" ")[0]}! 👋</h2>
          <p className="text-gray-600">
            Bem-vindo ao seu dashboard. Aqui você pode acompanhar todas as métricas importantes.
          </p>
        </div>

        {/* Stats Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <Card className="border-0 shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium opacity-90">Total de Usuários</CardTitle>
              <Users className="h-4 w-4 opacity-90" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stats.total_usuarios}</div>
              <p className="text-xs opacity-90">Usuários cadastrados</p>
            </CardContent>
          </Card>

          <Card className="border-0 shadow-lg bg-gradient-to-br from-emerald-500 to-emerald-600 text-white">
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium opacity-90">Usuários Ativos</CardTitle>
              <UserCheck className="h-4 w-4 opacity-90" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stats.usuarios_ativos}</div>
              <p className="text-xs opacity-90">Contas ativas</p>
            </CardContent>
          </Card>

          <Card className="border-0 shadow-lg bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium opacity-90">Novos Usuários</CardTitle>
              <UserPlus className="h-4 w-4 opacity-90" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stats.novos_usuarios_mes}</div>
              <p className="text-xs opacity-90">Este mês</p>
            </CardContent>
          </Card>

          <Card className="border-0 shadow-lg bg-gradient-to-br from-orange-500 to-orange-600 text-white">
            <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
              <CardTitle className="text-sm font-medium opacity-90">Crescimento</CardTitle>
              <TrendingUp className="h-4 w-4 opacity-90" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">+12%</div>
              <p className="text-xs opacity-90">Vs. mês anterior</p>
            </CardContent>
          </Card>
        </div>

        {/* Content Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Recent Activity */}
          <Card className="lg:col-span-2 border-0 shadow-lg bg-white/80 backdrop-blur-sm">
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Activity className="w-5 h-5" />
                Atividade Recente
              </CardTitle>
              <CardDescription>Últimas ações realizadas no sistema</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {[
                  { acao: "Novo usuário cadastrado", tempo: "2 minutos atrás", tipo: "success" },
                  { acao: "Login realizado", tempo: "5 minutos atrás", tipo: "info" },
                  { acao: "Configuração atualizada", tempo: "1 hora atrás", tipo: "warning" },
                  { acao: "Backup realizado", tempo: "2 horas atrás", tipo: "success" },
                ].map((item, index) => (
                  <div key={index} className="flex items-center gap-3 p-3 rounded-lg bg-gray-50">
                    <div
                      className={`w-2 h-2 rounded-full ${
                        item.tipo === "success"
                          ? "bg-green-500"
                          : item.tipo === "warning"
                            ? "bg-yellow-500"
                            : "bg-blue-500"
                      }`}
                    />
                    <div className="flex-1">
                      <p className="text-sm font-medium text-gray-900">{item.acao}</p>
                      <p className="text-xs text-gray-500">{item.tempo}</p>
                    </div>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>

          {/* Quick Actions */}
          <Card className="border-0 shadow-lg bg-white/80 backdrop-blur-sm">
            <CardHeader>
              <CardTitle className="flex items-center gap-2">
                <Settings className="w-5 h-5" />
                Ações Rápidas
              </CardTitle>
              <CardDescription>Acesso rápido às principais funcionalidades</CardDescription>
            </CardHeader>
            <CardContent className="space-y-3">
              <Button className="w-full justify-start" variant="outline">
                <UserPlus className="w-4 h-4 mr-2" />
                Adicionar Usuário
              </Button>
              <Button className="w-full justify-start" variant="outline">
                <Search className="w-4 h-4 mr-2" />
                Buscar Dados
              </Button>
              <Button className="w-full justify-start" variant="outline">
                <Settings className="w-4 h-4 mr-2" />
                Configurações
              </Button>
              <Button className="w-full justify-start" variant="outline">
                <BarChart3 className="w-4 h-4 mr-2" />
                Relatórios
              </Button>
            </CardContent>
          </Card>
        </div>

        {/* User Info */}
        <Card className="mt-6 border-0 shadow-lg bg-white/80 backdrop-blur-sm">
          <CardHeader>
            <CardTitle>Informações da Conta</CardTitle>
            <CardDescription>Detalhes da sua conta no sistema</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <p className="text-sm font-medium text-gray-500">Nome Completo</p>
                <p className="text-lg font-semibold text-gray-900">{usuario.nome_completo}</p>
              </div>
              <div>
                <p className="text-sm font-medium text-gray-500">Email</p>
                <p className="text-lg font-semibold text-gray-900">{usuario.email}</p>
              </div>
              <div>
                <p className="text-sm font-medium text-gray-500">Data de Cadastro</p>
                <p className="text-lg font-semibold text-gray-900">
                  {new Date(usuario.data_criacao).toLocaleDateString("pt-BR")}
                </p>
              </div>
              <div>
                <p className="text-sm font-medium text-gray-500">Último Acesso</p>
                <p className="text-lg font-semibold text-gray-900">
                  {usuario.ultimo_acesso
                    ? new Date(usuario.ultimo_acesso).toLocaleDateString("pt-BR")
                    : "Primeiro acesso"}
                </p>
              </div>
            </div>
          </CardContent>
        </Card>
      </main>
    </div>
  )
}
