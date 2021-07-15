<?php
  $app = new Module();

  $db = new DB();

  $offices = $db->select("vth_us_cargos",null,null,null);
  $sectors = $db->select("vth_us_setores",null,null,null);
  $accounts = $db->select("vth_contas",null,null,null);
  //$stores = $db->select("ped_pd_filiais",null,null,null);

?>
<div class="wrapper wrapper-login wrapper-login-full p-0">
    <div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-secondary-gradient" 
        style="
        /*background-image: url('https://comelite-cloud.com/wp-content/uploads/2016/08/electron-singularity-animated-gif.gif') !important; 
        background-size: 1000px  !important; 
        background-position: center !important; 
        background-repeat: no-repeat !important*/
        background-color: #000;
        "
        id="teste"
    >
    <h1 class="text-center font-weight-bold text-white txt-dinamic" style="text-shadow: 2px 1px 2px #333; padding-left: 200px; padding-right: 200px; font-size: 40px;"></h1>
    
    </div>
    <div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white" style="background-image: url('https://img.freepik.com/vetores-gratis/fundo-de-mosaico-geometrico-de-cor-cinza-abstrato_1055-3132.jpg?size=338&ext=jpg'); background-size: cover; background-position: center;">
      <div class="container container-login container-transparent animated fadeIn">
        <p class="text-center"><img src="<?=$app->index(); ?>/app/components/imgs/logo-josue.png" height="130" width="auto"></p>
        <div class="login-form">
          <form action="<?=$app->controller('login'); ?>" method="post">
            <div class="form-group">
              <label for="username" class="placeholder"><b>E-mail</b></label>
              <input style="box-shadow: 2px 1px 2px #ddd;" id="username" name="email" type="text" class="form-control form-control-lg" placeholder="E-mail de acesso" required>
            </div>
            <div class="form-group">
              <label for="password" class="placeholder"><b>Senha</b></label>
              <a href="<?=$app->view('esqueci-minha-senha'); ?>" class="link float-right text-dark">Esqueceu sua senha?</a>
              <div class="position-relative">
                <input style="box-shadow: 2px 1px 2px #ddd;" id="password" name="password" type="password" class="form-control form-control-lg" required>
                <div class="show-password">
                  <i class="icon-eye"></i>
                </div>
              </div>
            </div>
            <!--
            <div class="form-group">
              <label for="panel" class="placeholder"><b>Painél</b></label>
              <select style="box-shadow: 2px 1px 2px #ddd;" id="panel" name="panel" class="form-control form-control-lg" required>
                <?php foreach($accounts as $account): ?>
                <option value="<?=$account['id_conta']; ?>"><?=$account['conta_nome']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            -->
            <div class="form-group form-action-d-flex mb-3">
              <button type="submit" class="btn btn-dark btn-block float-right mt-3 mt-sm-0 fw-bold font-weight-bold">Entrar</button>
            </div>
          </form>
          <div class="login-account">
            <span class="msg">Ainda não possui uma conta? ?</span>
            <a href="#" id="" class="link">Solicite com o administrador</a>
          </div>
        </div>
      </div>

      <?php /*
      <div class="container container-signup container-transparent animated fadeIn" style="height: 700px; overflow: auto !important;">
        <h3 class="text-center">Solicitação de Acesso</h3>
        <div class="login-form">

          <form action="<?=$app->controller('request-access'); ?>" method="post">

          <div class="form-group">
            <label for="fullname" class="placeholder"><b>Nome Completo</b></label>
            <input  id="fullname" name="usuario_nome" type="text" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="email" class="placeholder"><b>E-mail</b></label>
            <input id="email" name="usuario_email" type="email" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Conta</label>
            <select class="form-control" name="conta_id" <?=(!$accounts)?'disabled':''; ?>>
              <?php if($accounts): foreach($accounts as $ct): ?>
                <option value="<?=$ct['id_conta']; ?>"><?=$ct['conta_nome']; ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Filial</label>
            <select class="form-control" name="filial_id" <?=(!$stores)?'disabled':''; ?>>
              <?php if($stores): foreach($stores as $st): ?>
                <option value="<?=$st['id_filial']; ?>"><?=$st['filial_nome']; ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Cargo/Função</label>
            <select class="form-control" name="cargo_id" <?=(!$offices)?'disabled':''; ?>>
              <?php if($offices): foreach($offices as $of): ?>
                <option value="<?=$of['id_cargo']; ?>"><?=$of['cargo_nome']; ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Setor/Departamento</label>
            <select class="form-control" name="setor_id" <?=(!$sectors)?'disabled':''; ?>>
              <?php if($sectors): foreach($sectors as $set): ?>
                <option value="<?=$set['id_setor']; ?>"><?=$set['setor_nome']; ?></option>
              <?php endforeach; endif; ?>
            </select>
          </div>

          <div class="row form-sub m-0">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="agree">
              <label class="custom-control-label" for="agree">Aceite os <a href="javascript:void(0);" data-toggle="collapse" data-target=".terms">termos de uso</a>.</label>
            </div>

          
          </div>

          <div class="row form-action">
            <div class="col-md-6">
              <a href="#" id="show-signin" class="btn btn-danger btn-link w-100 fw-bold">Cancelar</a>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-secondary w-100 fw-bold font-weight-bold">Solicitar</button>
            </div>
          </div>

          </form>

        </div>
      </div>*/?>
    </div>
  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vanta@0.5.21/dist/vanta.birds.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>

<?php $a = rand(0,100); ?>

<?php if($a >= 50){ ?>
  <script>
      VANTA.BIRDS({
        el: "#teste",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.00,
        minWidth: 200.00,
        scale: 1.00,
        scaleMobile: 1.00,
        separation: 35.00
      })
  </script>
<?php } else { ?>

  <script>
    VANTA.NET({
      el: "#teste",
      mouseControls: true,
      touchControls: true,
      gyroControls: false,
      minHeight: 200.00,
      minWidth: 200.00,
      scale: 1.00,
      scaleMobile: 1.00,
      color: 0x4c5dca
    })
  </script>
<?php } ?>