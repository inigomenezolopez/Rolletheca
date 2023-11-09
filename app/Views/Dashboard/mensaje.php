<?php if (session()->has('mensaje')): ?>
    <div class="alert alert-warning">
        <?= session('mensaje') ?>
    </div>
<?php endif; ?>