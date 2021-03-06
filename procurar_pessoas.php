<!-- <?php	
	// session_start();

	// if(empty($_SESSION['usuario'])){
	// 	header('Location: index.php?erro=1');
	// }

?> -->
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

                $('#nome_pessoa').keypress(function(e) {
                    if ( e.keyCode == 13 ) {
                        $('#btn_procurar_pessoa').click();
                        return false;
                    }
                });

				// Associar o evento de click ao Botão
				$('#btn_procurar_pessoa').click( function(){
				
					if($('#nome_pessoa').val().length > 0){
						
						$.ajax({
							url:'get_pessoas.php',
							method: 'post',
                            data: $("#form_procurar_pessoa").serialize(),
							success: function(data){
								$('#pessoas').html(data);

                                $('.btn_seguir').click( function(){
                                   var id_usuario = $(this).data('id_usuario');

                                    $("#btn_seguir_"+id_usuario).hide();
                                    $("#btn_deixar_seguir_"+id_usuario).show();
    
                                    $.ajax({
                                        method: 'post',
                                        url: 'seguir.php',
                                        data: {
                                            seguir_id_usuario:id_usuario
                                        },
                                        success: function(data){
                                            atualizaPainel();
                                        },
                                    });
                                });	

                                $('.btn_deixar_seguir').click( function(){
                                   var id_usuario = $(this).data('id_usuario');

                                    $("#btn_deixar_seguir_"+id_usuario).hide();
                                    $("#btn_seguir_"+id_usuario).show();

                                    $.ajax({
                                        method: 'post',
                                        url: 'deixar_seguir.php',
                                        data: {
                                            deixar_seguir_id_usuario:id_usuario
                                        },
                                        success: function(data){
                                            atualizaPainel();
                                        },
                                    });
                                });	

								atualizaPainel();
                            }
						});

					} else{
						return false;
					}
				});

				function atualizaPainel(){
					
					$.ajax({
						url: 'atualiza_painel.php',
						success: function(data){
							$('#painel').html(data);
						}
					});
				}
				
				atualizaPainel();
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
	            <li><a href="home.php">Home</a></li>
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	

	    	<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body" id="painel"></div>
			 	</div>
			</div>
			
	    	<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-body">
						<form method="post" id="form_procurar_pessoa" class="input-group">
							<input type="text" id="nome_pessoa" name="nome_pessoa" class="form-control" placeholder="Quem você está procurando?" maxlength="140">
							<span class="input-group-btn">
								<button type="button" id="btn_procurar_pessoa" class="btn btn-default">Procurar</button>
							</span>
						</form>
					</div>
				 </div>
				 
				<div id="pessoas" class="list-group"></div>

			</div>

			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
					</div>
			 	</div>
			</div>
		</div>
	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	</body>
</html>
