<?php

namespace App\Models\DAO;

use App\Lib\Conexao;
use Exception;
use App\Models\Entidades\Hash;

class HashDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct('hash');
    }

    public function listarPorIdUsuario($idUsuario = null)
    {
        $resultado = $this->select('id_Usuario = ' . $idUsuario);
        return $resultado->fetchObject(Hash::class);
    }

    public function salvar(Hash $hash)
    {

        $idHash = null;

        try {
            
            $this->insert([
                            'hash'      => $hash->getHash(),
                            'status'    => $hash->getStatus(),
                            'id_usuario' => $hash->getIdUsuario()
                          ]);
            
            $idHash = Conexao::getConnection()->lastInsertId();

            if(empty($idHash)){
                throw new Exception("Impossível determinar o último id gerado");
            }

        } catch (Exception $exc) {
            
            throw new Exception ("Erro na gravação de dados: " . $exc->getMessage(), 500);

        }

        return $idHash;
    }

    public function ativar(Hash $hash)
    {
        try {
            
            $this->update('id = ' . $hash->getId(),
                          [
                            'status' => 1
                          ]);

        } catch (Exception $exc) {
            
            throw new Exception("Erro na gravação de dados: " . $exc->getMessage(), 500);       }
    }

}