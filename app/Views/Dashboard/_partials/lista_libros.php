<?php foreach ($libros as $libro): ?>
    <div class="col-lg-4 col-md-6 mb-4">
    <a href="/libreria/ver/<?= esc($libro->id) ?>" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm">
            <img src="/images/libreria/<?= esc($libro->ruta_archivo) ?>" class="card-img-top" alt="Imagen del libro"
                style="height: 200px; width: 100%; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= esc($libro->titulo) ?></h5>
                <p class="card-text"><?= esc($libro->descripcion) ?></p>
                <div class="mb-3">
                    <?php foreach ($libro->etiquetas as $etiqueta): ?>
                    <span class="badge bg-secondary"><?= esc($etiqueta->nombre) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="mt-auto">
                    <p class="card-text text-muted small"><?= esc($libro->fecha_subida) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="far fa-thumbs-up"></i>
                            <span><?= round($libro->valoracionMedia) ?></span>
                        </div>
                        <?php if (session('usuario')->rol == 'admin'): ?>
                        <div class="botones-accion">
                            <a href="/libreria/editar/<?= esc($libro->id) ?>" class="btn btn-primary">
                                Editar
                            </a>
                            <form action="/libreria/eliminar/<?= esc($libro->id) ?>" method="post"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
                                <button class="btn btn-danger" type="submit">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>



<?php endforeach; ?>
</a>