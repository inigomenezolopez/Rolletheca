<!-- libreria/comentario_ver.php -->
<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<h1>Editar Comentario</h1>



<form action="<?= site_url('/libreria/actualizar/comentario/' . $comentario->id) ?>" method="post">
    <?= csrf_field() ?>
    <div class="star-rating">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
        <input type="hidden" name="valoracion" id="valoracion" value="<?= esc($comentario->valoracion)?>">
    </div>
    <div class="form-group">
        <label for="contenido">Comentario: </label>
        <textarea name="contenido" id="contenido" class="form-control"><?= esc($comentario->contenido) ?></textarea>
    </div>
    <br>
    <div class="botones-accion">
        <button class="send-Button">
            <div class="svg-wrapper-1">
                <div class="svg-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="23" height="23">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor"
                            d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
                        </path>
                    </svg>
                </div>
            </div>
            <span>Send</span>
        </button>
    </div>
    <a href="<?= base_url('/libreria/ver/' . $comentario->id_libro) ?>" class="btn btn-secondary">Cancelar</a>
</form>



<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Obtén el valor de la valoración del input oculto
    const valoracion = document.getElementById('valoracion').value;

    // Selecciona todas las estrellas
    const stars = document.querySelectorAll('.star');

    // Llena las estrellas hasta la valoración
    stars.forEach((star, index) => {
        if (index < valoracion) {

            star.classList.add('star-filled');
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var stars = document.querySelectorAll('.star');
    stars.forEach(function(star, index) {
        star.addEventListener('click', function() {
            setRating(index +
                1); // Pasamos el índice + 1 para representar el número de estrellas
        });
    });

    function setRating(ratingValue) {
        var stars = document.querySelectorAll('.star');
        document.getElementById('valoracion').value =
            ratingValue; // Establecemos el valor antes de cambiar colores para mantener la lógica correcta
        stars.forEach(function(star, index) {
            if (index < ratingValue) {
                star.style.color = '#fc0'; // Estrellas seleccionadas
            } else {
                star.style.color = '#ccc'; // Estrellas no seleccionadas
            }
        });
    }
});
</script>
<?= $this->endSection() ?>