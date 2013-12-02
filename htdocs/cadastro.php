<?php
	include('Connection.php');


	$connection = new Connection();

	$usuario = $_POST["usuario"];
	$senha = $_POST["senha"];

	$data = array(
					'usuario_login' => utf8_encode($usuario), 
					'usuario_senha' => utf8_encode($senha)
				);

	$connection->create('usuario', $data);

	include('index.html');
	echo "<script type='text/javascript'>alert('Cadastro efetuado com sucesso!')</script>";
?>