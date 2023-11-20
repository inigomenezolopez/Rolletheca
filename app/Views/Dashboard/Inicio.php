<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>


<div class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">¡Bienvenido a WebDoc!</h1>
        <p class="lead">El lugar perfecto para descargar y compartir juegos, libros, imágenes y mucho más.</p>
        <hr class="my-4">
        <p>Explora la vasta colección de archivos compartidos por la comunidad o comparte tus propios archivos con el
            mundo.</p>
        <a href="<?= route_to('libreria.index')?>">
            <button class="login-Button">
                <span>Explorar Librería</span>
                <svg width=" 34" height="34" viewBox="0 0 74 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="37" cy="37" r="35.5" stroke="white" stroke-width="5"></circle>
                    <path
                        d="M25 35.5C24.1716 35.5 23.5 36.1716 23.5 37C23.5 37.8284 24.1716 38.5 25 38.5V35.5ZM49.0607 38.0607C49.6464 37.4749 49.6464 36.5251 49.0607 35.9393L39.5147 26.3934C38.9289 25.8076 37.9792 25.8076 37.3934 26.3934C36.8076 26.9792 36.8076 27.9289 37.3934 28.5147L45.8787 37L37.3934 45.4853C36.8076 46.0711 36.8076 47.0208 37.3934 47.6066C37.9792 48.1924 38.9289 48.1924 39.5147 47.6066L49.0607 38.0607ZM25 38.5L48 38.5V35.5L25 35.5V38.5Z"
                        fill="white"></path>
                </svg>
            </button></a>
    </div>
    <br>


    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($categorias as $categoria) : ?>
        <div class="col">
            <a href="/categoria/ver/<?= $categoria->id ?>" style="text-decoration:none; color:inherit;">
                <div class="card h-100">
                    <img src="/images/categoria/<?= $categoria->imagen ?>" class="card-img-top"
                        alt="<?= $categoria->nombre ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $categoria->nombre ?></h5>
                        <p class="card-text"><?= $categoria->descripcion ?></p>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach ?>
    </div>
</div>

</div>
</div>

<?= $this->endSection() ?>