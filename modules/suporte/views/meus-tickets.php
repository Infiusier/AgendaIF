<?php
	$app = new Module();
?>
<div class="main-panel">
	<div class="container">
		<div class="page-inner">

			<div class="page-header">
				<h4 class="page-title">Suporte</h4>
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
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".new-user"><i class="fas fa-plus-circle"></i> <b>Novo Ticket</b></button>
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

			
		</div>
	</div>
</div>


<script type="text/javascript">
	$(function(){
		$("table").DataTable();
	})
</script>