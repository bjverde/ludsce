<?php
require_once 'assets/lib/banco.class.php';
require_once 'assets/lib/funcoes.class.php';

$banco = new banco(banco::DBMS_SQLITE);
$config = $banco->getConfig();
//var_dump($config);
$listArquivosBanco = $banco->getListArquivos();
$listArquivos = funcoes::recuperarListaArquivosComCaminho($listArquivosBanco);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="<?php echo funcoes::getTotalTimeRefreshSlideShow($config->interval, $listArquivos); ?>">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="admin/app/templates/theme3_v4/img/favicon.png"/>
  <title>LUDS</title>
  <script src="<?= funcoes::asset('assets/js/jquery.min.js') ?>"></script>
  <link   href="<?= funcoes::asset('assets/bootstrap/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
  <script src="<?= funcoes::asset('assets/bootstrap/bootstrap.min.js') ?>"></script>
  <script src="<?= funcoes::asset('assets/js/funcoes.js') ?>"></script>
  <link   href="<?= funcoes::asset('assets/css/style-basic.css') ?>" rel="stylesheet" type="text/css">
  <style>
    :root {
      --header_height: 45px;
      --header_bg: <?php echo htmlspecialchars($config->title_bar_color ?? '#b80c1f', ENT_QUOTES, 'UTF-8'); ?>;
      --header_color: <?php echo htmlspecialchars($config->color_name ?? '#ffffff', ENT_QUOTES, 'UTF-8'); ?>;
    }
    .header-login {
      color: var(--header_color) !important;
    }
    #app_header {
      background-color: var(--header_bg) !important;
    }
    .videomidiatv {
      display: block;
      margin: auto auto;
      height: <?php echo ($config->show_title_bar == 'Y') ? 'calc(100vh - var(--header_height))' : '100vh'; ?> !important;
      max-height: 100% !important;
    }
    .imgmidiatv {
      margin: auto auto;
      height: <?php echo ($config->show_title_bar == 'Y') ? 'calc(100vh - var(--header_height))' : '100vh'; ?> !important;
      max-height: 100% !important;
    }
  </style>
</head>

<body id="dising" <?php funcoes::showBodyOnLoadJsFuncition($config); ?> >

<?php 
    funcoes::showTitleBar($config);
?>

<div id="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="<?php echo (int)($config->interval ?? 5000); ?>">
    <?php 
    funcoes::showCarousel($listArquivos);
    ?>
  </div>
</div>

</body>
</html>