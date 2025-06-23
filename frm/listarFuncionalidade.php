<?php
// Autor: Isaias
// Gerada em 30/01/2019 12:34:42
// Última atualização em 30/01/2019 12:34:42
// Versão 3.6.0.0
?>
<?php require_once("../config/config.php");?>
<?if(isset($_SESSION['PERMISSOES']['listarFuncionalidade'])){?>
	<div id="funcionalidade1"></div>
    <div id="saida" class="saida"></div>
	<div id="funcionalidade2">
		<script type="text/javascript">
			$().ready(function()
			{
				$('#btnAddFuncionalidade').click( function() {
					$('#funcionalidade1').html('');
					overlayStart();
					$.post("frm/cadastrarFuncionalidade.php",{}, function(resultado){
					    $('#funcionalidade1').html(resultado);
					    overlayStop();
					});
				});
				$('.editarFuncionalidade').click(function() {
					$('#funcionalidade1').html('');
					overlayStart();
					$.post("frm/editarFuncionalidade.php", {codFuncionalidade: this.id}, function(resultado){ 
					    $('#funcionalidade1').html(resultado);
					    overlayStop();
					});
				});
				$('.excluirFuncionalidade').click(function() {
					var codFuncionalidade = this.id;
					$('#modalExclusao').find('.modal-body').html('Deseja mesmo excluir este Funcionalidade?');
					$('#modalExclusao').modal("show");
					$('#modalExclusaoDelete').on('click', function(e) {
						overlayStart();
						$.ajax({
						    method: 'POST',
						    url: "php/excluirFuncionalidade.php",
						    data:{
						        codFuncionalidade: codFuncionalidade,
						        btnExcluirFuncionalidade: '1'
						    },
						    dataType: "json",
						    complete: function (data, status) {
						        if (status === 'error' || !data.responseText) {
						            console.log(data);
						            $('.saida').html(data.responseText);
						            overlayStop();
						        }else{
						            $('.saida').html(data.responseText);
						            $('#linhaFuncionalidade'+codFuncionalidade).addClass('hide');
						            overlayStop();
						        }
						    }
						});
					});
				});
				$('#dinamicFuncionalidade').DataTable({
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
						"infoPostFix":    ",",
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
			            <?if(isset($_SESSION['PERMISSOES']['cadastrarFuncionalidade'])){?>
                            <button type="submit" class="btn btn-primary btn-block btn-sm" id="btnAddFuncionalidade" name="btnAddFuncionalidade">Cadastrar Funcionalidade</button>
                        <?}?>
			        </div>
		        </div>
		    </div>
		</div>
		<div class="row">
		    <div class="col-lg-12">
		        <div class="card">
		            <div class="card-header">
		                <h4 class="box-title">Listagem de Funcionalidades</h4>
		            </div>
		            <div class="card-body">
		                <table id="dinamicFuncionalidade" class="dynamic-table table table-striped table-bordered table-hover">
			                <thead>
			                    <tr>
			                        <th>#</th>
			                        <th>Nome</th>
			                        <th>Descricao</th>
			                        <th>Ação</th>
			                    </tr>
			                </thead>
			                <tbody>
			                    <?
			                    $estaFuncionalidade = new Classe\Funcionalidade();
			                    $colFuncionalidade = new Config\phpCollection();
			                    $colFuncionalidade = $estaFuncionalidade->carregarTodosCriterio('','');
			                    if($colFuncionalidade->length > 0)
			                    {
			                        $aux = 1;
			                        do
			                        {
			                        ?>
			                        <tr id='linhaFuncionalidade<?=$colFuncionalidade->current()->getCodFuncionalidade();?>'>
			                            <td><?=$aux++;?></td>
			                            <td><?=$colFuncionalidade->current()->getNome();?></td>
			                            <td><?=$colFuncionalidade->current()->getDescricao();?></td>
			                            <td>
			                                <?if(isset($_SESSION['PERMISSOES']['editarFuncionalidade'])){?><a style="cursor:pointer" title="Editar Funcionalidade" class="editarFuncionalidade green" id="<?=$colFuncionalidade->current()->getCodFuncionalidade();?>"><i class="fa fa-pencil fa-lg"></i></a><?}?>
			                                <?if(isset($_SESSION['PERMISSOES']['excluirFuncionalidade'])){?><a style="cursor:pointer" title="Excluir Funcionalidade" class="excluirFuncionalidade red" id="<?=$colFuncionalidade->current()->getCodFuncionalidade();?>"><i class="fa fa-trash-o fa-lg"></i></a><?}?>
			                            </td>
			                        </tr>
			                        <?
			                        }while($colFuncionalidade->has_next());
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
