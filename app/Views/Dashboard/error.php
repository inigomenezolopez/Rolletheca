<?php 
if ($validation = session()->getFlashdata('validation')) {
    if (is_array($validation)) {
        echo '<div class="alert alert-danger">';
        foreach ($validation as $error) {
            echo '<p>' . esc($error) . '</p>';
        }
        echo '</div>';
    } elseif (method_exists($validation, 'getErrors')) {
        echo '<div class="alert alert-danger">';
        foreach ($validation->getErrors() as $error) {
            echo '<p>' . esc($error) . '</p>';
        }
        echo '</div>';
    }
}
?>

