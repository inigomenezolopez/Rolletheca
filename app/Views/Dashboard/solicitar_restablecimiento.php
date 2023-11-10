<?= $this->extend('/Dashboard/Layout/header') ?>


<?= $this->section('content') ?>
<div class="container">
    <h2>Solicitud de restablecimiento de contraseña</h2>
    <p>Introduce tu correo electrónico para recibir las instrucciones para restablecer tu contraseña.</p>



    <form action="<?= base_url('recuperar-contrasena') ?>" method="post">
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Enviar solicitud</button>
    </form>
</div>
<?= $this->endSection() ?>