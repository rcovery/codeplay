<div>
    Faça o login!
    <?= $this->Form->create(); ?>
        <label for="username_input">Nome do usuário</label>
        <input id="username_input" name='username' required/>
        <label for="password_input">Senha</label>
        <input id="password_input" name='password' type="password" required/>

        <a href="<?= $this->Url->build('/create') ?>">Ainda não tem uma conta? Crie uma!</a>
        <br />
        <input type="submit" value="Fazer login!"/>
    <?= $this->Form->end(); ?>
</div>