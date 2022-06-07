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
  <script src ="assets/js/jquery.min.js?appver=<?php echo funcoes::VERSAO_SISTEMA; ?>"></script>
  <link   href="assets/bootstrap/bootstrap.min.css?appver=<?php echo funcoes::VERSAO_SISTEMA; ?>" rel="stylesheet" type="text/css">
  <script src ="assets/bootstrap/bootstrap.min.js?appver=<?php echo funcoes::VERSAO_SISTEMA; ?>"></script>
  <script src ="assets/js/funcoes.js?appver=<?php echo funcoes::VERSAO_SISTEMA; ?>"></script>
  <link   href="assets/css/style-basic.css?appver=<?php echo funcoes::VERSAO_SISTEMA; ?>" rel="stylesheet" type="text/css">
  <link   href="assets/css/style-dinamic.css.php?appver=<?php echo funcoes::VERSAO_SISTEMA; ?>" rel="stylesheet" type="text/css">
</head>

<body id="dising" <?php funcoes::showBodyOnLoadJsFuncition($config); ?> >

<?php 
    funcoes::showTitleBar($config);
?>

<div id="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="<?php echo $config->interval; ?>">
    <?php 
    funcoes::showCarousel($listArquivos);
    ?>
  </div>
</div>

</body>
</html>