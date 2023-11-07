<?php 

if(session()->has('mensaje')) {
    echo session('mensaje');
}

 ?>