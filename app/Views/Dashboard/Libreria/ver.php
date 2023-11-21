<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">

        <div class="col-12">

            <h1 class="display-4 text-center"><?= esc($libro->titulo)  ?></h1>
            <div class="mt-auto">
                <br>
                <?php if (session('usuario')->rol == 'admin') : ?>
                    <div class="botones-accion">
                        <a href="/libreria/editar/<?= esc($libro->id) ?>" id="botonEditar" class="button" style="text-decoration: none;">
                            <button class="edit-button">
                                <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                    <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                    </path>
                                </svg>
                            </button>
                        </a>

                        <form action="/libreria/eliminar/<?= esc($libro->id) ?>" method="post" style="display: inline-block;" onclick="return confirm('¿Estás seguro de que deseas eliminar este libro?');">
                            <button class="delete-button" type="submit">
                                <svg class="delete-svgIcon" viewBox="0 0 448 512">
                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <br>
            <hr>
            <div class="text-center">
                <img src="/images/libreria/<?= esc($libro->ruta_archivo) ?>" class="img-fluid libro-imagen" alt="Imagen del libro" style="height: auto; max-height: 700px; width: 100%; object-fit: cover;">
            </div>
            <hr>
            <p class="mt-4 text-center"><?= esc($libro->descripcion) ?></p>
        </div>
    </div>
    <?php foreach ($libro->etiquetas as $etiqueta) : ?>
        <span class="badge bg-secondary"><?= esc($etiqueta->nombre) ?></span>
    <?php endforeach; ?>


    <div class="row mt-4">
        <div class="col-12">
            <form action="/comentarios/agregar" method="post" data-libro-id="<?= $libro->id ?>">
                <input type="hidden" name="id_libro" value="<?= $libro->id ?>">

                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-outline-primary" id="likeButton">
                        <i class="far fa-thumbs-up" id="likeIcon"></i> Like
                    </button>
                    <input type="hidden" name="valoracion" id="valoracion">
                </div>

                <div class="mb-3">
                    <label for="contenido" class="form-label">Comentario:</label>
                    <textarea id="contenido" name="contenido" class="form-control" value="<?= old('contenido') ?>" required></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        Enviar
                    </button>
                </div>
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
                                        <i class="<?= $comentario->valoracion > 0 ? 'fas fa-thumbs-up text-primary' : 'far fa-thumbs-up text-secondary'; ?>"></i>
                                    </div>

                                    <p class="text-muted"><?= esc($comentario->fecha_publicacion) ?></p>

                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="card-text" id="vista-comentario-<?= $comentario->id ?>">
                                            <?= esc($comentario->contenido) ?></p>


                                            <?php $usuarioSesion = session()->get('usuario'); ?>
                                            <?php if ($usuarioSesion->id == $comentario->id_usuario || $usuarioSesion->rol == 'admin') : ?>
                                                <div class="botones-accion">
                                                    <a href="<?= site_url('/libreria/editar/comentario/' . $comentario->id) ?>" id="botonEditar" class="button" style="text-decoration: none;">
                                                        <button class="edit-button">
                                                            <svg class="edit-svgIcon" viewBox="0 0 512 512">
                                                                <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </a>

                                                    <form action="<?= site_url('comentario/borrar/' . $comentario->id) ?>" method="post" style="display: inline-block;" onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                                                        <button class="delete-button" type="submit">
                                                            <svg class="delete-svgIcon" viewBox="0 0 448 512">
                                                                <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>

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
    document.getElementById('likeButton').addEventListener('click', function() {
        this.classList.toggle('btn-primary');
        this.classList.toggle('text-white'); // Añade esta línea
        document.getElementById('likeIcon').classList.toggle('text-white');
        document.getElementById('valoracion').value = this.classList.contains('btn-primary') ? 1 : 0;
    });


    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa Tribute.js en el elemento donde se escribirán los comentarios.
        var tribute = new Tribute({
            // Define el punto final de la API y el parámetro de búsqueda
            values: function(text, cb) {
                // Obtiene el ID del libro del atributo del formulario
                var libroId = document.querySelector('form[data-libro-id]').getAttribute(
                    'data-libro-id');
                // Utiliza fetch para buscar comentarios que coincidan con el texto ingresado
                fetch(`/buscar-comentario?q=${text}&id_libro=${libroId}`)
                    .then(function(response) {
                        return response.json();
                    }) // Convierte la respuesta en JSON
                    .then(function(data) {
                        // Mapea los resultados para el formato que Tribute espera
                        var comentarios = data.map(function(comentario) {
                            return {
                                key: comentario
                                    .contenido, // Usa el contenido del comentario como llave
                                value: comentario
                                    .id_usuario, // Esto es lo que se muestra en la lista de sugerencias
                                search: comentario
                                    .contenido, // El término de búsqueda que Tribute usa para filtrar
                            };
                        });
                        cb(comentarios); // Devuelve los comentarios procesados ​​a Tribute
                    }).catch(function(e) {
                        console.error('Error al buscar comentarios:', e);
                        cb([]); // Devuelve un arreglo vacío en caso de error
                    });
            },
            // Indica a Tribute cómo debe insertar la mención en el contenido
            selectTemplate: function(item) {
                if (typeof item === 'string') return item;
                // Retorna el markdown para el enlace al comentario específico
                return `@[${item.original.value}](#comentario-${item.original.key})`;
            },
            menuItemTemplate: function(item) {
                // Personaliza cómo se muestra cada ítem en el menú desplegable
                return item.string;
            },
            noMatchTemplate: function() {
                // Mensaje mostrado cuando no hay coincidencias
                return '<li style="pointer-events: none;"><span>No se encontraron coincidencias</span></li>';
            },
            // Otras opciones...
        });

        // Atacha Tribute al área de texto del comentario
        tribute.attach(document.getElementById('contenido'));
    });


    // JavaScript para manejar el clic en el enlace de la mención y navegar al comentario
    document.addEventListener('click', function(event) {
        if (event.target.tagName === 'A' && event.target.href.includes('#comentario-')) {
            event.preventDefault();
            var comentarioId = event.target.href.split('#comentario-')[1];
            console.log('Desplazamiento al comentario ID:', comentarioId); // Para depuración
            var comentarioElement = document.getElementById(`comentario-${comentarioId}`);
            if (comentarioElement) {
                comentarioElement.scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                console.log('El elemento del comentario no fue encontrado.'); // Para depuración
            }
        }
    });
</script>
<?= $this->endSection() ?>