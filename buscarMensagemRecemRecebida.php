<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

$con = mysqli_connect('localhost','root','','mensagensParaMin');

if (mysqli_connect_errno()) {
	exit('Não foi possível se conectar com o banco');
}

$sql = "SELECT * FROM mensagens ORDER BY id DESC LIMIT 1";

$resu = mysqli_query($con,$sql);

if (mysqli_num_rows($resu) >=1) {
	$dados = mysqli_fetch_assoc($resu);
	$dados['sucesso'] = true;
} else {
	$dados['sucesso'] = false;
}

echo json_encode($dados);