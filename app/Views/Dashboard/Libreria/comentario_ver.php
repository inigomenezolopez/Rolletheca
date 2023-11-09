<!-- libreria/comentario_ver.php -->
<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>
<style>
.star-rating {
    font-size: 30px;
    unicode-bidi: bidi-override;
    display: flex;
    justify-content: flex-end; /* Asegura que las estrellas comienzan desde la derecha */
}

.star-rating .star {
    display: inline-block;
    cursor: pointer;
    color: #ccc; /* Color predeterminado de las estrellas */
    transition: color 0.2s ease-in-out; /* Agrega una transición suave al cambiar el color */
}

.star-rating 
.star-rating .star:hover ~ .star {
    color: #fc0; /* Color al pasar el ratón y seleccionar */
}
.star-filled {
    color: #fc0;
}
.star-empty {
    color: lightgray;
}
</style>

<h1>Editar Comentario</h1>



<form action="<?= site_url('/libreria/actualizar/comentario/' . $comentario->id) ?>" method="post">
    <?= csrf_field() ?>
<div class="star-rating">
    <span class="star" data-value="1">&#9733;</span>
    <span class="star" data-value="2">&#9733;</span>
    <span class="star" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
    <input type="hidden" name="valoracion" id="valoracion" value= "<?= esc($comentario->valoracion)?>">
</div>
    <div class="form-group">
        <label for="contenido">Contenido</label>
        <textarea name="contenido" id="contenido" class="form-control" ><?= esc($comentario->contenido) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
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

document.addEventListener('DOMContentLoaded', function () {
    var stars = document.querySelectorAll('.star');
    stars.forEach(function(star, index){
        star.addEventListener('click', function() {
            setRating(index + 1); // Pasamos el índice + 1 para representar el número de estrellas
        });
    });

    function setRating(ratingValue){
        var stars = document.querySelectorAll('.star');
        document.getElementById('valoracion').value = ratingValue; // Establecemos el valor antes de cambiar colores para mantener la lógica correcta
        stars.forEach(function(star, index){
            if(index < ratingValue){
                star.style.color = '#fc0'; // Estrellas seleccionadas
            } else {
                star.style.color = '#ccc'; // Estrellas no seleccionadas
            }
        });
    }
});


</script>
<?= $this->endSection() ?>
