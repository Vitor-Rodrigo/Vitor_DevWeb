import bcrypt from "bcryptjs"
import { executeQuery } from "./database"
import type { Usuario, LoginData, CadastroData } from "@/types/auth"

export async function criarUsuario(
  dados: CadastroData,
): Promise<{ sucesso: boolean; mensagem: string; usuario?: Usuario }> {
  try {
    // Verificar se email já existe
    const usuarioExistente = (await executeQuery("SELECT id FROM usuarios WHERE email = ?", [dados.email])) as any[]

    if (usuarioExistente.length > 0) {
      return { sucesso: false, mensagem: "Este email já está cadastrado" }
    }

    // Criptografar senha
    const senhaHash = await bcrypt.hash(dados.senha, 12)

    // Inserir usuário
    const resultado = (await executeQuery("INSERT INTO usuarios (nome_completo, email, senha) VALUES (?, ?, ?)", [
      dados.nome_completo,
      dados.email,
      senhaHash,
    ])) as any

    // Buscar usuário criado
    const novoUsuario = (await executeQuery(
      "SELECT id, nome_completo, email, data_criacao, ativo FROM usuarios WHERE id = ?",
      [resultado.insertId],
    )) as Usuario[]

    return {
      sucesso: true,
      mensagem: "Usuário criado com sucesso!",
      usuario: novoUsuario[0],
    }
  } catch (error) {
    console.error("Erro ao criar usuário:", error)
    return { sucesso: false, mensagem: "Erro interno do servidor" }
  }
}

export async function autenticarUsuario(
  dados: LoginData,
): Promise<{ sucesso: boolean; mensagem: string; usuario?: Usuario }> {
  try {
    const usuarios = (await executeQuery("SELECT * FROM usuarios WHERE email = ? AND ativo = TRUE", [
      dados.email,
    ])) as any[]

    if (usuarios.length === 0) {
      return { sucesso: false, mensagem: "Email ou senha incorretos" }
    }

    const usuario = usuarios[0]
    const senhaValida = await bcrypt.compare(dados.senha, usuario.senha)

    if (!senhaValida) {
      return { sucesso: false, mensagem: "Email ou senha incorretos" }
    }

    // Atualizar último acesso
    await executeQuery("UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = ?", [usuario.id])

    const { senha, ...usuarioSemSenha } = usuario
    return {
      sucesso: true,
      mensagem: "Login realizado com sucesso!",
      usuario: usuarioSemSenha,
    }
  } catch (error) {
    console.error("Erro na autenticação:", error)
    return { sucesso: false, mensagem: "Erro interno do servidor" }
  }
}
