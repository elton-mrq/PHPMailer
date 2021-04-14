<?php

namespace App\Models\DAO;

use App\Lib\Conexao;
use App\Lib\Sessao;
use App\Models\Entidades\Usuario;
use PDOException;
use Exception;

class UsuarioDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct('usuario');
    }

    public function buscarPorEmail($email)
    {
        $resultado =  $this->select("email = '" . $email . "'");

        if(!empty($resultado)){

            return $resultado->fetchObject(Usuario::class);

        }

        return false;
    }

    public function salvar(Usuario $usuario)
    {
        $idUsuario = null;
        try {
            
            $this->insert([
                                'email'        => $usuario->getEmail(),
                                'login'        => $usuario->getLogin(),
                                'senha'        => $usuario->getSenha(),
                                'status'       => $usuario->getStatus()
                            ]);

            
            $idUsuario = Conexao::getConnection()->lastInsertId();            
            
            if($idUsuario === null){
                
                throw new Exception('Impossível determinar o último id gerado!');
            }

        } catch (Exception $exc) {
            
            throw new Exception("Erro na gravação de dados: " . $idUsuario, 500);

        }

        return $idUsuario;
    }

    public function ativar(Usuario $usuario)
    {
        try {
            
            $this->update('id = ' . $usuario->getId(),
                          [
                             'status'   => 1   
                          ] );

        } catch (Exception $exc) {
            
            throw new Exception("Erro na gravação de dados: " . $exc->getMessage(), 500);

        }
    }
}