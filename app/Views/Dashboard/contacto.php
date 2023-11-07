<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>

    <style>
        .shadow {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        .card-header, .btn-primary {
            background-color: #cbdbe5;
            color: #1b2530;
            border: none;
        }
        .card-body {
            color: #1b2530;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">Contacto</h1>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h3>Envíanos un mensaje</h3>
                </div>
                <div class="card-body">
                <form method="post" action="<?= route_to('usuario.mensaje_post') ?>">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="mensaje" class="form-label">Mensaje</label>
        <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
</form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h3>Información de Contacto</h3>
                </div>
                <div class="card-body">
                    <p><strong>Dirección:</strong> Calle Ejemplo, 123, Ciudad</p>
                    <p><strong>Teléfono:</strong> (123) 456-7890</p>
                    <p><strong>Correo Electrónico:</strong> contacto@ejemplo.com</p>
                    <p><strong>Horario de Atención:</strong> Lunes a Viernes de 9:00 a 18:00</p>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>


<?= $this->endSection() ?>