<?= $this->extend('/Dashboard/Layout/header') ?>

<?= $this->section('content') ?>
<style>
.main-content{
	width: 50%;
	border-radius: 20px;
	box-shadow: 0 5px 5px rgba(0,0,0,.4);
	margin: 5em auto;
	display: flex;
}
.company__info{
	background-color: #cbdbe5;
	border-top-left-radius: 20px;
	border-bottom-left-radius: 20px;
	display: flex;
	flex-direction: column;
	justify-content: center;
	color: #fff;
}

@media screen and (max-width: 640px) {
	.main-content{width: 90%;}
	.company__info{
		display: none;
	}
	.login_form{
		border-top-left-radius:20px;
		border-bottom-left-radius:20px;
	}
}
@media screen and (min-width: 642px) and (max-width:800px){
	.main-content{width: 70%;}
}
.row > h3{
	color:#008080;
}
.login_form{
	background-color: #fff;
	border-top-right-radius:20px;
	border-bottom-right-radius:20px;
	border-top:1px solid #cbdbe5;
	border-right:1px solid #cbdbe5;
}
form{
	padding: 0 2em;
}
.form__input{
	width: 100%;
	border:0px solid transparent;
	border-radius: 0;
	border-bottom: 1px solid #b0c7d1;
	padding: 1em .5em .5em;
	padding-left: 2em;
	outline:none;
	margin:1.5em auto;
	transition: all .5s ease;
}
.form__input:focus{
	border-bottom-color: #b0c7d1;
	box-shadow: 0 0 5px rgba(0,80,80,.4); 
	border-radius: 4px;
}
.btn{
	transition: all .5s ease;
	width: 70%;
	border-radius: 30px;
	color:#008080;
	font-weight: 600;
	background-color: #fff;
	border: 1px solid #b0c7d1;
	margin-top: 1.5em;
	margin-bottom: 1em;
}
.btn:hover, .btn:focus{
	background-color: #cbdbe5;
	color:#fff;
}

</style>


    
    <div class="container-fluid">
		<div class="row main-content bg-success text-center">
			<div class="col-md-4 text-center company__info">
				<span class="company__logo"><img src="/images/logo.jpeg" style="width: 150px;
	height: 150px;" alt=""></span>
				
			</div>
			<div class="col-md-8 col-xs-12 col-sm-12 login_form ">
				<div class="container-fluid">
					<div class="row">
						<h3><br>Registrarse</h3>
					</div>
					<div class="row">
						<form action="<?= route_to('usuario.register_post')?>" method="post" control="" class="form-group">
                            <div class="row">
								<input type="text" name="correo" id="correo" class="form__input" placeholder="Correo">
							</div>
							<div class="row">
								<input type="text" name="usuario" id="usuario" class="form__input" placeholder="Usuario">
							</div>
                            
							<div class="row">
								
								<input type="password" name="contrasena" id="contrasena" class="form__input" placeholder="Contraseña">
							</div>
		
							<div class="row">
								<input type="submit" value="Registrarse" class="btn">
							</div>
						</form>
					</div>
					<div class="row">
						<p>¿Ya tienes cuenta? <a href="<?= route_to('usuario.login')?>">Inicia sesión</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>
