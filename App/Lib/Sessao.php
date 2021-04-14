<?php

namespace App\Lib;

class Sessao
{

    /**
     * Grava uma mensagem na sessão atual
     *
     * @param [string] $mensagem
     * @return void
     */
    public static function gravaMensagem(string $mensagem)
    {
        $_SESSION['mensagem'] = $mensagem;
    }

    public static function limpaMensagem()
    {
        unset($_SESSION['mensagem']);
    }

    public static function retornaMensagem()
    {
        return ($_SESSION['mensagem']) ? $_SESSION['mensagem'] : "";
    }

    public static function gravaFormulario($form)
    {
        $_SESSION['form'] = $form;
    }

    public static function limpaFormulario()
    {
        unset($_SESSION['form']);
    }

    public static function retornaValorFormulario($key)
    {
        return (isset($_SESSION['form'][$key])) ? $_SESSION['form'][$key] : "";
    }

    public static function gravaErro($erros)
    {
        $_SESSION['erro'] = $erros;
    }

    public static function limpaErro()
    {
        unset($_SESSION['erro']);
    }

    public static function retornaErro()
    {
        return (isset($_SESSION['erro'])) ? $_SESSION['erro'] : false;
    }

}