<?php
	$app = new Module();
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">

			<div class="page-header">
				<h4 class="page-title">Configurações de Integração</h4>
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="#">
							<i class="flaticon-home"></i>
						</a>
					</li>
					<li class="separator">
						<i class="flaticon-right-arrow"></i>
					</li>
					<li class="nav-item">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".new-integration"><i class="fas fa-plus-circle"></i> <b>Nova Integração</b></button>
					</li>
				</ul>
			</div>

			<div class="modal fade new-integration" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="<?=$app->controller('new-integration'); ?>" method="post">
							<div class="modal-header">
								<h5 class="modal-title">Configurar Nova Integração</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<div class="form-group">
									<label>Descrição</label>
									<input type="text" class="form-control form-control-lg" name="conta_nome" required />
								</div>

								<div class="form-group">
									<label>Painél</label>
									<input type="text" class="form-control form-control-lg" name="conta_painel" required />
								</div>

								<div class="form-group">
									<label>Ambiente</label>
									<input type="text" class="form-control form-control-lg" name="conta_ambiente" required />
								</div>

								<div class="form-group">
									<label>Appkey VTEX</label>
									<input type="text" class="form-control form-control-lg" name="conta_appkey" required />
								</div>

								<div class="form-group">
									<label>AppToken VTEX</label>
									<input type="text" class="form-control form-control-lg" name="conta_apptoken" required />
								</div>

								<div class="form-group">
									<label>ERP Protheus Username</label>
									<input type="text" class="form-control form-control-lg" name="conta_usuarioprotheus" required />
								</div>

								<div class="form-group">
									<label>ERP Protheus Pass</label>
									<input type="text" class="form-control form-control-lg" name="conta_senhaprotheus" required />
								</div>
							
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default font-weight-bold" data-dismiss="modal">Cancelar</button>
								<button type="submit" class="btn btn-primary font-weight-bold"><i class="fas fa-check-circle"></i> <b>Cadastrar</b></button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
				<?php
					$db = new DB();
					$accounts = $db->select("vth_contas",null,null,null);
					if( $accounts ):
				?>
				<table class="table table-hover table-bordered dtable">
					<thead class="thead-dark">
						<tr class="text-center">
							<th>ID</th>
							<th>Descrição</th>
							<th>Painel</th>
							<th>Ambiente</th>
							<th>WMS</th>
							<th>Armazem</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach($accounts as $account):
						?>
						<tr class="font-weight-bold text-center">
							<td>#<?=$account['id_conta']; ?></td>
							<td><?=$account['conta_nome']; ?></td>
							<td><?=$account['conta_painel']; ?></td>
							<td><?=$account['conta_ambiente']; ?></td>
							<td><?=($account['conta_integracaowms']=="S")?'<i class="fas fa-check-circle text-success fa-2x"></i>':'<i class="fas fa-times-circle text-danger fa-2x"></i>'; ?></td>
							<td><?=$account['conta_armazem']; ?></td>
							<td> 
								<button type="button" class="btn btn-primary"><i class="fas fa-edit"></i> <b>Editar</b></button>
								<button type="button" class="btn btn-danger"><i class="fas fa-trash"></i> <b>Delegtar</b></button>
							</td>
						</tr>
						<?php
							endforeach;
						?>
					</tbody>
				</table>
				<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(".dtable").each(function(){
		$(this).DataTable()
	})
</script>