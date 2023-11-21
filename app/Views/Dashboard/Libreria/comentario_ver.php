<!-- libreria/comentario_ver.php -->
<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<h1>Editar Comentario</h1>

<form action="<?= site_url('/libreria/actualizar/comentario/' . $comentario->id) ?>" method="post">
    <?= csrf_field() ?>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-outline-primary" id="likeButton">
            <i class="far fa-thumbs-up" id="likeIcon"></i> Like
        </button>
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
document.getElementById('likeButton').addEventListener('click', function() {
    this.classList.toggle('btn-primary');
    this.classList.toggle('text-white');
    document.getElementById('valoracion').value = this.classList.contains('btn-primary') ? 1 : 0;
});

// Añade este código para reflejar el estado actual del "like" del usuario
window.addEventListener('DOMContentLoaded', (event) => {
    var likeButton = document.getElementById('likeButton');
    var valoracion = document.getElementById('valoracion').value;
    if (valoracion > 0) {
        likeButton.classList.add('btn-primary');
        likeButton.classList.add('text-white');
    }
});
</script>
<?= $this->endSection() ?>
