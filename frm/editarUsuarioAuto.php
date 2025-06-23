<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 14/06/2017 12:16
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?>
<?php require_once("../config/config.php"); ?>
<?php if ($_SESSION['LOGADO']) { ?><?php
	if ($_SESSION['CODIGOUSUARIO']) {
		$carregarUsuario = new Classe\Usuario();
		$carregarUsuario->setCodUsuario($_SESSION['CODIGOUSUARIO']);
		$carregarUsuario->carregar();

		$_POST['txtNome'] = $carregarUsuario->getNome();
		$_POST['txtLogin'] = $carregarUsuario->getLogin();
	}
	?>
	<script type="text/javascript">
		$().ready(function () {
            $('.saida').html("");
			$('#editarUsuario').click(function (e) {
				e.preventDefault();
				overlayStart();
				$.ajax({
					method: 'POST',
					url: "php/editarUsuarioAuto.php",
					data: {
						txtNome: $('#txtNome').val(),
						txtSenhaAtual: $('#txtSenhaAtual').val(),
						txtSenhaNova: $('#txtSenhaNova').val(),
						txtSenhaNovaConfirmacao: $('#txtSenhaNovaConfirmacao').val(),
						btnEditarUsuario: '1'
					},
					dataType: "json",
					complete: function (data, status) {
						if (status === 'error' || !data.responseText) {
							console.log(data);
							$('.saida').html(data.responseText);
							overlayStop();
						}
						else {
							$('.saida').html(data.responseText);
							overlayStop();
						}
					}
				});
			});

			var imagemArquivo = {valor:''};
			$("#imagemFile").change(function(){
				if($('#imagemFile').val() != '') readFile( this,'imagemFile','imagemProgress',imagemArquivo);
			});

			$('#trocarImagem').click(function () {
				$("#imagemFile").click();
			})

			function readFile(input,selector,progress,output) {
				overlayStart();
				if ( input.files && input.files[0] ) {
					$('#'+progress).closest('.progress').parent().removeClass('hide');
					$('#'+progress).css('width','0%');
					$('#'+progress).html('0%');
					$('#'+progress).prop('aria-valuenow',0);
					var extensao = input.files[0].name.split('.')[input.files[0].name.split('.').length - 1].toLowerCase();
					if(extensao == 'png' || extensao == 'gif' || extensao == 'jpeg' || extensao == 'jpg') {
						var FR = new FileReader();
						FR.onprogress = function(evt){
							if (evt.lengthComputable) {
								var percentLoaded = Math.round((evt.loaded / evt.total) * 100);
								percentLoaded = percentLoaded/2;
								$('#' + progress).css('width', percentLoaded + '%');
								$('#' + progress).html(percentLoaded + '%');
								$('#' + progress).prop('aria-valuenow', percentLoaded);
							}
						};
						FR.onerror = function(evt){
							alert(evt);
							switch(evt.target.error.code) {
								case evt.target.error.NOT_FOUND_ERR:
									alert('File Not Found!');
									break;
								case evt.target.error.NOT_READABLE_ERR:
									alert('File is not readable');
									break;
								case evt.target.error.ABORT_ERR:
									break; // noop
								default:
									alert('An error occurred reading this file.');
							};
						};

						FR.onloadstart = function (e) {
							//document.getElementById('progress_bar').className = 'loading';
							//alert('carregando');
						};
						FR.onloadend = function (e) {
							$.ajax({
								url: 'php/uploadFile.php',
								type:'POST',
								data:{
									'conteudo': e.target.result,
									'extensao': extensao
								},
								xhr: function() {
									var myXhr = $.ajaxSettings.xhr();
									if (myXhr.upload) {
										// For handling the progress of the upload
										myXhr.upload.addEventListener('progress', function(e) {
											if (e.lengthComputable) {
												var max = e.total;
												var current = e.loaded;

												var Percentage = Math.round((current * 100)/max);
												Percentage = (Percentage/2)+50;

												$('#'+progress).css('width',Percentage + '%');
												$('#'+progress).html(Percentage + '%');
												$('#'+progress).prop('aria-valuenow',Percentage);
											}
										} , false);
									}
									return myXhr;
								},
								cache:false,

								success:function(data){
									$('#'+progress).css('width','100%');
									$('#'+progress).html('100%');
									$('#'+progress).prop('aria-valuenow',100);
									overlayStop(true);
									$('#imagemAtual').html('<img class="rounded-circle mx-auto d-block" id="theImg" width="100" height="100" src="'+e.target.result+'" />')
									output.valor =  data;
									$.ajax({
										method: 'POST',
										url: "php/editarUsuarioAuto.php",
										data: {
											txtImagem:output.valor,
											btnEditarUsuario: '1'
										},
										dataType: "json",
										complete: function (data, status) {
											if (status === 'error' || !data.responseText) {
												console.log(data);
												$('.saida').html(data.responseText);
											}
											else{
												$('#imagemUsuario').attr('src',e.target.result);
											}
										}
									});
								},

								error: function(data){
									console.log(data);
									$('#cadastrarStartup').prop('disabled',false);
									$('.saida').html("<div class='alert alert-danger alert-dismissable'>Problemas no envio do arquivo "+data+"</div>");
									overlayStop();
								}
							});
						};
						FR.readAsDataURL(input.files[0]);
					}
					else
					{
						$('.saida').html("<div class='alert alert-danger alert-dismissable'>Extensão precisa ser PNG/GIF/JPEG/JPG</div>");
						overlayStop();
					}
				}
			}
		});
	</script>
	<div id="saida"></div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="box-title">Meu Perfil </h4>
				</div>
				<div class="card-body card-block">
					<form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
						<div class="hide"><input type="file" name="file-input" id="imagemFile" class="form-control-file"></div>
						<div class="mx-auto d-block" style="cursor:pointer" id="trocarImagem">
							<div  id="imagemAtual"><img class="rounded-circle mx-auto d-block" src="images/avatar/<?=$_SESSION['IMAGEMUSUARIO'];?>"></div>
							<h5 class="text-sm-center mt-2 mb-1">Clique para trocar a imagem</h5>
							<div class="col-sm-12 hide">
								<div class="progress">
									<div id="imagemProgress" class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
								</div>
							</div>
						</div>
						<hr>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Nome</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtNome" name="txtNome" placeholder="Nome" class="form-control" value="<?= $_POST['txtNome']; ?>">
								<small class="form-text text-muted">Nome completo</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-input" class=" form-control-label">Login</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="text" id="txtLogin" name="txtLogin" disabled placeholder="Login" class="form-control" value="<?= $_POST['txtLogin']; ?>">
								<small class="form-text text-muted">Login de Acesso (email)</small>
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-password" class=" form-control-label">Senha atual</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="password" id="txtSenhaAtual" name="txtSenhaAtual" placeholder="Senha" class="form-control" value="">
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-password" class=" form-control-label">Senha nova</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="password" id="txtSenhaNova" name="txtSenhaNova" placeholder="Senha" class="form-control" value="">
							</div>
						</div>
						<div class="row form-group">
							<div class="col col-md-3">
								<label for="text-password" class=" form-control-label">Confirme a senha</label>
							</div>
							<div class="col-12 col-md-9">
								<input type="password" id="txtSenhaNovaConfirmacao" name="txtSenhaNovaConfirmacao" placeholder="Senha" class="form-control" value="">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<button type="submit" class="btn btn-primary btn-block btn-sm" id="editarUsuario" name="editarUsuario">Editar</button>
							</div>
						</div>
					</form>
					<div class="card-body"></div>
				</div>
			</div><!-- /# column -->
		</div>
	</div>
<?php } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>
