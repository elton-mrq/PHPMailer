<?php

namespace App\Models\Validacao\Hash;

use App\Models\Entidades\Hash;
use App\Models\Validacao\ResultadoValidacao;

class HashCadastroValidador
{
    public function validar(Hash $hash)
    {
        $resultadoValidacao = new ResultadoValidacao();

        if(empty($hash)){
            $resultadoValidacao->addErro('Status', 'Chave inválida!');
        }

        if(empty($hash->getIdUsuario())){
            $resultadoValidacao('idUsuario', 'Este campo é requerido!');
        }

        if(empty($hash->getHash())){
            $resultadoValidacao->addErro('Hash', 'Este campo é requerido!');
        }

        return $resultadoValidacao;
    }
}