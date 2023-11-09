
<?= $this->extend('/Dashboard/Layout/header') ?>


<?= $this->section('content') ?>
<div class="container">
    <h2>Restablecer contraseña</h2>
    <form action="<?= base_url('restablecer-contrasena-proceso') ?>" method="post">
        <div class="form-group">
            <label for="nueva_contrasena">Nueva contraseña</label>
            <input type="password" name="nueva_contrasena" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirmar_contrasena">Confirmar nueva contraseña</label>
            <input type="password" name="confirmar_contrasena" class="form-control" required>
        </div>
        <input type="hidden" name="token" value="<?= esc($token) ?>">
        <button type="submit" class="btn btn-primary mt-2">Restablecer contraseña</button>
    </form>
</div>
<?= $this->endSection() ?>