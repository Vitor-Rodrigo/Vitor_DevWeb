import { cookies } from "next/headers"
import { redirect } from "next/navigation"
import { executeQuery } from "@/lib/database"
import type { Usuario, DashboardStats } from "@/types/auth"
import { DashboardContent } from "@/components/dashboard-content"

async function getUsuario(id: string): Promise<Usuario | null> {
  try {
    const usuarios = (await executeQuery(
      "SELECT id, nome_completo, email, data_criacao, ultimo_acesso, ativo FROM usuarios WHERE id = ? AND ativo = TRUE",
      [id],
    )) as Usuario[]

    return usuarios[0] || null
  } catch (error) {
    console.error("Erro ao buscar usuário:", error)
    return null
  }
}

async function getDashboardStats(): Promise<DashboardStats> {
  try {
    const [totalUsuarios] = (await executeQuery("SELECT COUNT(*) as total FROM usuarios")) as any[]
    const [usuariosAtivos] = (await executeQuery("SELECT COUNT(*) as total FROM usuarios WHERE ativo = TRUE")) as any[]
    const [novosUsuarios] = (await executeQuery(
      "SELECT COUNT(*) as total FROM usuarios WHERE data_criacao >= DATE_SUB(NOW(), INTERVAL 1 MONTH)",
    )) as any[]

    return {
      total_usuarios: totalUsuarios.total,
      usuarios_ativos: usuariosAtivos.total,
      novos_usuarios_mes: novosUsuarios.total,
      sessoes_ativas: 0, // Implementar contagem de sessões se necessário
    }
  } catch (error) {
    console.error("Erro ao buscar estatísticas:", error)
    return {
      total_usuarios: 0,
      usuarios_ativos: 0,
      novos_usuarios_mes: 0,
      sessoes_ativas: 0,
    }
  }
}

export default async function DashboardPage() {
  const cookieStore = await cookies()
  const usuarioId = cookieStore.get("usuario_id")?.value

  if (!usuarioId) {
    redirect("/login")
  }

  const usuario = await getUsuario(usuarioId)
  if (!usuario) {
    redirect("/login")
  }

  const stats = await getDashboardStats()

  return <DashboardContent usuario={usuario} stats={stats} />
}
