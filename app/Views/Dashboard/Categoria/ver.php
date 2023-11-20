<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>


<div class="text-center mb-4">
    <h1><?= esc($categoria->nombre) ?></h1>
    <p><i><?= esc($categoria->descripcion) ?></i></p>
</div>

<!-- Botón para mostrar/ocultar el filtro de etiquetas -->

<button title="filter" class="filter" data-bs-toggle="collapse" data-bs-target="#filtroEtiquetas" aria-expanded="false"
    aria-controls="filtroEtiquetas">
    <svg viewBox="0 0 512 512" height="1em">
        <path
            d="M0 416c0 17.7 14.3 32 32 32l54.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 448c17.7 0 32-14.3 32-32s-14.3-32-32-32l-246.7 0c-12.3-28.3-40.5-48-73.3-48s-61 19.7-73.3 48L32 384c-17.7 0-32 14.3-32 32zm128 0a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM320 256a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm32-80c-32.8 0-61 19.7-73.3 48L32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l246.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48l54.7 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-54.7 0c-12.3-28.3-40.5-48-73.3-48zM192 128a32 32 0 1 1 0-64 32 32 0 1 1 0 64zm73.3-64C253 35.7 224.8 16 192 16s-61 19.7-73.3 48L32 64C14.3 64 0 78.3 0 96s14.3 32 32 32l86.7 0c12.3 28.3 40.5 48 73.3 48s61-19.7 73.3-48L480 128c17.7 0 32-14.3 32-32s-14.3-32-32-32L265.3 64z">
        </path>
    </svg>
</button>
<br>
<!-- Contenedor desplegable para las opciones de filtrado -->
<div class="collapse" id="filtroEtiquetas">
    <form id="filtroEtiquetasForm" action="<?= site_url('categoria/ver/' . $categoria->id) ?>" method="get">
        <div class="mb-3">
            <?php foreach($todasLasEtiquetas as $etiqueta): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkboxFiltro" type="checkbox" name="etiquetas[]"
                    value="<?= esc($etiqueta->id) ?>" id="etiqueta<?= $etiqueta->id ?>">
                <span class="checkboxLabel inactivo"
                    data-checkbox-id="etiqueta<?= $etiqueta->id ?>"><?= esc($etiqueta->nombre) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </form>
</div>


<hr>

<div class="row" id="contenedorLibros">
    <?= $this->include('Dashboard/_partials/lista_libros') ?>
</div>


<?= $pager->links() ?>

</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('.form-check-input');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var formData = new FormData(document.getElementById('filtroEtiquetasForm'));

            fetch('/categoria/filtrar/<?= esc($categoria->id) ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Actualizar la parte de tu página con los nuevos resultados
                    document.getElementById('contenedorLibros').innerHTML = data;

                })
                .catch(error => console.error('Error:', error));
        });
    });
});
</script>
<?= $this->endSection() ?>