<?= $this->extend('/Dashboard/Layout/header') ?>
<?php session()->set('ocultarCard', true);?>
<?= $this->section('content') ?>
<style>

</style>



<div class="container-fluid principal">
    <div class="row main-content bg-success text-center">
        <div class="col-md-4 text-center company__info">
            <span class="company__logo"><img src="/images/logo.jpeg" style="width: 150px;
	height: 150px;" alt=""></span>

        </div>
        <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
            <div class="container-fluid">
                <div class="row">
                    <h3><br>Registrarse</h3>
                </div>
                <div class="row">
                    <form action="<?= route_to('usuario.register_post')?>" method="post" control="" class="form-group">
                        <div class="row">
                            <input type="text" name="correo" id="correo" class="form__input" placeholder="Correo">
                        </div>
                        <div class="row">
                            <input type="text" name="usuario" id="usuario" class="form__input" placeholder="Usuario">
                        </div>

                        <div class="row">
                            <input type="password" name="contrasena" id="contrasena" class="form__input" placeholder="Contraseña">
                            <small id="passwordHelp" class="form-text text-muted">La contraseña debe tener al menos 8 caracteres.</small>
                        </div>
                        <br>
                        <div class="button-container">
                            <button class="login-Button">
                                <span>Registrarse</span>
                                <svg width=" 34" height="34" viewBox="0 0 74 74" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="37" cy="37" r="35.5" stroke="white" stroke-width="5"></circle>
                                    <path
                                        d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z"
                                        fill="white"></path>
                                </svg>
                            </button>
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                <p>¿Ya tienes cuenta? <a href="<?= route_to('usuario.login')?>">Inicia sesión</a></p>
            </div>
        </div>
    </div>
</div>
</div>

<script>
document.getElementById('contrasena').addEventListener('input', function() {
    var password = this.value;
    var passwordHelp = document.getElementById('passwordHelp');
    if (password.length >= 8) { 
        passwordHelp.style.display = 'none';
    } else {
        passwordHelp.style.display = 'block';
    }
});
</script>

<?= $this->endSection() ?>