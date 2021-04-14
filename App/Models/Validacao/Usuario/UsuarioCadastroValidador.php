<?php

namespace App\Models\Validacao\Usuario;

use App\Models\Entidades\Usuario;
use App\Models\Validacao\ResultadoValidacao;

class UsuarioCadastroValidador
{
    public function validar(Usuario $usuario)
    {
        $resultado = new ResultadoValidacao();

        if(empty($usuario)){
            $resultado->addErro('Status', 'Chave inválida!');
        }

        if(empty($usuario->getSenha())){
            $resultado->addErro('Senha', "Este campo é requerido!");
        }

        if(empty($usuario->getLogin())){
            $resultado->addErro('Login', 'Informe pelo menos 2 caracteres!');
        }

        if(empty($usuario->getEmail())){
            $resultado->addErro('E-mail', 'Este campo é requerido!');
        }

        return $resultado;
    }
}