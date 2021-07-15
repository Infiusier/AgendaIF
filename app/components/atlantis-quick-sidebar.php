<?php
	$app = new Module();

	$app->loadModels("sistema");

	$user = new User();

	# users
	$users = $user->get(null," order by setor_nome desc");
?>
<div class="quick-sidebar">
	<a href="#" class="close-quick-sidebar">
		<i class="flaticon-cross"></i>
	</a>
	<div class="quick-sidebar-wrapper">
		<div class="tab-content mt-3">
			<div class="tab-chat tab-pane fade show active" id="messages" role="tabpanel">
				<div class="messages-contact">
					<div class="quick-wrapper">
						<div class="quick-scroll scrollbar-outer">
							<div class="quick-content contact-content">
								
								<?php if( $users ): ?>
								<span class="category-title">Colaboradores em Atividade</span>
								
								<div class="contact-list">

									<?php
										foreach($users as $u):
											$activity = json_decode(file_get_contents($app->path()."/storage/system/activity-user.json"),true);
											if( isset($activity[$u["id_usuario"]]) and $activity[$u["id_usuario"]]["status"] == 1 ){
												$uStat["status"] = "Online";
												$uStat["color-status"] = "success font-weight-bold";
												$uStat["avatar"] = "avatar-online";
											}else{
												$uStat["status"] = "Offline";
												$uStat["color-status"] = "dark";
												$uStat["avatar"] = "avatar-offline";
											}

											$imgStore = '<img src="'.$u["filial_marca"].'" height="17" width="17" class="rounded-circle" />&nbsp;';

									?> 
									<div class="user">
										<a href="javascript:void(0);">
											<div class="avatar <?=$uStat['avatar']; ?>">
												<img src="<?=Helper::avatar($u['usuario_avatar']); ?>" alt="<?=$u["usuario_nome"]; ?>" class="avatar-img rounded-circle border border-white">
											</div>
											<div class="user-data2">
												<span class="name"><span class='badge badge-<?=$uStat["color-status"]; ?> font-weight-bold'><?=$uStat["status"]; ?></span> - <?=$u["usuario_nome"]; ?></span>
												<span class="status"><?=$imgStore . $u['filial_nome'] . " - " . $u['setor_nome']; ?></span>
											</div>
										</a>
									</div>
									<?php
										endforeach;
									?>

									<!--
									<div class="user">
										<a href="#">
											<div class="avatar avatar-online">
												<img src="<?=$app->index(); ?>/public/atlantis/assets/img/jm_denis.jpg" alt="..." class="avatar-img rounded-circle border border-white">
											</div>
											<div class="user-data2">
												<span class="name">Jimmy Denis</span>
												<span class="status">Online</span>
											</div>
										</a>
									</div>

									<div class="user">
										<a href="#">
											<div class="avatar avatar-offline">
												<img src="<?=$app->index(); ?>/public/atlantis/assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
											</div>
											<div class="user-data2">
												<span class="name">Chad</span>
												<span class="status">Active 2h ago</span>
											</div>
										</a>
									</div>
									-->
								</div>

								<?php else: ?>
								usuarios não encontrados
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<!--
				<div class="messages-wrapper">
					<div class="messages-title">
						<div class="user">
							<div class="avatar avatar-offline float-right ml-2">
								<img src="<?=$app->index(); ?>/public/atlantis/assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
							</div>
							<span class="name">Chad</span>
							<span class="last-active">Active 2h ago</span>
						</div>
						<button class="return">
							<i class="flaticon-left-arrow-3"></i>
						</button>
					</div>
					<div class="messages-body messages-scroll scrollbar-outer">
						<div class="message-content-wrapper">
							<div class="message message-in">
								<div class="avatar avatar-sm">
									<img src="<?=$app->index(); ?>/public/atlantis/assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
								</div>
								<div class="message-body">
									<div class="message-content">
										<div class="name">Chad</div>
										<div class="content">Hello, Rian</div>
									</div>
									<div class="date">12.31</div>
								</div>
							</div>
						</div>
						<div class="message-content-wrapper">
							<div class="message message-out">
								<div class="message-body">
									<div class="message-content">
										<div class="content">
											Hello, Chad
										</div>
									</div>
									<div class="message-content">
										<div class="content">
											What's up?
										</div>
									</div>
									<div class="date">12.35</div>
								</div>
							</div>
						</div>
						<div class="message-content-wrapper">
							<div class="message message-in">
								<div class="avatar avatar-sm">
									<img src="<?=$app->index(); ?>/public/atlantis/assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
								</div>
								<div class="message-body">
									<div class="message-content">
										<div class="name">Chad</div>
										<div class="content">
											Thanks
										</div>
									</div>
									<div class="message-content">
										<div class="content">
											When is the deadline of the project we are working on ?
										</div>
									</div>
									<div class="date">13.00</div>
								</div>
							</div>
						</div>
						<div class="message-content-wrapper">
							<div class="message message-out">
								<div class="message-body">
									<div class="message-content">
										<div class="content">
											The deadline is about 2 months away
										</div>
									</div>
									<div class="date">13.10</div>
								</div>
							</div>
						</div>
						<div class="message-content-wrapper">
							<div class="message message-in">
								<div class="avatar avatar-sm">
									<img src="<?=$app->index(); ?>/public/atlantis/assets/img/chadengle.jpg" alt="..." class="avatar-img rounded-circle border border-white">
								</div>
								<div class="message-body">
									<div class="message-content">
										<div class="name">Chad</div>
										<div class="content">
											Ok, Thanks !
										</div>
									</div>
									<div class="date">13.15</div>
								</div>
							</div>
						</div>
					</div>
					<div class="messages-form">
						<div class="messages-form-control">
							<input type="text" placeholder="Type here" class="form-control input-pill input-solid message-input">
						</div>
						<div class="messages-form-tool">
							<a href="#" class="attachment">
								<i class="flaticon-file"></i>
							</a>
						</div>
					</div>
				</div>
				-->
			</div>
		</div>
	</div>
</div>