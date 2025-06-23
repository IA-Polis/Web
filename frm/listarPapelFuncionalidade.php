<?php
// Autor: Isaias
// Gerada em 10/04/2015 15:34:24
// Última atualização em 26/04/2018 14:09:20
// Gerada pela classe GeradorClasses C# versão 1.6.1.9
?><?php require_once("../config/config.php"); ?><? if (isset($_SESSION['PERMISSOES']['listarPapelFuncionalidade'])) { ?>
	<div id="papelFuncionalidade1"></div>
    <div id="saida" class="saida"></div>
	<div id="papelFuncionalidade2">
		<script type="text/javascript">
			$().ready(function () {
				$("form").submit(function (e) {
					e.preventDefault();
					return false;
				});
				$('#btnSelectAll').click(function () {
					if ($(this).hasClass('cboFuncionalidade')) {
						$('input[type="checkbox"]', allPages).prop('checked', false);
					} else {
						$('input[type="checkbox"]', allPages).prop('checked', true);
					}
					$(this).toggleClass('cboFuncionalidade');
				});
				$('#btnEditarPapelFuncionalidade').click(function () {
					$('#papelFuncionalidade1').html('')
					var cboFuncionalidade = $('.cboFuncionalidade', allPages).serializeArray();
					overlayStart();
					$.ajax({
						method: 'POST',
						url: "php/editarPapelFuncionalidade.php",
						data: {
							cboFuncionalidade: cboFuncionalidade,
							codPapel: '<?=$_POST['codPapel'];?>',
							btnEditarPapelFuncionalidade: 1
						},
						dataType: "json",
						complete: function (data, status) {
							if (status === 'error' || !data.responseText) {

								overlayStop();
							}
							else {
								$('#papelFuncionalidade1').html(data.responseText);
								overlayStop();
							}

						}
					});
				});
				var oTable = $('#dynamic-table').dataTable({
					stateSave: true,
					"aLengthMenu": [
						[10, 25, 50, 100, 200, -1],
						[10, 25, 50, 100, 200, "Todos"],
					],
					"language": {
						"emptyTable": "Lista vazia",
						"info": "Mostrando _START_ até _END_ de um total de _TOTAL_ registros",
						"infoEmpty": "Mostrando 0 até 0 de 0 registros",
						"infoFiltered": "(filtrado de um total de _MAX_ total records)",
						"infoPostFix": "",
						"thousands": ",",
						"lengthMenu": "Mostrar _MENU_ registros",
						"loadingRecords": "Carregando...",
						"processing": "Processando...",
						"search": "Busca:",
						"zeroRecords": "Nenhum registro encontrado",
						"paginate": {
							"first": "Primeiro",
							"last": "Último",
							"next": "Próximo",
							"previous": "Anterior"
						},
						"aria": {
							"sortAscending": ": ative para ordenar coluna de forma crescente",
							"sortDescending": ": ative para ordenar coluna de forma decrescente"
						}
					}
				});
				var allPages = oTable.fnGetNodes();
			});
		</script>
		<?
		$papel = new Classe\Papel();
		$papel->setCodPapel($_POST['codPapel']);
		$papel->carregar();
		?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="box-title">Listagem de funcionalidades para o papel: <?= $papel->getNome(); ?></h4>
					</div>
					<div class="card-body">
						<table id="dynamic-table" class="dynamic-table table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Funcionalidade</th>
								<th>Ação</th>
							</tr>
							</thead>
							<tbody>
							<?
							$estaFuncionalidade = new Classe\Funcionalidade();
							$colFuncionalidade = new Config\phpCollection();
							$colFuncionalidade = $estaFuncionalidade->carregarTodosCriterio('', '');
							if ($colFuncionalidade->length > 0) {
								do {
									?>
									<tr>
										<td><?= $colFuncionalidade->current()->getCodFuncionalidade(); ?></td>
										<td><?= $colFuncionalidade->current()->getNome(); ?></td>
										<?
										$papelFuncionalidade = new Classe\PapelFuncionalidade();
										$papelFuncionalidade->setCodPapel($_POST['codPapel']);
										$papelFuncionalidade->setCodFuncionalidade($colFuncionalidade->current()->getCodFuncionalidade());
										$papelFuncionalidade->carregarPeloPapelFuncionalidade();
										?>
										<td>
											<input type="checkbox" class="cboFuncionalidade" <?= $papelFuncionalidade->getCodPapelFuncionalidade() ? 'checked="checked"' : ''; ?> id="cboFuncionalidade" name="cboFuncionalidade" value="<?= $colFuncionalidade->current()->getCodFuncionalidade(); ?>" />
										</td>
									</tr>
									<?
								} while ($colFuncionalidade->has_next());
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<? if (isset($_SESSION['PERMISSOES']['editarPapelFuncionalidade'])) { ?>
									<button type="submit" class="btn btn-primary btn-block btn-sm" id="btnEditarPapelFuncionalidade" name="btnEditarPapelFuncionalidade">Salvar</button><? } ?>
							</div>
							<div class="col-lg-6">
								<button type="submit" class="btn btn-primary btn-block btn-sm" id="btnSelectAll" name="btnSelectAll">Selecionar todos</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<? } else echo "<div class='alert alert-danger alert-dismissable'><p>Acesso Negado!</p></div>"; ?>