<?php
  $template = new TEngine();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title><?=$template->title(); ?></title>
		<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
		<link rel="icon" href="<?=$template->index(); ?>/public/atlantis/assets/img/icon.ico" type="image/x-icon"/>
		<?php
			$template->css();
			$template->js();
		?>
	</head>
	<body data-background-color="bg2" index="<?=$template->index(); ?>">
		<div class="wrapper sidebar_minimize">
			<?php 
				$template->component('atlantis-logo-header');
				$template->component('atlantis-sidebar');

				$template->component('atlantis-navbar');

				$template->invokeView();
				//$template->component('atlantis-quick-sidebar');
				$template->component('sweetalert-notification');
			?>
		</div>
	</body>
</html>
