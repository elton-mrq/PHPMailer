<div class="container">
    <div class="row">
        <div class="col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
            <?php if($Sessao::retornaMensagem()) { ?>
                <div class="alert alert-warning" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $Sessao::retornaMensagem(); ?>
                </div>
            <?php } ?>

            <form id="form_cadastro" action="<?php echo APP_HOST; ?>usuario/cadastrar" method="post">
                <fieldset>
                    <legend>Cadastro de usuário</legend>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" name="email"
                                value="<?php echo $Sessao::retornaValorFormulario('email'); ?>" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="login">Login:</label>
                        <input type="text" class="form-control" name="login"
                                value="<?php echo $Sessao::retornaValorFormulario('login'); ?>" maxlength="20">
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control" name="senha"
                                value="<?php echo $Sessao::retornaValorFormulario('senha'); ?>" maxlength="50">
                    </div>

                    <div class="form-group align-right">
                        <button class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span></button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>