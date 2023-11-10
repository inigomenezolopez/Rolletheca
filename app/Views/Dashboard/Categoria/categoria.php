<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<h1 class="mb-4 text-center">Listado de Categorias</h1>
<hr>

<?php if (session('usuario')->rol == 'admin'): ?>
<div class="mb-3">
    <a href="/categoria/crear" role="button" class="btn btn-success">Crear</a>
</div>
<?php endif; ?>

<div class="d-block d-md-none">
    <!-- Visualización para dispositivos móviles -->
    <?php foreach ($categorias as $categoria): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?= esc($categoria->nombre) ?></h5>
            <p class="card-text"><?= esc($categoria->descripcion) ?></p>
            <!-- Botones de acción -->
            <a href="/categoria/ver/<?= esc($categoria->id) ?>" class="btn btn-primary btn-sm">Ver</a>
            <?php if (session('usuario')->rol == 'admin'): ?>
            <a href="/categoria/editar/<?= esc($categoria->id) ?>" class="btn btn-primary btn-sm">Editar</a>
            <form action="/categoria/eliminar/<?= esc($categoria->id) ?>" method="post" style="display: inline-block;">
                <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="d-none d-md-block table-responsive">
    <table class="table table-sm">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Descripción</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?= esc($categoria->nombre) ?></td>
                <td><?= esc($categoria->descripcion) ?></td>
                <td>
                    <a class="btn btn-primary btn-sm" role="button"
                        href="/categoria/ver/<?= esc($categoria->id) ?>">Ver</a>
                    <?php if (session('usuario')->rol == 'admin'): ?>
                    <a href="/categoria/editar/<?= esc($categoria->id) ?>" class="btn btn-primary btn-sm"
                        role="button">Editar</a>
                    <form action="/categoria/eliminar/<?= esc($categoria->id) ?>" method="post"
                        style="display: inline-block;">
                        <button class="btn btn-danger btn-sm" type="submit"
                            onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?');">Borrar</button>
                    </form>

                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>