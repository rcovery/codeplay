<div>
    <?= $this->Form->create(); ?>
        <label for="name_input">Nome Completo</label>
        <input id="name_input" name='name' required/>
        <label for="username_input">Nome do usuário</label>
        <input id="username_input" name='username' required/>
        <label for="email_input">Email</label>
        <input id="email_input" name='email' type="email" required/>
        <label for="password_input">Senha</label>
        <input id="password_input" name='password' type="password" required/>

        <label for="consent_input">Aceito os termos de uso</label>
        <input id="consent_input" name='consent' type="checkbox" required/>
        
        <input type="submit" value="Criar sua conta!"/>
    <?= $this->Form->end(); ?>
</div>