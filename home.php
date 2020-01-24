<?php	
	session_start();

	if(empty($_SESSION['usuario']) || empty($_SESSION['id'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.php');

	$obJDb = new db();
    $link = $obJDb->conecta_mysql();

	$idUsuario = $_SESSION['id'];

	// qtde de tweets
	$sql = "SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $idUsuario";
	
	$qtde_tweets = 0;

	$resp = mysqli_query($link, $sql);
	if($resp){
		$respAssoc = mysqli_fetch_assoc($resp);
		$qtde_tweets = $respAssoc['qtde_tweets'];
	} else{
		echo 'Erro ao executar a query';
	}

	// qtde de seguidores
	$sql = "SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $idUsuario";

	$qtde_seguidores = 0;

	$resp = mysqli_query($link, $sql);
	if($resp){
		$respAssoc = mysqli_fetch_assoc($resp);
		$qtde_seguidores = $respAssoc['qtde_seguidores'];
	} else{
		echo 'Erro ao executar a query';
	}

?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<!-- <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->

		 
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" 
		integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		crossorigin="anonymous"></script>
		

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			$(document).ready( function(){
				
				$('#texto_tweet').keypress(function(e) {
                    if ( e.keyCode == 13 ) {
                        $('#btn_tweet').click();
                        return false;
                    }
                });

				// Associar o evento de click ao Botão
				$('#btn_tweet').click( function(){
				
					if($('#texto_tweet').val().length > 0){
						
						$.ajax({
							url:'inclui_tweet.php',
							method: 'post',
							data: $("#form_tweet").serialize(),
							success: function(data){
								$('#texto_tweet').val('');
								atualizaTweet();
							}
						});

					} else{
						return false;
					}
				});

				function atualizaTweet(){
					// carrega os tweets
					$.ajax({
						url: 'get_tweets.php',
						success: function(data){
							$('#tweets').html(data);
						}
					});
				}

				atualizaTweet();

			});
		</script>
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	

	    	<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4 style="text-align:center"><?=$_SESSION['usuario']??null?></h4>
						<hr>
						<div class="col-md-5">
							TWEETS <br> <?=$qtde_tweets?>
						</div>
						<div class="col-md-7">
							SEGUIDORES <br> <?=$qtde_seguidores?>
						</div>
					</div>
			 	</div>
			</div>
			
	    	<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-body">
						<form method="post" id="form_tweet" class="input-group">
							<input type="text" id="texto_tweet" name="texto_tweet" class="form-control" placeholder="O que está acontecendo agora?" maxlength="140">
							<span class="input-group-btn">
								<button type="button" id="btn_tweet" class="btn btn-default">TWEET</button>
							</span>
						</form>
					</div>
				 </div>
				 
				<div id="tweets" class="list-group"></div>

			</div>

			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="procurar_pessoas.php">Procurar por Pessoas</a></h4>
					</div>
			 	</div>
			</div>
		</div>
	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	</body>
</html>