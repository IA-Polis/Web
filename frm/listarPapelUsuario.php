<?php
// Autor: Isaias José Ramos de Oliveira GitHub: @ijro
?>
<?php require_once("../config/config.php");?>
<?if(isset($_SESSION['PERMISSOES']['listarPapelUsuario'])){?>
	<div id="papelUsuario1"></div>
    <div id="saida" class="saida"></div>
	<div id="papelUsuario2">
		<script type="text/javascript">
			$().ready(function()
			{
				$('#btnAddPapelUsuario').click( function() {
					$('#papelUsuario1').html('');
					overlayStart();
					$.post("frm/cadastrarPapelUsuario.php",{}, function(resultado){
					    $('#papelUsuario1').html(resultado);
					    overlayStop();
					});
				});
				$('.editarPapelUsuario').click(function() {
					$('#papelUsuario1').html('');
					overlayStart();
					$.post("frm/editarPapelUsuario.php", {codPapelUsuario: this.id}, function(resultado){ 
					    $('#papelUsuario1').html(resultado);
					    overlayStop();
					});
				});
				$('.excluirPapelUsuario').click(function() {
					var codPapelUsuario = this.id;
					$('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este PapelUsuario?');
					$('#modalExclusao').modal("show");
					$('#modalExclusaoDelete').on('click', function(e) {
						overlayStart();
						$.ajax({
						    method: 'POST',
						    url: "php/excluirPapelUsuario.php",
						    data:{
						        codPapelUsuario: codPapelUsuario,
						        btnExcluirPapelUsuario: '1'
						    },
						    dataType: "json",
						    complete: function (data, status) {
						        if (status === 'error' || !data.responseText) {
						            console.log(data);
						            $('.saida').html(data.responseText);
						            overlayStop();
						        }else{
						            $('.saida').html(data.responseText);
						            $('#linhaPapelUsuario'+codPapelUsuario).addClass('hide');
						            overlayStop();
						        }
						    }
						});
					});
				});
				$('#dinamicPapelUsuario').DataTable({
				    stateSave: true,
				    "aLengthMenu": [
				        [10, 25, 50, 100, 200, -1],
				        [10, 25, 50, 100, 200, "Todos"],
				    ],
				    "language": {
				        "emptyTable":     "Lista vazia",
						"info":           "Mostrando _START_ até _END_ de um total de _TOTAL_ registros",
						"infoEmpty":      "Mostrando 0 até 0 de 0 registros",
						"infoFiltered":   "(filtrado de um total de _MAX_ total records)",
						"infoPostFix":    ".",
						"thousands":      ",",
						"lengthMenu":     "Mostrar _MENU_ registros",
						"loadingRecords": "Carregando...",
						"processing":     "Processando...",
						"search":         "Busca: ",
						"zeroRecords":    "Nenhum registro encontrado",
						"paginate": {
				            "first":      "Primeiro",
							"last":       "Último",
							"next":       "Próximo",
							"previous":   "Anterior"
				        },
				        "aria": {
				            "sortAscending":  ": ative para ordenar coluna de forma crescente",
							"sortDescending": ": ative para ordenar coluna de forma decrescente"
				        }
				    }
				});
			});
		</script>
		<div class="row">
			<div class="col-md-3">
			    <div class="card">
			        <div class="card-body">
			            <?if(isset($_SESSION['PERMISSOES']['cadastrarPapelUsuario'])){?>
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddPapelUsuario" name="btnAddPapelUsuario">Cadastrar PapelUsuario</button>
                        <?}?>
			        </div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-lg-12">
		        <div class="card">
		            <div class="card-header">
		                <h4 class="box-title">Listagem de PapelUsuarios</h4>
		            </div>
		            <div class="card-body">
		                <table id="dinamicPapelUsuario" class="dynamic-table table table-striped table-bordered table-hover">
			                <thead>
			                    <tr>
			                        <th>#</th>
			                        <th>Usuario</th>
			                        <th>Papel</th>
			                        <th>Ação</th>
			                    </tr>
			                </thead>
			                <tbody>
			                    <?
			                    $estaPapelUsuario = new Classe\PapelUsuario();
			                    $colPapelUsuario = new Config\phpCollection();
			                    $colPapelUsuario = $estaPapelUsuario->carregarTodosCriterio('','');
			                    if($colPapelUsuario->length > 0)
			                    {
			                        $aux = 1;
			                        do
			                        {
			                        ?>
			                        <tr id='linhaPapelUsuario<?=$colPapelUsuario->current()->getCodPapelUsuario();?>'>
			                            <td><?=$aux++;?></td>
			                        <?php
			                        $foreingUsuario =  new Classe\Usuario();
			                        $foreingUsuario->setCodUsuario($colPapelUsuario->current()->getCodUsuario());
			                        $foreingUsuario->carregar();
			                        ?>
			                            <td><?=$foreingUsuario->getNome();?></td>
			                        <?php
			                        $foreingPapel =  new Classe\Papel();
			                        $foreingPapel->setCodPapel($colPapelUsuario->current()->getCodPapel());
			                        $foreingPapel->carregar();
			                        ?>
			                            <td><?=$foreingPapel->getNome();?></td>
			                            <td>
			                                <?if(isset($_SESSION['PERMISSOES']['editarPapelUsuario'])){?><a style="cursor:pointer" href="#" title="Editar PapelUsuario" class="editarPapelUsuario " id="<?=$colPapelUsuario->current()->getCodPapelUsuario();?>"><i class="fa fa-pencil fa-lg"></i></a><?}?>
			                                <?if(isset($_SESSION['PERMISSOES']['excluirPapelUsuario'])){?><a style="cursor:pointer" href="#" Title="Excluir PapelUsuario" class="excluirPapelUsuario " id="<?=$colPapelUsuario->current()->getCodPapelUsuario();?>"><i class="fa fa-trash-o fa-lg"></i></a><?}?>
			                            </td>
			                        </tr>
			                        <?
			                        }while($colPapelUsuario->has_next());
			                    }
			                    ?>
			                </tbody>
			            </table>
			        </div>
			    </div>
		    </div>
	    </div>
	</div>
<?}else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>";?>
