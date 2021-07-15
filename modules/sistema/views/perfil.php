<?php 
	$app = new Module(); 
	$user = Session::get();
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">
			<h4 class="page-title">Dados Pessoais</h4>
			<div class="row">
				<div class="col-md-8">
					<div class="card card-with-nav">
						<form action="<?=$app->controller('change-profile'); ?>" method="post">
							<div class="card-body">
								<div class="row mt-3">
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>Colaborador</label>
											<input type="text" class="form-control form-control-lg" name="usuario_nome" placeholder="Colaborador" value="<?=@$user['usuario_nome']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group form-group-default">
											<label>E-mail</label>
											<input type="email" class="form-control form-control-lg" name="usuario_email" placeholder="Name" value="<?=@$user['usuario_email']; ?>">
										</div>
									</div>
								</div>
								<div class="row mt-3">
									<div class="col-md-4">
										<div class="form-group form-group-default">
											<label>Cargo/Função
											<input type="text" class="form-control form-control-lg" name="" value="<?=$user['cargo_nome']; ?>" disabled>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-group-default">
											<label>Setor
											<input type="text" class="form-control form-control-lg" name="" value="<?=$user['setor_nome']; ?>" disabled>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group form-group-default">
											<label>Desde
											<input type="text" class="form-control form-control-lg" name="" value="<?=Helper::br_date($user['usuario_criacao']); ?>" disabled>
										</div>
									</div>
								</div>
								
								<div class="row mt-3 mb-1">
									<div class="col-md-12">
										<div class="form-group form-group-default">
											<label>Defina-se</label>
											<textarea class="form-control" name="usuario_sobre" placeholder="Sobre mim" rows="3"><?=@$user['usuario_sobre']; ?></textarea>
										</div>
									</div>
								</div>

								<fieldset>
									<legend>Alteração de senha</legend>
									<p>obs: Em caso de alteração de senha, entre com a senha antiga e uma nova senha para validação e modificação. caso não queira alterar nada, ignore os campos abaixo.</p>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Senha Antiga</label>
												<input type="password" class="form-control form-control-lg" name="oldpass" />
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-group-default">
												<label>Nova Senha</label>
												<input type="password" class="form-control form-control-lg" name="newpass" />
											</div>
										</div>
									</div>
								</fieldset>

								<div class="text-right mt-3 mb-3">
									<button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Atualizar Informações</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card card-profile">
						<div class="card-header" style="height: 260px; background-image: url('<?=Helper::folder(@$user['usuario_capa']); ?>'); background-position: center;">
							<button type="button" data-toggle="modal" data-target="
							.change-folder" class="btn btn-xs"><i class="fas fa-edit"></i> <b>Editar</b></button>
							<div class="profile-picture">
								<div class="avatar avatar-xl">
									<img src="<?=Helper::avatar($user['usuario_avatar']); ?>" alt="..." class="avatar-img rounded-circle">
									<button type="button" data-toggle="modal" data-target=".change-avatar" class="btn btn-xs"><i class="fas fa-edit"></i> <b>Editar</b></button>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="user-profile text-center">
								<div class="name"><?=$user['usuario_nome']; ?></div>
								<div class="job"><?=$user['cargo_nome']; ?></div>
								<div class="desc">Setor: <?=$user['setor_nome']; ?></div>
								<div class="social-media">
									<a class="btn btn-info btn-twitter btn-sm btn-link" href="#"> 
										<span class="btn-label just-icon"><i class="flaticon-twitter"></i> </span>
									</a>
									<a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
										<span class="btn-label just-icon"><i class="flaticon-google-plus"></i> </span> 
									</a>
									<a class="btn btn-primary btn-sm btn-link" rel="publisher" href="#"> 
										<span class="btn-label just-icon"><i class="flaticon-facebook"></i> </span> 
									</a>
									<a class="btn btn-danger btn-sm btn-link" rel="publisher" href="#"> 
										<span class="btn-label just-icon"><i class="flaticon-dribbble"></i> </span> 
									</a>
								</div>
							</div>
						</div>
						<!--
						<div class="card-footer">
							<div class="row user-stats text-center">
								<div class="col">
									<div class="number">125</div>
									<div class="title">Post</div>
								</div>
								<div class="col">
									<div class="number">25K</div>
									<div class="title">Followers</div>
								</div>
								<div class="col">
									<div class="number">134</div>
									<div class="title">Following</div>
								</div>
							</div>
						</div>
						--->

						<div class="modal fade change-folder" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<form action="<?=$app->controller('change-folder'); ?>" method="post" enctype="multipart/form-data">
									<div class="modal-header">
										<h5 class="modal-title">Modificar Capa</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h4>Escolha uma das opções de entrada</h4>

										<div class="form-group">
											<label>Link da imagem</label>
											<input type="text" class="form-control-lg form-control" name="imglink"  />
										</div>

										<h5 class="text-center">ou</h5>

										<div class="form-group">
											<label>Upload de Arquivo</label>
											<input type="file" class="form-control" name="imgfile">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> <b>Enviar</b></button>
									</div>
									</form>
								</div>
							</div>
						</div>

						<div class="modal fade change-avatar" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<form action="<?=$app->controller('change-avatar'); ?>" method="post" enctype="multipart/form-data">
									<div class="modal-header">
										<h5 class="modal-title">Modificar Avatar</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<h4>Escolha uma das opções de entrada</h4>

										<div class="form-group">
											<label>Link da imagem</label>
											<input type="text" class="form-control-lg form-control" name="linkimg"  />
										</div>

										<h5 class="text-center">ou</h5>

										<div class="form-group">
											<label>Upload de Arquivo</label>
											<input type="file" class="form-control" name="imgfile">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary"><i class="fa fa-send"></i> <b>Enviar</b></button>
									</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>