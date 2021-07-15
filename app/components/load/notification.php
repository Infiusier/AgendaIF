<?php


	require "../../../autoload.php";
	$app = new Module();
	$app->loadModels('sistema');
	$notify = new UserNotification();
	$all = $notify->getNotify();

	# notificações novas
	$notifyNew = 0;
	if($all):
	foreach($all as $n){
		if($n["notificacao_visualizado"] == 0){
			$notifyNew++;
		}
	}
	endif;

	$notifyNew = ($notifyNew > 9) ? "+9" : $notifyNew;
?>

<a class="nav-link dropdown-toggle btn-drop-notification" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	<i class="fa fa-bell"></i>
	<span class="notification" <?=($notifyNew==0) ? 'hidden' : ''; ?>><?=$notifyNew ?></span>
</a>
<ul class="dropdown-menu notif-box animated fadeIn" style="overflow: auto !important;" aria-labelledby="notifDropdown">
	<?php if( $notifyNew > 0 ): ?>
	<li>
		<div class="dropdown-title">Você possui <?=$notifyNew; ?> novas notificações</div>
	</li>
	<?php endif; ?>
	<li>
		<?php if($all): ?>
		<div class="notif-scroll scrollbar-outer">
			<div class="notif-center">
				<?php foreach($all as $not):
						if( $not["notificacao_avatar"] != "" ): ?>
							<a data-id="<?=($not['notificacao_visualizado'] == 0) ? $not['id_notificacao'] : 0; ?>" href="<?=$app->index(); ?>/<?=$not['notificacao_url']; ?>">
								<div class="notif-img"> 
									<img src="<?=$not['notificacao_avatar']; ?>" alt="Img Profile">
								</div>
								<div class="notif-content">
									<span class="block">
										<?=$not['notificacao_titulo']; ?>
									</span>
									<span class="time"><?=(date("Y-m-d",strtotime($not["notificacao_datacadastro"])) == date("Y-m-d")) ? "Hoje as " . date("H:i",strtotime($not["notificacao_datacadastro"])) : Helper::br_date($not["notificacao_datacadastro"]); ?></span> 
								</div>
							</a>
							<?php else: ?>
							<a data-id="<?=($not['notificacao_visualizado'] == 0) ? $not['id_notificacao'] : 0; ?>" href="<?=$app->index(); ?>/<?=$not['notificacao_url']; ?>">
								<div class="notif-icon notif-primary"> <i class="<?=$not["notificacao_icone"]; ?>"></i> </div>
								<div class="notif-content">
									<span class="block">
										<?=$not['notificacao_titulo']; ?>
									</span>
									<span class="time"><?=(date("Y-m-d",strtotime($not["notificacao_datacadastro"])) == date("Y-m-d")) ? "Hoje as " . date("H:i",strtotime($not["notificacao_datacadastro"])) : Helper::br_date($not["notificacao_datacadastro"]); ?></span> 
								</div>
							</a>
				<?php
						endif;
					endforeach; 
				?>
			</div>
		</div>
		<?php else: ?>
		<div class="notif-scroll scrollbar-outer">
			<div class="notif-center">
				<h4 class="text-center">Sem novidades ate aqui...</h4>
			</div>
		</div>
		<?php endif; ?>
	</li>
	<!--
	<li>
		<a class="see-all text-center font-weight-bold" href="javascript:void(0);">Ver todas (em dev...)<i class="fa fa-angle-right"></i> </a>
	</li>
-->
</ul>

<script type="text/javascript">
	$(function(){

		var index = $("body").attr("index")

		function loadNotifications(){
			var contentNotify = index + "/app/components/load/notification.php";
			$(".content-notification").load(contentNotify)
		}

		$(".notif-center > a").mouseover(function(){
			if( $(this).attr("data-id") != '0' ){
				var index = $("body").attr("index")
				$.post(index + "/modules/sistema/controllers/check-view-notification.php",{
					id_notificacao: $(this).attr("data-id")
				});
				loadNotifications()
			}
		})
	})
</script>
