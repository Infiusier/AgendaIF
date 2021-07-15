<?php
	$app = new Module();
	$db = new DB();
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">

			<div class="page-header">
				<h4 class="page-title">Auditorias</h4>
				<ul class="breadcrumbs">
					<li class="nav-home">
						<a href="#">
							<i class="flaticon-home"></i>
						</a>
					</li>
				</ul>
			</div>
			<?php
				$User = new User();
				$all = $User->get();
				if($all):
					echo '<ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons justify-content-center" id="pills-tab-with-icon" role="tablist">';
					foreach($all as $k => $v):
						$nameShort = explode(" ", $v["usuario_nome"]);
						$nameShort = $nameShort[0];
			?>
					<li class="nav-item">
						<a class="nav-link <?=($k == 0)?'active':''; ?>" id="pills-<?=$v['id_usuario']; ?>-tab-icon" data-toggle="pill" href="#pills-<?=$v['id_usuario']; ?>-icon" role="tab" aria-controls="pills-<?=$v['id_usuario']; ?>-icon" aria-selected="true">
							<img src="<?=Helper::avatar($v['usuario_avatar']); ?>" class="rounded-circle img-thumbnail" style="height: 60px; width: 60px;">
							<h4 class="text-center font-weight-bold" style="margin-top: 10px;"><?=$nameShort; ?></h4>
						</a>
					</li>
			<?php
					endforeach;
					echo '</ul>';
					echo '<div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">';
					foreach($all as $k2 => $v2):
			?>
						<div class="tab-pane fade show <?=($k2 == 0)?'active':''; ?>" id="pills-<?=$v2['id_usuario']; ?>-icon" role="tabpanel" aria-labelledby="pills-<?=$v2['id_usuario']; ?>-tab-icon">

						<?php
							# consulta de auditorias
							$audits = $db->select("vth_auditorias",null,['usuario_id' => $v2['id_usuario']], " order by auditoria_timestamp desc");
							if( $audits ):
						?>
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Ação</th>
									<th>Metodo</th>
									<th>IP</th>
									<th>S.O</th>
									<th>Data/Hora</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($audits as $aud):

										$server = json_decode($aud["auditoria_servidor"],true);
										preg_match('((?<=\().*?(?=;))',$server['HTTP_USER_AGENT'],$matches);
										$so =  $matches[0];
								?>
								<tr>
									<td><?=$aud['id_auditoria']; ?></td>
									<td><?=$server['REQUEST_URI']; ?></td>
									<td><?=$server['REQUEST_METHOD']; ?></td>
									<td><?=$server['REMOTE_ADDR']; ?></td>
									<td><?=$so; ?></td>
									<td><?=date('Y/m/d H:i:s',strtotime($aud['auditoria_timestamp'])); ?></td>
								</tr>
								<?php
									endforeach;
								?>
							</tbody>
						</table>
						<?php
							else:
						?>
						<h4>sem nada ainda</h4>
						<?php
							endif;
						?>

						</div>
			<?php
					endforeach;
					echo '</div>';
				endif;
			?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$('table').each(function(){
			$(this).DataTable();
		})
	})
</script>
