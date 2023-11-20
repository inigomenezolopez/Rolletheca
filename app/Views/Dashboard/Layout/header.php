<?php $categorias = session()->get('categorias'); ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebDoc</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('/bootstrap/css/styles.css')?>" <script
        src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tributejs/5.1.3/tribute.min.js"></script>

    <style>

    </style>
</head>

<header>


    <nav class="navbar navbar-expand-lg" id="miNavbar" style="background-color: #cbdbe5;">
        <div class="container-fluid">
            <a href="<?= route_to('inicio.index')?>">
                <img src="/images/logo.jpeg" alt="Logo" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?=route_to('libreria.index')?>">Libreria</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categorías
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php if (session()->has('usuario') && session('usuario')->rol == 'admin'): ?>
                            <a class="dropdown-item" href="/categoria">Categoria</a>
                            <?php endif; ?>
                            <?php if(is_array($categorias) && !empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                            <a class="dropdown-item"
                                href="/categoria/ver/<?= $categoria->id ?>"><?= $categoria->nombre ?></a>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <span class="dropdown-item">No hay categorías disponibles</span>
                            <?php endif; ?>
                        </div>
                    </li>



                    </li>
                    <li class="nav-item">
                        <a href="<?=route_to('acercade.index')?>" class="nav-link">Acerca de</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=route_to('contacto.index')?>">Contacto</a>
                    </li>
                </ul>
                <!-- ... Resto del código ... -->

                <ul class="nav justify-content-end">
                    <?php if (session()->has('usuario')): ?>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex align-items-center" href="<?= route_to('usuario.mostrarPerfil') ?>"
                            style="color: #444c6c;">
                            <?php $imagenUsuario = session('usuario')->imagen ?? 'img_predeterminada.png'; ?>
                            <img src="<?= base_url('/images/usuario/' . $imagenUsuario) ?>" alt="Imagen de usuario"
                                style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                            Bienvenido, <?= session('usuario')->usuario ?>
                        </a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" style="color: #444c6c;" href="<?= route_to('usuario.logout') ?>">Salir de
                            sesión</a>
                    </li>

                </ul>


                <?php else: ?>
                <!-- Si el usuario no ha iniciado sesión -->

                <li class="nav-item">
                    <a class="nav-link" style="color: #444c6c ;"
                        href="<?= route_to('usuario.register') ?>">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: #444c6c ;" href="<?= route_to('usuario.login') ?>">Iniciar
                        Sesion</a>
                </li>

                <?php endif; ?>

                </ul>

                <!-- ... Resto del código ... -->

            </div>
        </div>
    </nav>
</header>

<body>
    <?= view('Dashboard/mensaje') ?>
    <?= view('Dashboard/error') ?>

    <?php if (!session()->get('ocultarCard')): ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    <?php else: ?>
    <?= $this->renderSection('content') ?>
    <?php session()->remove('ocultarCard');?>
    <?php endif; ?>
</body>

<footer class="bg-dark text-white py-3 mt-auto" style="background-color: #343a40;">
    <div class="container text-center">
        <p>© 2023 WebDoc. Todos los derechos reservados.</p>
    </div>
</footer>