<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

$con = mysqli_connect('localhost','root','','mensagensParaMin');

if (mysqli_connect_errno()) {
	exit('Não foi possível conectar com o banco');
}	

$mensagem = '';

if (isset($_POST['mensagem'])) {
	
	$mensagem = filter_input(INPUT_POST,'mensagem',FILTER_SANITIZE_STRING);

	$sql = "INSERT INTO mensagens (mensagem) VALUES ('$mensagem')";

	$resu = mysqli_query($con,$sql);

	$retorno = [];

	if ($resu) {
		$retorno['sucesso'] = 'Mensagem Enviada';
		$retorno['status'] = true;
	} else {
		$retorno['sucesso'] = 'Não foi possível enviar sua mensagem';
		$retorno['status'] = false;		
	}

	echo json_encode($retorno);
}
