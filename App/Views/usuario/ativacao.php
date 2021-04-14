<div class="container">
    <div class="jumbotron">
        <h1>Ativação de cadastro</h1>
        <p><?php echo $Sessao::retornaMensagem(); ?></p>

        <?php if($Sessao::existeFormulario()) { ?>
            <form action="/usuario/reenviar" method="post">
                <input type="hidden" name="email" value="<?php $Sessao::retornaValorFormulario('email'); ?>">
                <button class="btn btn-default">Enviar novamente</button>
            </form>
        <?php } else{ ?>
            <p>
                <a class="btn btn-lg btn-primary" href="<?php echo APP_HOST; ?>" role="button">Voltar</a>
            </p>
        <?php } ?>

    </div>
</div>