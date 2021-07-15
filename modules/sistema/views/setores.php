<?php
	$app = new Module();
	$db = new DB();
	$sectors = $db->select("vth_us_setores",null,null,null);
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">

			<div class="page-header">
				<h4 class="page-title">setors/Funçoes</h4>
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".new-sector"><i class="fas fa-plus-circle"></i> <b>Novo setor</b></button>
					</li>
				</ul>
			</div>

			<div class="modal fade new-sector" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="<?=$app->controller('new-sector'); ?>" method="post">
							<div class="modal-header">
								<h5 class="modal-title">Criar Novo setor</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<div class="form-group">
									<label>Nome</label>
									<input type="text" class="form-control form-control-lg" name="setor_nome" />
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
			
			<div class="row">
			<?php
				if($sectors):
					foreach($sectors as $sector):
			?>
				<div class="col-3 card">
					<div class="card-header">
						<h3 class="card-title text-center font-weight-bold">
							<?=$sector['setor_nome']; ?>
						</h3>
					</div>
					<div class="card-body" style="background-image: url('https://s3-sa-east-1.amazonaws.com/manual-do-enem-test/c45566ac670d4818a96a53b9dfa92cdb-setor.PNG'); background-position: center; background-repeat: no-repeat; background-size: cover; height: 200px;">
						
					</div>
					<div class="card-footer">
						<p class="text-center">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".edit-<?=$sector['id_setor']; ?>"><i class="fas fa-edit"></i></button>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-<?=$sector['id_setor']; ?>"><i class="fas fa-trash"></i></button>
						</p>
					</div>

					<div class="modal fade edit-<?=$sector['id_setor']; ?>" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="<?=$app->controller('edit-sector'); ?>" method="post">
									<input type="hidden" name="id_setor" value="<?=$sector['id_setor']; ?>">
									<div class="modal-header">
										<h5 class="modal-title">Editar</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<input type="text" class="form-control form-control-lg" value="<?=$sector['setor_nome']; ?>" name="setor_nome" required />
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">cancelar</button>
										<button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> <b>Salvar Edição</b></button>
									</div>
								</form>
							</div>
						</div>
					</div>

					<div class="modal fade delete-<?=$sector['id_setor']; ?>" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="<?=$app->controller('delete-sector'); ?>" method="post">
									<input type="hidden" name="id_setor" value="<?=$sector['id_setor']; ?>">
									<div class="modal-header">
										<h5 class="modal-title">Deletar</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Você realmente deseja deletar o setor <strong><?=$sector['setor_nome']; ?>?</strong></p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">cancelar</button>
										<button type="submit" class="btn btn-danger"><i class="fas fa-check-circle"></i> <b>Deletar</b></button>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			<?php
					endforeach;
				endif;
			?>
			</div>
		</div>
	</div>
</div>