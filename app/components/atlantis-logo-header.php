<?php 
	$app = new Module();
?>
<div class="logo-header position-fixed" data-background-color="dark">
	<a href="<?=$app->view('','pedidos'); ?>" class="logo text-white">
		<img src="<?=$app->index(); ?>/app/components/imgs/logo-josue.png" height="50" width="auto" alt="LOGO" class="navbar-brand"> <b>JOSUE <small>v1.1</small></b>
	</a>
	<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon">
			<i class="icon-menu"></i>
		</span>
	</button>
	<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
	<div class="nav-toggle">
		<button class="btn btn-toggle toggle-sidebar">
			<i class="icon-menu"></i>
		</button>
	</div>
</div>