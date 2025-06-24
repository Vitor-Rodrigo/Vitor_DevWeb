<?php
require_once 'config/database.php';

class Auth {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function cadastrar($dados) {
        try {
            // Verificar se email já existe
            $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$dados['email']]);
            
            if ($stmt->rowCount() > 0) {
                return ['sucesso' => false, 'mensagem' => 'Este email já está cadastrado'];
            }
            
            // Criptografar senha
            $senhaHash = password_hash($dados['senha'], PASSWORD_DEFAULT);
            
            // Inserir usuário
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nome_completo, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$dados['nome_completo'], $dados['email'], $senhaHash]);
            
            $usuarioId = $this->conn->lastInsertId();
            
            // Buscar usuário criado
            $stmt = $this->conn->prepare("SELECT id, nome_completo, email, data_criacao, ativo FROM usuarios WHERE id = ?");
            $stmt->execute([$usuarioId]);
            $usuario = $stmt->fetch();
            
            return [
                'sucesso' => true,
                'mensagem' => 'Usuário criado com sucesso!',
                'usuario' => $usuario
            ];
            
        } catch (Exception $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro interno do servidor'];
        }
    }
    
    public function login($dados) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ? AND ativo = TRUE");
            $stmt->execute([$dados['email']]);
            
            if ($stmt->rowCount() === 0) {
                return ['sucesso' => false, 'mensagem' => 'Email ou senha incorretos'];
            }
            
            $usuario = $stmt->fetch();
            
            if (!password_verify($dados['senha'], $usuario['senha'])) {
                return ['sucesso' => false, 'mensagem' => 'Email ou senha incorretos'];
            }
            
            // Atualizar último acesso
            $stmt = $this->conn->prepare("UPDATE usuarios SET ultimo_acesso = NOW() WHERE id = ?");
            $stmt->execute([$usuario['id']]);
            
            // Criar sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome_completo'];
            $_SESSION['usuario_email'] = $usuario['email'];
            
            unset($usuario['senha']);
            return [
                'sucesso' => true,
                'mensagem' => 'Login realizado com sucesso!',
                'usuario' => $usuario
            ];
            
        } catch (Exception $e) {
            error_log("Erro na autenticação: " . $e->getMessage());
            return ['sucesso' => false, 'mensagem' => 'Erro interno do servidor'];
        }
    }
    
    public function logout() {
        session_destroy();
        redirect('login.php');
    }
    
    public function getUsuario($id) {
        try {
            $stmt = $this->conn->prepare("SELECT id, nome_completo, email, data_criacao, ultimo_acesso, ativo FROM usuarios WHERE id = ? AND ativo = TRUE");
            $stmt->execute([$id]);
            
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return null;
        }
    }
    
    public function getDashboardStats() {
        try {
            $stats = [];
            
            // Total de usuários
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM usuarios");
            $stats['total_usuarios'] = $stmt->fetch()['total'];
            
            // Usuários ativos
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM usuarios WHERE ativo = TRUE");
            $stats['usuarios_ativos'] = $stmt->fetch()['total'];
            
            // Novos usuários no mês
            $stmt = $this->conn->query("SELECT COUNT(*) as total FROM usuarios WHERE data_criacao >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
            $stats['novos_usuarios_mes'] = $stmt->fetch()['total'];
            
            $stats['sessoes_ativas'] = 0; // Implementar se necessário
            
            return $stats;
        } catch (Exception $e) {
            error_log("Erro ao buscar estatísticas: " . $e->getMessage());
            return [
                'total_usuarios' => 0,
                'usuarios_ativos' => 0,
                'novos_usuarios_mes' => 0,
                'sessoes_ativas' => 0
            ];
        }
    }
}
?>
