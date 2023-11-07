<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" style="border-color: #cbdbe5;">
                <div class="card-header" style="background-color: #cbdbe5; color: #1b2530;">
                    <h3 class="mb-0">Editar Libro</h3>
                </div>
                <div class="card-body" style="color: #1b2530;">
                    <form action="/libreria/actualizar/<?= esc($libros->id) ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título" value="<?= old('titulo', esc($libros->titulo)) ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_categoria" class="form-label">Categoría:</label>
                            <select name="id_categoria" id="id_categoria" class="form-control">
                                <option value="">Seleccione una categoría</option>
                                <?php  foreach ($categoria as $categoriaItem) : ?>
                                    <option <?= $categoriaItem->id == old('id_categoria', esc($libros->id_categoria)) ? 'selected' : '' ?> value="<?= $categoriaItem->id ?>"><?= $categoriaItem->nombre ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="4"><?= old('descripcion', esc($libros->descripcion)) ?></textarea>
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
