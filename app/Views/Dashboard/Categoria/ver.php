<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>


<div class="text-center mb-4">
    <h1><?= esc($categoria->nombre) ?></h1>
    <p><i><?= esc($categoria->descripcion) ?></i></p>
</div>

<!-- Botón para mostrar/ocultar el filtro de etiquetas -->
<button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filtroEtiquetas"
    aria-expanded="false" aria-controls="filtroEtiquetas">
    Filtrar por etiquetas
</button>

<!-- Contenedor desplegable para las opciones de filtrado -->
<div class="collapse" id="filtroEtiquetas">
    <form action="<?= site_url('categoria/ver/' . $categoria->id) ?>" method="get">
        <div class="mb-3">
            <?php foreach($todasLasEtiquetas as $etiqueta): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="etiquetas[]" value="<?= esc($etiqueta->id) ?>"
                    id="etiqueta<?= $etiqueta->id ?>">
                <label class="form-check-label" for="etiqueta<?= $etiqueta->id ?>"><?= esc($etiqueta->nombre) ?></label>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Aplicar Filtro</button>
    </form>
</div>

<hr>

<div class="row">
    <?php foreach ($libros as $libro): ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border border-1 shadow-sm">
            <img src="/images/libreria/<?= esc($libro->ruta_archivo) ?>" class="card-img-top" alt="Imagen del libro"
                style="height: 200px; width: 100%; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= esc($libro->titulo) ?></h5>
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
                    <form action="/libreria/eliminar/<?= esc($libro->id) ?>" method="post"
                        style="display: inline-block;">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
                            Borrar
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>


<?= $pager->links() ?>

</div>

<?= $this->endSection() ?>