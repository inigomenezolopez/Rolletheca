<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>


<link rel="stylesheet" href="<?= base_url('cropper/cropper.min.css') ?>">
<script src="<?= base_url('cropper/cropper.min.js') ?>"></script>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">Mi Perfil</h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4" >
            <div class="card" style="background-color: #cbdbe5;">
            <img src="<?= esc($usuario->imagen ? base_url('/images/usuario/' . $usuario->imagen) : base_url('/images/usuario/img_predeterminada.png')) ?>" class="card-img-top rounded-circle" alt="<?= esc($usuario->usuario) ?>" style="width: 130px; height: 130px; object-fit: cover; border-radius: 50%; margin: 0 auto;">

                <div class="card-body">
                    <h2 class="card-title" style="text-align: center"><?= esc($usuario->usuario) ?></h2>
                    <p class="card-text" style="text-align: center"><?= esc($usuario->correo) ?></p>
                    
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form action="/usuario/actualizar-perfil" method="post" enctype="multipart/form-data">
               
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?= esc($usuario->usuario) ?>">
                </div>
                
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?= esc($usuario->correo) ?>">
                </div>

                <div >
    <label for="imagen" class="form-label">Actualizar Imagen</label>
    
    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" value="<?=$usuario->imagen?>">
    <br>
    
    
        <img id="imagenRecorte" src="<?= esc($usuario->imagen ? base_url('/images/usuario/' . $usuario->imagen) : base_url('/images/usuario/img_predeterminada.png')) ?>" alt="Vista previa" style="display: none; max-width: 100%; max-height: 100%;">
        <br>
        
    <input type="hidden" id="x" name="x">
    <input type="hidden" id="y" name="y">
    <input type="hidden" id="width" name="width">
    <input type="hidden" id="height" name="height">
</div>

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var imagen = document.getElementById('imagen'); // Input del archivo
    var vistaPrevia = document.getElementById('vistaPrevia'); // Contenedor de la vista previa
    var imagenRecorte = document.getElementById('imagenRecorte'); // Imagen de vista previa
    var cropper;

    imagen.addEventListener('change', function (event) {
        var archivos = event.target.files;
        if (archivos && archivos.length > 0) {
            var archivo = archivos[0];
            if (/^image\/\w+/.test(archivo.type)) {
                var reader = new FileReader();
                reader.onload = function () {
                    imagenRecorte.src = reader.result;
                    if (cropper) {
                        cropper.destroy(); // Destruye la instancia anterior de Cropper
                    }
                    cropper = new Cropper(imagenRecorte, {
                        aspectRatio: 1,
                        viewMode: 1,
                        crop: function (event) {
                            // Actualiza los valores de los campos de recorte
                            document.getElementById('x').value = event.detail.x;
                            document.getElementById('y').value = event.detail.y;
                            document.getElementById('width').value = event.detail.width;
                            document.getElementById('height').value = event.detail.height;
                        }
                    });
                    imagenRecorte.style.display = 'block'; // Muestra la vista previa
                };
                reader.readAsDataURL(archivo);
            } else {
                window.alert('Por favor, selecciona un archivo de imagen.');
            }
        }
    });

    // Opción de confirmación de recorte (asegúrese de que este botón exista en su HTML)
    var botonConfirmar = document.getElementById('confirmarRecorte'); // Reemplazar con el ID real de tu botón
    if (botonConfirmar) {
        botonConfirmar.addEventListener('click', function() {
            // Enviar datos de recorte al servidor y manejar la respuesta aquí...

            // Oculta la vista previa independientemente del resultado del recorte
            imagenRecorte.style.display = 'none';
        });
    }
});
</script>
<?= $this->endSection() ?>





