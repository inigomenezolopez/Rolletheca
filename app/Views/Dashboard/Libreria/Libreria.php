<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<h1 class="mb-4 text-center">Librería</h1>

<hr>

<?php if (session('usuario')->rol == 'admin'): ?>

<a href="/libreria/crear" class="addButton">

    <div class="svg-wrapper-1">
        <div class="svg-wrapper">
            <svg class="addsvgIcon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 23">
                <path
                    d="M9.546.5a9.5 9.5 0 1 0 9.5 9.5 9.51 9.51 0 0 0-9.5-9.5ZM13.788 11h-3.242v3.242a1 1 0 1 1-2 0V11H5.304a1 1 0 0 1 0-2h3.242V5.758a1 1 0 0 1 2 0V9h3.242a1 1 0 1 1 0 2Z" />
            </svg>
        </div>
    </div>

</a>
<?php endif; ?>
<br>

<div class="row">
    <?= $this->include('Dashboard/_partials/lista_libros') ?>
</div>

<?= $pager->links() ?>

<?= $this->endSection() ?>