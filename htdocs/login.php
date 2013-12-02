<?php
	include('Connection.php');

	$connection = new Connection();

	$usuario = $_POST["usuario"];
	$senha = $_POST["senha"];

	$data = array(
					'usuario_login' => utf8_encode($usuario), 
					'usuario_senha' => utf8_encode($senha)
				);

	$loginId = $connection->getLoginId($usuario, $senha);
	
	if ($loginId != NULL) {
		include('fuscao.html');
	} else {
	$_SESSION['error'] = "Dados inv&aacute;lidos.";
		include('index.html');
		echo "<script type='text/javascript'>alert('Usuário ou senha inválidos!')</script>";
	}
?>