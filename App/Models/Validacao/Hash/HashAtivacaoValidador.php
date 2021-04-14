<?php

namespace App\Models\Validacao\Hash;

use App\Models\Entidades\Hash;
use App\Models\Validacao\ResultadoValidacao;

class HashAtivacaoValidador
{
    public function validar(Hash $hash)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $resultadoValidacao = new ResultadoValidacao();

        if(empty($hash)){
            $resultadoValidacao->addErro('Status', 'Chave inválida!');
        }

        if($hash->getStatus() === 1){
            $resultadoValidacao('Status', 'A chave já está ativa!');
        }

        $dataAtual = new \DateTime('now');
        $diferenca = $hash->getDataCadastro()->diff($dataAtual);

        if(($diferenca->h + ($diferenca->days * 24)) > 72){
            $resultadoValidacao->addErro('Status', 'Chave expirada');
        }

        return $resultadoValidacao;
    }
}