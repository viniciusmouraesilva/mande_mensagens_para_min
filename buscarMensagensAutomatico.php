<?php
$con = mysqli_connect('localhost','root','','mensagensParaMin');

if (mysqli_connect_errno()) {
	exit('Não foi possível conectar ao banco');
}

$sql = "SELECT * FROM mensagens ORDER BY id ASC";

$resu = mysqli_query($con,$sql);

$dados = [];

if (mysqli_num_rows($resu) >= 1) {
	
	while ($dado = mysqli_fetch_assoc($resu)) {
		$dados[] = $dado;
	}
	
	//$dados['sucesso'] = true;
} else {
	//$dados['sucesso'] = false;
}

echo json_encode($dados);