<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" style="border-color: #cbdbe5;">
                <div class="card-header" style="background-color: #cbdbe5; color: #1b2530;">
                    <h3 class="mb-0">Editar Categoría</h3>
                </div>
                <div class="card-body" style="color: #1b2530;">
                    <form action="/categoria/actualizar/<?= esc($categorias->id)?>" method="post"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Categoría:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                placeholder="Nombre de Categoria"
                                value="<?= old('nombre', esc($categorias->nombre)) ?>">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control"
                                rows="4"><?= old('descripcion', esc($categorias->descripcion)) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>