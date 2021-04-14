<?php

namespace App\Controllers;

use Exception;
use App\Lib\Sessao;
use App\Lib\Email;
use App\Lib\Criptografia;
use App\Models\DAO\HashDAO;
use App\Models\Entidades\Usuario;
use App\Models\Entidades\Hash;
use App\Models\DAO\UsuarioDAO;
use App\Models\Validacao\Hash\HashAtivacaoValidador;
use App\Models\Validacao\Usuario\UsuarioCadastroValidador;
use App\Models\Validacao\Usuario\HashCadastroValidador;

class UsuarioController extends Controller
{

    public function index()
    {
        $this->render('usuario/index');

        Sessao::limpaMensagem();
    }

    public function cadastrar()
    {
       
        Sessao::gravaFormulario($_POST);

        try{
            
            $email = $_POST['email'];
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscarPorEmail($email);

            if(!empty($usuario)){
                if($usuario->getStatus() == 1){
                    Sessao::gravaMensagem("Usuario já cadastrado");

                    $this->redirect('usuario/ativacao');
                }else if($usuario->getStatus() == 0){
                    $this->redirect('usuario/ativacao');
                }
            }

            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setLogin($_POST['login']);
            $usuario->setStatus(0);
            $usuario->setSenha(Criptografia::criptografar($_POST['senha']));

            $usuarioValidador = new UsuarioCadastroValidador();
            $resultadoValidacao = $usuarioValidador->validar($usuario);
            $erros = $resultadoValidacao->getErros();

            if(!empty($erros)){
                $mensagem = implode('<br>', $erros);

                Sessao::gravaMensagem($mensagem);

                $this->redirect('home/index');
            }

            $idUsuario = $usuarioDAO->salvar($usuario);
            $usuario->setId($idUsuario);

            $hash = new Hash();
            $hash->setStatus(0);
            $hash->setIdUsuario($usuario->getId());
            $hash->setHash(Criptografia::criptografar($usuario->getEmail()));

            $hashValidador = new HashAtivacaoValidador();
            $resultadoValidacao = $hashValidador->validar($hash);
            $erros = $resultadoValidacao->getErros();

            if(!empty($erros)){
                $msg = implode('<br>', $erros);
                Sessao::gravaMensagem($msg);
                $this->redirect('home/index');
            }

            $hashDAO = new HashDAO();
            $hashDAO->salvar($hash);
            
            Email::enviarEmailConfirmacao($usuario, $hash);

            Sessao::gravaMensagem("Só falta um passo :) Você precisa confirmar seu cadastro através da mensagem enviada para o seu e-mail!");

            $this->redirect('usuario/ativacao');

        }catch(Exception $exc){

            Sessao::gravaMensagem($exc->getMessage());

        }    
        
        $this->render('home/index');

        Sessao::limpaMensagem();
        Sessao::limpaFormulario();          

    }

    public function ativacao($params)
    {
        try {
            
            if(empty($params)){
                throw new Exception('Use o link na mensagem enviada para o seu e-mail para ativar seu cadastro!');
            }

            $email = Criptografia::descriptografar($params[0]);

            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscarPorEmail($email);

            if(empty($usuario)){
                Sessao::limpaFormulario();
                throw new Exception('Usuário não cadastrado.');
            }

            $hashDAO = new HashDAO();
            $hash = $hashDAO->listarPorIdUsuario($usuario->getId());

            if(!empty($hash) && $hash->getStatus() == 1){
                Sessao::limpaFormulario();
                throw new Exception('A chave já foi confirmada.');
            }

            $hashValidator = new HashAtivacaoValidador();
            $resultadoValidacao = $hashValidator->validar($hash);
            $erros = $resultadoValidacao->getErros();

            if(!empty($erros)){
                $mensagem = implode('<br>', $erros);
                Sessao::gravaMensagem($mensagem);
            }

            if($hash->getHash() !== $params[0]){
                Sessao::limpaFormulario();
                throw new Exception('A chave não está associada ao usuário de origem.');
            }

            $hashDAO->ativar($hash);
            $usuarioDAO->ativar($usuario);

            $this->redirect('usuario/index');

        } catch (Exception $exc) {
            Sessao::gravaMensagem($exc->getMessage());
        }

        $this->render('usuario/ativacao');

        Sessao::limpaMensagem();
    }

    public function reenviar()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->buscarPorEmail($_POST['email']);

            if(empty($usuario)){
                throw new Exception('Usuário não encontrado!');
            }

            $hashDAO = new HashDAO();
            $hash = $hashDAO->listarPorIdUsuario($usuario->getId());

            if(!empty($hash) && $hash->getStatus() == 1){
                Sessao::gravaMensagem('A chave já foi confirmada!');
                $this->redirect('home/index');
            }

            $hashValidator = new HashAtivacaoValidador();
            $resultadoValidacao = $hashValidator->validar($hash);
            $erros = $resultadoValidacao->getErros();

            if(!empty($erros)){
                $mensagem = implode('<br>', $erros);
                Sessao::gravaMensagem($mensagem);
            }

            Email::enviarEmailConfirmacao($usuario, $hash);

            Sessao::gravaMensagem('Reenviamos o e-mail para você finalizar o seu cadastro.');

            $this->render('usuario/ativacao');

            Sessao::limpaMensagem();
            Sessao::limpaFormulario();

        }
        
    }

   
}