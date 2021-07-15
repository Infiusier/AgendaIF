F<?php
	$app = new Module();
	$user = Session::get();

	# Anthony Jefferson passou aqui... Vê se nao salva por cima, seu viado!!!
	$permissoes = explode(" - ", $user['usuario_funcoes']);

?>
<div class="sidebar" data-background-color="dark">	
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<div class="user">
				<div class="avatar-sm float-left mr-2">
					<img src="<?=Helper::avatar($user['usuario_avatar']); ?>" alt="..." class="avatar-img rounded-circle" style="border: 2px solid #666;">
				</div>
				<div class="info">
					<a href="javascript:void(0);">
						<span>
							<b><?=$user['usuario_nome']; ?></b>
							<span class="user-level"><?=$user['cargo_nome']; ?></span>
						</span>
					</a>
				</div>
			</div>
			<ul class="nav nav-warning">

				<?php if(in_array(1, $permissoes)): ?>
				<li class="nav-item">
					<a data-toggle="collapse" href="#catalog">
						<i class="fas fa-hamburger"></i>
						<p>Pratos/Lanches</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="catalog">
						<ul class="nav nav-collapse">
							<li>
								<a href="<?=$app->view('listar','pratos'); ?>">
									<span class="sub-item">Listar / Gerenciar </span>
								</a>
							</li>

							
							
						</ul>
					</div>
				</li>
				<?php endif; ?>

				<?php if(in_array(1, $permissoes)): ?>
				<li class="nav-item">
					<a data-toggle="collapse" href="#menu-invoiced">
						<i class="fas fa-file-invoice"></i>
						<p>Cardapio da Semana</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="menu-invoiced">
						<ul class="nav nav-collapse">
							<li>
								<a href="<?=$app->view('listar','cardapio'); ?>">
									<span class="sub-item">Listar/Gerenciar</span>
								</a>
							</li>
							
						</ul>
					</div>
				</li>
				<?php endif; ?>

				
				<?php if(in_array(4, $permissoes)): ?>
				<li class="nav-item">
					<a data-toggle="collapse" href="#system">
						<i class="fab fa-ubuntu"></i>
						<p>Sistema</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="system">
						<ul class="nav nav-collapse">
							<li>
								<a href="<?=$app->view('usuarios','sistema'); ?>">
									<span class="sub-item">Usuários</span>
								</a>
							</li>
							<li>
								<a href="<?=$app->view('cargos','sistema'); ?>">
									<span class="sub-item">Cargos</span>
								</a>
							</li>
							<li>
								<a href="<?=$app->view('setores','sistema'); ?>">
									<span class="sub-item">Setores</span>
								</a>
							</li>
							<li>
								<a href="<?=$app->view('configuracoes','sistema'); ?>">
									<span class="sub-item">Configurações</span>
								</a>
							</li>
							<li>
								<a href="<?=$app->view('auditoria','sistema'); ?>">
									<span class="sub-item">Auditoria</span>
								</a>
							</li>
							<li>
								<a href="<?=$app->view('notificacoes','sistema'); ?>">
									<span class="sub-item">Notificações</span>
								</a>
							</li>
							<li class="divider"></li>

						</ul>
					</div>
				</li>
				<?php endif; ?>
				




			</ul>
		</div>
	</div>
</div>