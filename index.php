<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Mensagens para Vinícius</title>
	<meta charset="utf-8">
</head>
<body>
	<form id="form">
		<p><textarea name="mensagem" placeholder="Mande sua mensagem para min" required></textarea></p>
		<button>Enviar</button>
	</form>

	<div id="respostaMensagemEnviada"></div>
	<div id="pesquisandoMensagens"></div>
	
	<section class="mensagens">
	</section>
	
	<script src="jquery.js"></script>
	<script>
		var $form = document.querySelector('#form');
		var buscarMensagensAutomatico = '';
		document.querySelector('#pesquisandoMensagens').innerHTML = '<p>Pesquisando Mensagens recebidas...</p>';	
		
		$form.addEventListener('submit',function(e) {
			e.preventDefault();
			salvarMensagem($(this));
		});

		function salvarMensagem(dados) {
			var intervaloMensagem = '';
			var buscarMensagemAutomatico;
			var btn = document.querySelector('#form button');
			var txtArea = document.querySelector('#form textarea');
			
			pararBuscaAutomaticaDeMensagens();
			
			$.ajax({
				type:"POST",
				data:dados.serialize(),
				url:"salvarMensagem.php",
				async:true
			}).then(success,fail);

			function success(data) {
				var mensagem = $.parseJSON(data)['sucesso']
				var status = $.parseJSON(data)['status'];
				
				if (status) {
					$('#respostaMensagemEnviada').html(mensagem);
					btn.disabled = true;
					txtArea.value = '';
					txtArea.focus();
					
					intervaloMensagem = setInterval(function() {
						$('#respostaMensagemEnviada').html('Buscando Mensagem... ');
						buscarMensagemRecemRecebida();
						pararBuscaMensagem();
						btn.disabled = false;
						$('#respostaMensagemEnviada').html('');
					},2000);
				}	
			}
	
			function fail() {
				console.log('Falha ao enviar sua mensagem.');
			}
			
			function pararBuscaMensagem() {
				clearInterval(intervaloMensagem);
			}
			
			function buscarMensagemRecemRecebida() {
				$.ajax({
					url:"buscarMensagemRecemRecebida.php"
				}).then(sucess,fail);
			
				function sucess(data) {	
					var sucesso = $.parseJSON(data)['sucesso'];
				
					if (sucesso) {
						var mensagem = $.parseJSON(data)['mensagem'];
						fazerBuscaAutomaticaMensagens();
					}
				}

				function fail() {
					console.log('falha ao buscar mensagem');
				}
			}
		}
		
		function fazerBuscaAutomaticaMensagens() {
			
			buscarMensagensAutomatico = setInterval(function() {

				$.ajax({
					url:"buscarMensagensAutomatico.php",
					async:true
				}).then(sucess,fail);
			
				function sucess(dados) {
					var mensagens = '';
					document.querySelector('#pesquisandoMensagens').innerHTML = '';
					document.querySelector('.mensagens').innerHTML = '';
					
					if (dados) {
						mensagens = $.parseJSON(dados);
					}
				
					if (mensagens) {
						$.each(mensagens,function(indice,msgs) {
							document.querySelector('.mensagens').innerHTML += '<p>'+msgs.mensagem+'</p>';
						});
					}
				}
			
				function fail() {
					console.log('Falha ao carregar as mensagens');
				}
			},5000);
		}
		
		function pararBuscaAutomaticaDeMensagens() {
			setInterval(buscarMensagensAutomatico);
		}
		
		fazerBuscaAutomaticaMensagens();
	</script>
</body>
</html>