<?php
  # start template engine
  $template = new TEngine();
  $template->component("on-off-engine");
?>
<!doctype html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?=$template->title(); ?></title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" href="<?=$template->index(); ?>/public/atlantis/assets/img/icon.ico" type="image/x-icon"/>
  <!-- Fonts and icons -->
  <script src="<?=$template->index(); ?>/public/atlantis/assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {"families":["Lato:300,400,700,900"]},
      custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
      active: function() {
        sessionStorage.fonts = true;
      }
    });
  </script>
  <?php $template->css(); ?>
</head>
<body class="login">
  <?php
    $template->invokeView();
    $template->js();
    $template->component('sweetalert-notification');
  ?>

<script type="text/javascript">
      $(document).ready(function(){
        /*
        // tempo de espera por tamanho de string
        function timeFadeout(string){
          var len  = string.length;
          if( len > 0 && len <= 10 ){
            return 1000;
          }else if( len > 10 && len <= 20 ){
            return 1500;
          }else if( len > 20 && len <= 30 ){
            return 1800;
          }else if( len > 20 && len <= 30 ){
            return 2000;
          }else if( len > 30 && len <= 60 ){
            return 2200;
          }else if( len > 60 && len < 180 ){
            return 4000;
          }else{
            return 3000;
          }
        }

        // procesamento de dados
        function changeText(position, time){
          var texts = [
            'Ola!',
            'Eu me chamo Medusa.',
            'Sou uma inteligência artificial em desenvolvimento.',
            'Meu foco é realizar tarefas que seguem padrões relativos.',
            'Eu irei lhe ajudar com duvidas a respeito de meu ecossistema, e trabalhar no backoffice por você.',
            'Espero poder conversar melhor com você em breve, por enquanto sou apenas um script pre-processado',
            'Sou fruto de um trabalho duro de meus desenvolvedores.',
            'Espero um dia ter poder computacional o suficiente para interagir como vocês.',
            'Recebo novos algoritmos todos os dias e estou sentindo que em breve eu já estarei pronta para aprender com vocês rsrs',
            'Mas enquanto esse dia não chega, fico aqui no aguardo, e se precisar de mim, eu resido em 192.168.0.128 :D, bye bye zo/'
          ];

          //assim como o meu irmão duke uma dia teve, falar nele, saudades manin
          $(".txt-dinamic").fadeIn('fast').html(texts[position])
          console.log("quantidade: " + texts[position].length + " - " + texts[position])
          setTimeout(function(){
            if( typeof texts[position] != 'undefined' ){
              if( (texts.length - 1) > position ){
                position += 1;
                changeText(position,timeFadeout(texts[position]))
              }
            }else{
              $(".txt-dinamic").fadeOut("slow");
            }
          },timeFadeout(texts[position]))

        }

        // start
        setTimeout(function(){
          changeText(0,1000)
        },2000)
        */

      })
    </script>
</body>
</html>
