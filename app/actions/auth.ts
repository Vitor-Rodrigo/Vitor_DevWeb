"use server"

import { cookies } from "next/headers"
import { redirect } from "next/navigation"
import { criarUsuario, autenticarUsuario } from "@/lib/auth"
import type { CadastroData, LoginData } from "@/types/auth"

export async function cadastrarAction(formData: FormData) {
  const dados: CadastroData = {
    nome_completo: formData.get("nome_completo") as string,
    email: formData.get("email") as string,
    senha: formData.get("senha") as string,
    confirmar_senha: formData.get("confirmar_senha") as string,
  }

  // Validações
  if (!dados.nome_completo || dados.nome_completo.length < 2) {
    return { sucesso: false, mensagem: "Nome deve ter pelo menos 2 caracteres" }
  }

  if (!dados.email || !dados.email.includes("@")) {
    return { sucesso: false, mensagem: "Email inválido" }
  }

  if (!dados.senha || dados.senha.length < 6) {
    return { sucesso: false, mensagem: "Senha deve ter pelo menos 6 caracteres" }
  }

  if (dados.senha !== dados.confirmar_senha) {
    return { sucesso: false, mensagem: "Senhas não coincidem" }
  }

  const resultado = await criarUsuario(dados)

  if (resultado.sucesso && resultado.usuario) {
    const cookieStore = await cookies()
    cookieStore.set("usuario_id", resultado.usuario.id.toString(), {
      httpOnly: true,
      secure: process.env.NODE_ENV === "production",
      sameSite: "lax",
      maxAge: 60 * 60 * 24 * 7, // 7 dias
    })
    redirect("/dashboard")
  }

  return resultado
}

export async function loginAction(formData: FormData) {
  const dados: LoginData = {
    email: formData.get("email") as string,
    senha: formData.get("senha") as string,
  }

  if (!dados.email || !dados.senha) {
    return { sucesso: false, mensagem: "Email e senha são obrigatórios" }
  }

  const resultado = await autenticarUsuario(dados)

  if (resultado.sucesso && resultado.usuario) {
    const cookieStore = await cookies()
    cookieStore.set("usuario_id", resultado.usuario.id.toString(), {
      httpOnly: true,
      secure: process.env.NODE_ENV === "production",
      sameSite: "lax",
      maxAge: 60 * 60 * 24 * 7, // 7 dias
    })
    redirect("/dashboard")
  }

  return resultado
}

export async function logoutAction() {
  const cookieStore = await cookies()
  cookieStore.delete("usuario_id")
  redirect("/login")
}
