<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Título principal -->
            <h2 class="text-center mb-5 display-4" style="color: #1b2530;">📘 Acerca de WebDoc</h2>

            <!-- Tarjeta principal -->
            <div class="card shadow mb-5" style="border-color: #cbdbe5;">
                <div class="card-body" style="color: #1b2530;">
                    <p class="lead">🔍 WebDoc es tu plataforma de confianza para compartir y descubrir contenido.</p>
                    <p>🌐 Busca libros, juegos, imágenes inspiradoras y más. 🎉</p>
                    <p>🚀 Una comunidad comprometida con el aprendizaje, la creatividad y el intercambio. 🎨</p>
                    <p>❤️ Celebramos la diversidad de contenidos y te damos la bienvenida a nuestro espacio. 🌏</p>
                    <p>🙏 ¡Gracias por ser parte de WebDoc!</p>
                </div>
            </div>

            <!-- Tarjeta de Políticas y Privacidad -->
            <div class="card shadow mb-4" style="border-color: #cbdbe5;">
                <div class="card-header" style="background-color: #cbdbe5; color: #1b2530;">
                    <h3 class="mb-0">🔒 Políticas de Privacidad</h3>
                </div>
                <div class="card-body" style="color: #1b2530;">
                    <p>Valoramos y respetamos tu privacidad. Te invitamos a leer nuestra <a href="<?= route_to('acercade.politica')?>" class="text-primary font-weight-bold" style="color: #1b2530;">política de privacidad completa</a> y conocer cómo protegemos tus datos. 🛡️</p>
                </div>
            </div>

            <!-- Tarjeta de Términos y Condiciones -->
            <div class="card shadow" style="border-color: #cbdbe5;">
                <div class="card-header" style="background-color: #cbdbe5; color: #1b2530;">
                    <h3 class="mb-0">📜 Términos y Condiciones</h3>
                </div>
                <div class="card-body" style="color: #1b2530;">
                    <p>Al utilizar WebDoc, aceptas nuestros <a href="<?= route_to('acercade.terminos')?>" class="text-primary font-weight-bold" style="color: #1b2530;">términos y condiciones</a>. Conoce tus derechos y responsabilidades como usuario. 🤝</p>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>