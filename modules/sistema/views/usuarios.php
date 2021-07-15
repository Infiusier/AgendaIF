<?php
	$app = new Module();

	$db = new DB();
	$offices = $db->select("vth_us_cargos",null,null,null);
	$sectors = $db->select("vth_us_setores",null,null,null);
	$accounts = $db->select("vth_contas",null,null,null);
	
	$user = new User();
	$users = $user->get();
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">

			<div class="page-header">
				<h4 class="page-title">Controle de Usuários</h4>
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".new-user"><i class="fas fa-plus-circle"></i> <b>Novo Usuário</b></button>
					</li>
				</ul>
			</div>

			<div class="modal fade new-user" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="<?=$app->controller('new-user'); ?>" method="post">
							<div class="modal-header">
								<h5 class="modal-title">Criar Novo Usuário</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<div class="form-group">
									<label>Nome Completo</label>
									<input type="text" class="form-control form-control-lg" name="usuario_nome" />
								</div>

								<div class="form-group">
									<label>Conta</label>
									<select class="form-control form-control-lg" name="conta_id" <?=(!$accounts)?'disabled':''; ?>>
										<?php if($accounts): foreach($accounts as $ct): ?>
										<option value="<?=$ct['id_conta']; ?>"><?=$ct['conta_nome']; ?></option>
										<?php endforeach; endif; ?>
									</select>
								</div>

								
								<div class="form-group">
									<label>Cargo/Função</label>
									<select class="form-control form-control-lg" name="cargo_id" <?=(!$offices)?'disabled':''; ?>>
										<?php if($offices): foreach($offices as $of): ?>
										<option value="<?=$of['id_cargo']; ?>"><?=$of['cargo_nome']; ?></option>
										<?php endforeach; endif; ?>
									</select>
								</div>

								<div class="form-group">
									<label>Setor/Departamento</label>
									<select class="form-control form-control-lg" name="setor_id" <?=(!$sectors)?'disabled':''; ?>>
										<?php if($sectors): foreach($sectors as $set): ?>
										<option value="<?=$set['id_setor']; ?>"><?=$set['setor_nome']; ?></option>
										<?php endforeach; endif; ?>
									</select>
								</div>

								<div class="form-group">
									<label>E-mail</label>
									<div class="input-group">
									 	<input type="text" name="usuario_email" class="form-control form-control-lg" />
									 	<div class="input-group-append">
									   		<span class="input-group-text">@josuerangus.com.br</span>
									 	</div>
									</div>
								</div>

								<div class="form-group">
									<label>Senha</label>
									<input type="password" class="form-control form-control-lg" name="usuario_senha" value="cf2020" />
									<small>O campo é preenchido automaticamente com a senha padrão: cf2020</small>
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
					<div class="table-responsive">
						<?php if( $users ): ?>
						<table class="display table table-striped table-hover" >
							<thead>
								<tr class="text-center">
									<th class="text-left">Usuário</th>
									<th>Email</th>
									<th>Função</th>

									<th>Setor</th>
									<th>Ações</th>
								</tr>
							</thead>
							<tfoot>
								<tr class="text-center">
									<th class="text-left">Usuário</th>
									<th>Email</th>
									<th>Função</th>
									<th>Setor</th>
									<th>Ações</th>
								</tr>
							</tfoot>
							<tbody>

								<?php 
									foreach($users as $u):

										$status['Ativo']['theme'] = "success";
										$status['Ativo']['icon'] = "far fa-thumbs-up";
										$status['Solicitado']['theme'] = "warning";
										$status['Solicitado']['icon'] = "fa fa-spinner fa-spin";
										$status['Bloqueado']['theme'] = "danger";
										$status['Bloqueado']['icon'] = "far fa-times";
								?>
								<tr>
									<td style="font-size: 20px; font-weight: bold;">
										<div class="avatar">
											<img src="<?=Helper::avatar($u['usuario_avatar']); ?>" alt="..." class="avatar-img rounded-circle">
										</div>
										&nbsp;<?=$u['usuario_nome'];?>
									</td>
									<td style="font-size: 20px; font-weight: bold;"><?=$u['usuario_email'];?></td>
									<td style="font-size: 20px; font-weight: bold;"><?=$u['cargo_nome'];?></td>
									<td style="font-size: 20px; font-weight: bold;"><?=$u['setor_nome'];?></td>									
									<td style="font-size: 20px; font-weight: bold;" class="bg-<?=$status[$u['usuario_status']]['theme']; ?> text-white text-center">
										<i class="<?=$status[$u['usuario_status']]['icon']; ?>"></i> <?=$u['usuario_status']; ?>
									</td>
									<td>

										<?php if( $u["usuario_status"] == "Solicitado" ): ?>
										<button type="button" title="Aprovar <?=$u['usuario_nome']; ?>" data-toggle="modal" data-target=".aproved-<?=$u['id_usuario']; ?>" class="btn btn-icon btn-round btn-success" <?=(Helper::adminPermission()) ? '' : 'disabled'; ?>>
											<i class="fas fa-check-circle"></i>
										</button>
										<?php endif; ?>


										<?php if( $u["usuario_status"] != "Bloqueado" and $u["usuario_status"] != "Solicitado" ): ?>
										<button type="button" data-toggle="modal" data-target=".lock-<?=$u['id_usuario']; ?>" title="Bloquear <?=$u['usuario_nome']; ?>" class="btn btn-icon btn-round btn-black" <?=(Helper::adminPermission()) ? '' : 'disabled'; ?>>
											<i class="fas fa-lock"></i>
										</button>
										<?php elseif( $u["usuario_status"] == "Bloqueado" and $u["usuario_status"] != "Solicitado" ): ?>
										<button type="button" data-toggle="modal" data-target=".unlock-<?=$u['id_usuario']; ?>" title="Desbloquear <?=$u['usuario_nome']; ?>" class="btn btn-icon btn-round btn-info" <?=(Helper::adminPermission()) ? '' : 'disabled'; ?>>
											<i class="fas fa-unlock"></i>
										</button>
										<?php endif; ?>


										<button type="button" data-toggle="modal" data-target=".edit-user-<?=$u['id_usuario']; ?>" title="Editar Dados de <?=$u['usuario_nome']; ?>" class="btn btn-icon btn-round btn-primary" <?=(Helper::adminPermission()) ? '' : 'disabled'; ?>>
											<i class="fas fa-edit"></i>
										</button>
										<button type="button" data-toggle="modal" data-target=".delete-<?=$u['id_usuario']; ?>" title="Deletar <?=$u['usuario_nome']; ?>" class="btn btn-icon btn-round btn-danger" <?=(Helper::adminPermission()) ? '' : 'disabled'; ?>>
											<i class="fas fa-trash"></i>
										</button>

									</td>
								</tr>


								<div class="modal fade aproved-<?=$u['id_usuario']; ?>" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<form action="<?=$app->controller('aproved-request'); ?>" method="post">
												<input type="hidden" name="id_usuario" value="<?=$u['id_usuario']; ?>" />
												<div class="modal-header">
													<h5 class="modal-title">Aprovar Usuário</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<h3>Deseja aprovar a solicitação de <b><?=$u['usuario_nome']; ?></b>?</h3>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
													<button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-check-circle"></i> <b>Aprovar</b></button>
												</div>
											</form>
										</div>
									</div>
								</div>

								

								<div class="modal fade lock-<?=$u['id_usuario']; ?>" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<form action="<?=$app->controller('lock-user'); ?>" method="post">
												<input type="hidden" name="id_usuario" value="<?=$u['id_usuario']; ?>" />
												<div class="modal-header">
													<h5 class="modal-title">Bloquear Usuário</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<h3>Deseja bloquear o usuario <b><?=$u['usuario_nome']; ?></b>?</h3>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
													<button type="submit" class="btn btn-dark font-weight-bold"><i class="fas fa-lock"></i> <b>Bloquear</b></button>
												</div>
											</form>
										</div>
									</div>
								</div>

								<div class="modal fade unlock-<?=$u['id_usuario']; ?>" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<form action="<?=$app->controller('unlock-user'); ?>" method="post">
												<input type="hidden" name="id_usuario" value="<?=$u['id_usuario']; ?>" />
												<div class="modal-header">
													<h5 class="modal-title">Desbloquear Usuário</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<h3>Deseja desbloquear o usuario <b><?=$u['usuario_nome']; ?></b>?</h3>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
													<button type="submit" class="btn btn-info font-weight-bold"><i class="fas fa-unlock"></i> <b>Desbloquear</b></button>
												</div>
											</form>
										</div>
									</div>
								</div>

								<div class="modal fade edit-user-<?=$u['id_usuario']; ?>" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<form action="<?=$app->controller('edit-user'); ?>" method="post">
												<input type="hidden" name="id_usuario" value="<?=$u['id_usuario']; ?>">
												<div class="modal-header">
													<h5 class="modal-title">Editar <?=$u['usuario_nome']; ?></h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">

													<div class="form-group">
														<label>Nome Completo</label>
														<input type="text" class="form-control form-control-lg" value="<?=$u['usuario_nome']; ?>" name="usuario_nome" />
													</div>

													<div class="form-group">
														<label>Conta</label>
														<select class="form-control form-control-lg" name="conta_id" <?=(!$accounts)?'disabled':''; ?>>
															<?php if($accounts): foreach($accounts as $ct): ?>
															<option value="<?=$ct['id_conta']; ?>" <?=($u["id_conta"]==$ct["id_conta"])?'selected':''; ?>><?=$ct['conta_nome']; ?></option>
															<?php endforeach; endif; ?>
														</select>
													</div>

													
													<div class="form-group">
														<label>Cargo/Função</label>
														<select class="form-control form-control-lg" name="cargo_id" <?=(!$offices)?'disabled':''; ?>>
															<?php if($offices): foreach($offices as $of): ?>
															<option value="<?=$of['id_cargo']; ?>" <?=($u["id_cargo"]==$of["id_cargo"])?'selected':''; ?>><?=$of['cargo_nome']; ?></option>
															<?php endforeach; endif; ?>
														</select>
													</div>

													<div class="form-group">
														<label>Setor/Departamento</label>
														<select class="form-control form-control-lg" name="setor_id" <?=(!$sectors)?'disabled':''; ?>>
															<?php if($sectors): foreach($sectors as $set): ?>
															<option value="<?=$set['id_setor']; ?>" <?=($u["id_setor"]==$set["id_setor"])?'selected':''; ?>><?=$set['setor_nome']; ?></option>
															<?php endforeach; endif; ?>
														</select>
													</div>

													<div class="form-group">
														<label>E-mail</label>
														<div class="input-group">
															<?php $email = explode("@", $u['usuario_email']); ?>
														 	<input type="text" name="usuario_email" value="<?=$email[0]; ?>" class="form-control form-control-lg" />
														 	<div class="input-group-append">
														   		<span class="input-group-text">@josuerangus.com.br</span>
														 	</div>
														</div>
													</div>

													<div class="form-group">
														<label>Senha</label>
														<input type="password" class="form-control form-control-lg" name="usuario_senha" value="" />
														<small>Deixe em branco caso queira manter a senha antiga</small>
													</div>

												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default font-weight-bold" data-dismiss="modal">Cancelar</button>
													<button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-check-circle"></i> <b>Salvar Alterações</b></button>
												</div>
											</form>
										</div>
									</div>
								</div>

								<div class="modal fade delete-<?=$u['id_usuario']; ?>" tabindex="-1">
									<div class="modal-dialog">
										<div class="modal-content">
											<form action="<?=$app->controller('delete-user'); ?>" method="post">
												<input type="hidden" name="id_usuario" value="<?=$u['id_usuario']; ?>" />
												<div class="modal-header">
													<h5 class="modal-title">Deletar Usuário</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<h3>Deseja deletar o usuario <b><?=$u['usuario_nome']; ?></b>?</h3>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
													<button type="submit" class="btn btn-danger font-weight-bold"><i class="fas fa-trash"></i> <b>Deletar</b></button>
												</div>
											</form>
										</div>
									</div>
								</div>

								<?php endforeach; ?>

							</tbody>
						</table>
						<?php else: ?>

						<?php endif; ?>
					</div>
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