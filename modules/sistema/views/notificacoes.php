<?php
	$app = new Module();
	$notify = new UserNotification();
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">

			<div class="page-header">
				<h4 class="page-title">Notificações de sistema</h4>
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".new-notify"><i class="fas fa-plus-circle"></i> <b>Nova Notificação</b></button>
					</li>
				</ul>
			</div>

			<div class="modal fade new-notify" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="<?=$app->controller('new-notify'); ?>" method="post">
							<div class="modal-header">
								<h5 class="modal-title">Nova Notificação</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<div class="form-group">
									<label>Titulo</label>
									<input type="text" class="form-control form-control-lg" name="notificacao_titulo" />
								</div>

								<div class="form-group">
									<label>Conteudo</label>
									<input type="text" class="form-control form-control-lg" name="notificacao_conteudo" />
								</div>

								<div class="form-group">
									<label>Link</label>
									<input type="text" class="form-control form-control-lg" name="notificacao_url" />
								</div>

								<div class="form-group">
									<label>Icone Font-awesome</label>
									<input type="text" class="form-control form-control-lg" name="notificacao_icone" />
								</div>

								
								<div class="form-group">
									<label>Imagem Avatar</label>
									<input type="text" class="form-control form-control-lg" name="notificacao_avatar" />
								</div>

							</div>
							<div class="modal-header">
								<b>OBS: No momento, esta ferramenta apenas trablha com envios em massa para todos os usuarios</b>
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
						$all = $notify->getAll(null," order by id_notificacao desc");
						if( $all ):
					?>
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th>ID</th>
								<th>Usuário</th>
								<th>Notificação</th>
								<th>Imagem</th>
								<th>Icone</th>
								<th>Link</th>
								<th>Visualização</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($all as $n):
							?>
							<tr>
								<td class="font-weight-bold">#<?=$n['id_notificacao']; ?></td>
								<td class="font-weight-bold"><img src="<?=Helper::avatar($n['usuario_avatar']); ?>" class="img-thumbnail rounded-circle" style="height: 50px; width: 50px;"> <?=$n['usuario_nome']; ?></td>
								<td><?=$n['notificacao_titulo']; ?></td>
								<td><p class="text-center"><img src="<?=Helper::avatar($n['notificacao_avatar']); ?>" class="img-thumbnail rounded-circle" style="height: 50px; width: 50px;"></p></td>
								<td><p class="text-center"><?=($n['notificacao_icone']) ? '<i class="'.$n["notificacao_icone"].' fa-3x"></i>' : '<i title="Não consta..." class="fas fa-times text-muted fa-3x"></i>'; ?></p></td>
								<td class="font-weight-bold"><a href="<?=$app->index() . "/" . $n['notificacao_url']; ?>"><?=$n['notificacao_url']; ?></a></td>
								<td><?=($n['notificacao_visualizado'] == 1) ? '<i class="fas fa-check-circle text-success fa-3x"></i>' : '<i class="fas fa-times text-danger fa-3x"></i>'; ?></td>
								<td>
									<button type="button" class="btn btn-danger"><i class="fas fa-trash"></i> <b>Apagar</b></button>
								</td>
							</tr>
							<?php
								endforeach;
							?>
						</tbody>
					</table>
					<?php
						endif;
					?>
				</div>
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$("table").DataTable();
	})
</script>