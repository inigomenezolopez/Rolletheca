<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<h1 class="mb-4 text-center">Librería</h1>
<hr>

<?php if (session('usuario')->rol == 'admin'): ?>
    <div class="mb-3 text-end">
        <a href="/libreria/crear" role="button" class="btn btn-success">Agregar Nuevo Libro</a>
    </div>
<?php endif; ?>

<div class="row">

    <?php foreach ($libros as $libro): ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border border-1 shadow-sm">
                <img src="/images/libreria/<?= esc($libro->ruta_archivo) ?>" class="card-img-top" alt="Imagen del libro">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= esc($libro->titulo) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= esc($libro->categoria) ?></h6>
                    <p class="card-text"><?= esc($libro->descripcion) ?></p>
                    <p class="card-text text-muted small"><?= esc($libro->fecha_subida) ?></p>
                    <div class="mb-3">
                        <?php foreach ($libro->etiquetas as $etiqueta): ?>
                            <span class="badge bg-secondary"><?= esc($etiqueta->nombre) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="stars my-2">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?= $i <= $libro->valoracionMedia ? 'fas fa-star text-warning' : 'far fa-star'; ?>"></i>
                        <?php endfor; ?>
                        <span class="valoracion-texto ms-2">(<?= number_format($libro->valoracionMedia, 1) ?>)</span>
                    </div>
                    <div class="mt-auto">
                        <a href="/libreria/ver/<?= esc($libro->id) ?>" class="btn btn-primary btn-sm">Ver</a>
                        <?php if (session('usuario')->rol == 'admin'): ?>
                            <a href="/libreria/editar/<?= esc($libro->id) ?>" class="btn btn-secondary btn-sm">Editar</a>
                            <form action="/libreria/eliminar/<?= esc($libro->id) ?>" method="post" style="display: inline-block;">
                                <button type="submit" class="btn btn-danger btn-sm">Borrar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?= $pager->links() ?>

<?= $this->endSection() ?>
