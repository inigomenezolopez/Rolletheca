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
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4 text-center" ><?= esc($libro->titulo)  ?></h1>
            <br>
            <!-- Imagen del libro centrada con tamaño definido -->
            <div class="text-center">
                <img src="/images/libreria/<?= esc($libro->ruta_archivo)?>" class="img-fluid libro-imagen" alt="Imagen del libro" style="max-width: 100%; height: auto;">
            </div>
            <p class="mt-4 text-center"><?= esc($libro->descripcion) ?></p>
        </div>
    </div>
    <?php foreach ($libro->etiquetas as $etiqueta): ?>
                            <span class="badge bg-secondary"><?= esc($etiqueta->nombre) ?></span>
                        <?php endforeach; ?>
    

    <div class="row mt-4">
        <div class="col-12">
            <form action="/comentarios/agregar" method="post">
                <input type="hidden" name="id_libro" value="<?= $libro->id ?>">
            

                <div class="star-rating">
    <span class="star" data-value="1">&#9733;</span>
    <span class="star" data-value="2">&#9733;</span>
    <span class="star" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
    <input type="hidden" name="valoracion" id="valoracion">
</div>


                <div class="mb-3">
                    <label for="contenido" class="form-label">Comentario:</label>
                    <textarea id="contenido" name="contenido" class="form-control" required></textarea>
                </div>

                

                <button type="submit" class="btn btn-primary">Publicar comentario</button>
            </form>
        </div>
    </div>

    <section class="my-5" style="background-color: #cbdbe5;">
    <div class="container">
    <br>
        <h4 class="text-center mb-4">Comentarios Recientes</h4>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <?php foreach ($comentarios as $comentario) : ?>
                    <div class="card mb-3" id="comentario-<?= $comentario->id ?>">
                        <div class="row g-0">
                            <div class="col-md-4 text-center">
                            <img src="<?= esc($comentario->imagen ? base_url('/images/usuario/' . $comentario->imagen) : base_url('/images/usuario/img_predeterminada.png')) ?>" alt="avatar" class="img-fluid rounded-circle my-3" style="width: 140px; height: 140px;">
                                <h5><?= esc($comentario->usuario) ?></h5>
                                <div>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="<?= $i <= $comentario->valoracion ? 'fas fa-star star-filled' : 'far fa-star star-empty'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="text-muted"><?= esc($comentario->fecha_publicacion) ?></p>
                            
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    

                                      <!-- Formulario de edición oculto -->
                            <div id="formulario-edicion-<?= $comentario->id ?>" style="display: none;">
                             <textarea id="contenido-editar-<?= $comentario->id ?>" class="form-control"><?= esc($comentario->contenido) ?></textarea>
                            <button onclick="guardarEdicion(<?= $comentario->id ?>)" class="btn btn-success btn-sm">Guardar</button>
                            <button onclick="cancelarEdicion(<?= $comentario->id ?>)" class="btn btn-secondary btn-sm">Cancelar</button>
                            </div>
                                    <br>
                                   <!-- Botones de edición y eliminación que siempre se muestran -->
                            <div class="card-text" id="vista-comentario-<?= $comentario->id ?>"><?= esc($comentario->contenido) ?></p>
                             <button onclick="mostrarFormularioEdicion(<?= $comentario->id ?>)" class="btn btn-primary btn-sm">Editar</button>
                            <button onclick="eliminarComentario(<?= $comentario->id ?>)" class="btn btn-danger btn-sm">Borrar</button>
                                </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
</div>
<script>
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

// Función para mostrar el formulario de edición
function mostrarFormularioEdicion(idComentario) {
    document.getElementById('vista-comentario-' + idComentario).style.display = 'none';
    document.getElementById('formulario-edicion-' + idComentario).style.display = 'block';
}

// Función para cancelar la edición de un comentario
function cancelarEdicion(idComentario) {
    document.getElementById('vista-comentario-' + idComentario).style.display = 'block';
    document.getElementById('formulario-edicion-' + idComentario).style.display = 'none';
}

// Función para guardar la edición de un comentario
function guardarEdicion(idComentario) {
    var contenidoEditado = document.getElementById('contenido-editar-' + idComentario).value;
    
    // Aquí haces el fetch al servidor
    fetch('/comentarios/actualizar/' + idComentario, {
        method: 'POST', // Puede ser POST o PUT, dependiendo de tu backend
        headers: {
            'Content-Type': 'application/json',
            // Incluye más headers si son necesarios (como tokens de autenticación)
        },
        body: JSON.stringify({
            id: idComentario,
            contenido: contenidoEditado
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Aquí actualizas el DOM con el comentario editado
        document.getElementById('vista-comentario-' + idComentario).querySelector('.card-text').textContent = contenidoEditado;
        cancelarEdicion(idComentario); // Esto ocultará el formulario de edición
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation:', error);
    });
}
</script>
<?= $this->endSection() ?>
