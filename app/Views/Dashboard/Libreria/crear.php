<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow" style="border-color: #cbdbe5;">
                <div class="card-header" style="background-color: #cbdbe5; color: #1b2530;">
                    <h3 class="mb-0">Crear Librería</h3>
                </div>
                <div class="card-body" style="color: #1b2530;">
                    <form action="/libreria/guardar" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Título"
                                value="<?= old('titulo') ?>">
                        </div>
                        <div class="form-group">
                            <label for="id_categoria">Categoría:</label>
                            <select name="id_categoria" id="id_categoria" class="form-control"
                                onchange="cargarEtiquetas(this.value)">
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categoria as $categoriaItem) : ?>
                                <option value="<?= $categoriaItem->id ?>"><?= $categoriaItem->nombre ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="etiquetas">Etiquetas:</label>
                            <select name="etiquetas[]" id="etiquetas" class="form-control" multiple>
                                <?php foreach ($etiqueta as $etiquetaItem) : ?>
                                <option value="<?= $etiquetaItem->id ?>"><?= $etiquetaItem->nombre ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control"
                                rows="4"><?= old('descripcion') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
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