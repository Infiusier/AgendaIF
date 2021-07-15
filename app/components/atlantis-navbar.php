<?php
	$app = new Module();
	$modules =  $app->getModules();
	$user = Session::get();
?>
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

	<div class="container-fluid">
		
		<nav class="navbar navbar-line navbar-header-left navbar-expand-lg p-0  d-none d-lg-flex">

			<ul class="navbar-nav page-navigation page-navigation-info" style="margin-left: 60px; ">

				<?php 
					if(  Helper::adminPermission() ):

						$db = new DB();
						$accounts = $db->select("vth_contas",null,null,null);
				?>

				<li class="nav-item">

					<div class="input-group mb-3" style="margin-top: 15px; margin-left: 80px;">
						<div class="input-group-prepend">
							<label class="input-group-text" for="inputGroupSelect01">
								<img src="https://ifce.edu.br/prpi/documentos-1/semic/2018/logo-vertical-ifce.png/@@images/56f4d129-a7dc-49c6-a533-b2756eef5dca.png" height="30" width="auto">
							</label>
						</div>
						<select class="form-control" id="change-panel">
							<?php foreach($accounts as $account): ?>
							<option value="<?=$account['id_conta']; ?>" <?=($user['id_conta'] == $account['id_conta']) ? 'selected' : ''; ?>><?=$account['conta_nome']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>


					<script type="text/javascript">
						$(function() {
							$("#change-panel").change(function(){
								const request = $.post("<?=$app->index(); ?>/modules/sistema/controllers/change-panel.php",{id_conta: $(this).val()}).done(function(response){
									var response = $.parseJSON(response)
									if( response.error == false ){
										location.reload(); 
									}else{
										alert(response.message)
									}
								}).fail(function(err){
									console.log(err)
								})
							})
						})
					</script>

				</li>
				<?php 
					endif;
				?>

			</ul>
		</nav>
		<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
			<li class="nav-item dropdown hidden-caret">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
					<i class="fa fa-search"></i>
				</a>
				<ul class="dropdown-menu dropdown-search animated fadeIn">
					<form class="navbar-left navbar-form nav-search">
						<div class="input-group">
							<input type="text" placeholder="Search ..." class="form-control">
						</div>
					</form>
				</ul>
			</li>


			<li class="nav-item" >
				<a class="nav-link i-need-a-help" href="<?=$app->view('menu','ferramentas'); ?>" role="button">
					<i class="fa fa-wrench" aria-hidden="true"></i> <b>Ferramentas</b>
				</a>
			</li>
			
			<li class="nav-item dropdown hidden-caret content-notification" >
				<a class="nav-link dropdown-toggle btn-drop-notification" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-bell"></i>
					<span class="notification" hidden>4</span>
				</a>
			</li>

			<script type="text/javascript">

				$(function(){

					var index = $("body").attr("index")

					function loadNotifications(){
						var contentNotify = index + "/app/components/load/notification.php";
						$(".content-notification").load(contentNotify)
					}

					function ring(){
						var myaudio = new Audio(index + '/public/assets/mp3/alert.mp3');
						myaudio.play()
					}

					// motor de consultas + alerta sonoro contabilizado
					function checkNewNotifications(){
						var quantNotify = 0;
						var interv = setInterval(function(){
							var checkNotify  = $.post(index + "/modules/sistema/controllers/check-notifications.php").done(function(quant){
								//console.log(quant)
								if( quant != false ){
									if( quantNotify != quant ){
										ring()
										quantNotify = quant;
										loadNotifications();
										$(".notification").removeAttr("hidden").html(quant)
										$.post(index + "/modules/sistema/controllers/checked-beep-notification.php");
									}
								}else{
									if( parseInt( $(".notification").html() ) == 0 ){
										$(".notification").attr("hidden","hidden").html(0)
									}
								}
							}).fail(function(error){
								// pausando contador
								console.log(error)
								clearInterval(interv);
							})
						},3000)
					}

					// perssistencia de consultas
					checkNewNotifications()
					loadNotifications();

					// acao de carregamento
					$(".btn-drop-notification").click(function(){
						loadNotifications()
					})

				})

			</script>

			<li class="nav-item dropdown hidden-caret">
				<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
					<i class="fas fa-layer-group"></i> <b>Modulos</b>
				</a>
				<div class="dropdown-menu quick-actions animated fadeIn">
					<div class="quick-actions-header">
						<span class="title mb-1">Modulos</span>
					</div>
					<div class="quick-actions-scroll scrollbar-outer">
						<div class="quick-actions-items">
							<div class="row m-0">
								<?php foreach($modules as $md): ?>
								<a class="col-6 col-md-4 p-0 text-dark" href="#">
									<div class="quick-actions-item">
										<div class="avatar-item bg-dark rounded-circle">
											<i class="fas fa-layer-group"></i>
										</div>
										<span class="text font-weight-bold"><?=$md; ?></span>
									</div>
								</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</li>
			

			<li class="nav-item">
				<a href="javascript:void(0);" class="nav-link quick-sidebar-toggler" title="Lista os colaboradores do sistema e quem está online e offline">
					<i class="fa fa-user-circle"></i> <b>Colaboradores</b>
				</a>
			</li>
			<li class="nav-item dropdown hidden-caret">
				<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
					<div class="avatar-sm">
						<img src="<?=Helper::avatar($user['usuario_avatar']); ?>" alt="..." class="avatar-img rounded-circle">
					</div>
				</a>
				<ul class="dropdown-menu dropdown-user animated fadeIn">
					<div class="dropdown-user-scroll scrollbar-outer">
						<li>
							<div class="user-box">
								<div class="avatar-lg"><img src="<?=Helper::avatar($user['usuario_avatar']); ?>" alt="image profile" class="avatar-img rounded"></div>
								<div class="u-text">
									<h4><?=$user['usuario_nome']; ?> <b><?=$_SERVER['REMOTE_ADDR']; ?></b></h4>
									<p class="text-muted"><?=$user['cargo_nome']; ?></p><a href="<?=$app->view('perfil','sistema'); ?>" class="btn btn-xs btn-secondary btn-sm">Ver Perfil</a>
								</div>
							</div>
						</li>
						<li>
							<!--
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">My Profile</a>
							<a class="dropdown-item" href="#">My Balance</a>
							<a class="dropdown-item" href="#">Inbox</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#">Account Setting</a>
							
						-->
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?=$app->controller('logout','auth'); ?>">Sair</a>
						</li>
					</div>
				</ul>
			</li>
		</ul>
	</div>
</nav>
<br>
<div class="container">
	<!--
	<style type="text/css">
		@keyframes alert-custom {
		     0% { opacity: 1; }
		     50% { opacity: 0.5; }
		     100% { opacity: 0.8; }
		 }
		.alert-custom {
		   -webkit-animation: alert-custom .30s linear infinite;
		   -moz-animation: alert-custom .30s linear infinite;
		   -ms-animation: alert-custom .30s linear infinite;
		   -o-animation: alert-custom .30s linear infinite;
		   animation: alert-custom .30s linear infinite;
		}
	</style>
	-->
	<!--
	<div class="alert alert-primary alert-custom" role="alert">
		<strong>Novidade:</strong> Notificações de sistema,liberados, atualize a pagina para usar <i class="fas fa-check-circle"></i> 
		<p class="font-weight-bold">By: E.E.C</p>
	</div>
-->
</div>
