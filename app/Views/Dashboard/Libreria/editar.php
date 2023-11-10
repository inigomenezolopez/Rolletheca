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
                    <form action="/libreria/actualizar/<?= esc($libro->id) ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título"
                                value="<?= old('titulo', esc($libro->titulo)) ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_categoria" class="form-label">Categoría:</label>
                            <select name="id_categoria" id="id_categoria" class="form-control">
                                <option value="">Seleccione una categoría</option>
                                <?php  foreach ($categorias as $categoriaItem) : ?>
                                <option
                                    <?= $categoriaItem->id == old('id_categoria', esc($libro->id_categoria)) ? 'selected' : '' ?>
                                    value="<?= $categoriaItem->id ?>"><?= $categoriaItem->nombre ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="etiquetas">Etiquetas:</label>
                            <select name="etiquetas[]" id="etiquetas" class="form-control" multiple>
                                <?php foreach ($etiquetasDeLaCategoria as $etiquetaItem): ?>
                                <option value="<?= $etiquetaItem->id ?>"
                                    <?= in_array($etiquetaItem->id, $etiquetasAsignadasIds) ? 'selected' : '' ?>>
                                    <?= esc($etiquetaItem->nombre) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control"
                                rows="4"><?= old('descripcion', esc($libro->descripcion)) ?></textarea>
                        </div>
                        <br>
                        <div class="mb-3">

                            <!-- Muestra la imagen actual -->
                            <?php if (isset($libro->ruta_archivo) && file_exists(FCPATH . 'images/libreria/' . $libro->ruta_archivo)): ?>
                            <img src="<?= base_url('images/libreria/' . esc($libro->ruta_archivo)) ?>"
                                alt="Imagen actual del libro" class="img-thumbnail"
                                style="display: block; margin: 0 auto; height: 400px; width: auto; object-fit: cover; border-radius: 0.25rem;">
                            <?php endif; ?>
                            <br>

                            <!-- Input para cargar una nueva imagen -->
                            <input type="file" class="form-control" id="imagen" name="imagen">
                            <!-- Campo oculto para mantener la referencia de la imagen actual en caso de que no se cargue una nueva -->
                            <input type="hidden" name="ruta_archivo_actual"
                                value="<?= esc($libro->ruta_archivo ?? '') ?>">
                        </div>

                        <button type="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('id_categoria').addEventListener('change', function() {
    cargarEtiquetas(this.value);
});

function cargarEtiquetas(idCategoria) {

    const etiquetasSelect = document.getElementById('etiquetas');

    // Asegúrate de que el contenedor esté vacío antes de agregar nuevas opciones
    etiquetasSelect.innerHTML = ''; // Esto debería eliminar las opciones existentes

    if (!idCategoria) return; // Si no hay categoría seleccionada, no hacer nada

    // Proceso de obtención y añadido de nuevas opciones
    fetch('/libro/etiquetas/' + idCategoria)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            data.forEach(etiqueta => {

                const option = document.createElement('option');
                option.value = etiqueta.id;
                option.text = etiqueta.nombre;
                // Añadir la nueva opción al select de etiquetas
                etiquetasSelect.appendChild(option);

            });
        })
        .catch(error => {
            console.error('Error al cargar etiquetas:', error);
            alert('Hubo un error al cargar las etiquetas. Por favor, revisa la consola para más detalles.');
        });
}
</script>

<?= $this->endSection() ?>