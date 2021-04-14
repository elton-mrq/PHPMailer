<?php

namespace App\Lib;

class Email
{
    public static function enviarEmailConfirmacao($usuario, $hash)
    {
        self::enviar(
            $usuario->getEmail(),
            $usuario->getLogin(),
            'Confirmação de email',
            "<p>Clique<a href='" . APP_HOST . "usuario/ativacao/{$hash->getHash()}'> aqui </a>.</p>",
            "usuario/cadastrar/{$hash->getHash()} para ativar o seu cadastro."
        );
    }

    public static function enviar($para, $nome, $titulo, $html, $txt)
    {
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'eltonmrq@gmail.com';
        $mail->Password = '@moretud0';
        $mail->setFrom('eltonmrq@gmail.com', 'Elton Marques');
        $mail->addReplyTo('eltonmrq@gmail.com', 'Elton Marques');
        $mail->addAddress($para, $nome);
        $mail->Subject = $titulo;
        $mail->CharSet = 'UTF-8';
        $mail->msgHTML($html);
        $mail->AltBody = $txt;
        
        if(!$mail->send()){
            throw new \Exception("Erro no envio do e-mail {$mail->ErrorInfo}");
        }
    }
}