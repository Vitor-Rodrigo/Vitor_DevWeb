export interface Usuario {
  id: number
  nome_completo: string
  email: string
  data_criacao: string
  ultimo_acesso?: string
  ativo: boolean
}

export interface LoginData {
  email: string
  senha: string
}

export interface CadastroData {
  nome_completo: string
  email: string
  senha: string
  confirmar_senha: string
}

export interface DashboardStats {
  total_usuarios: number
  usuarios_ativos: number
  novos_usuarios_mes: number
  sessoes_ativas: number
}
