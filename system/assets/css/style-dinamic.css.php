<?php
require_once '../lib/banco.class.php';
$banco = new banco(banco::DBMS_SQLITE);
$config = $banco->getConfig();

header("Content-type: text/css", true);
echo ':root {'.PHP_EOL;
echo '    --header_height:45px;'.PHP_EOL;
echo '}'.PHP_EOL;
echo '.header-login{'.PHP_EOL;
echo '    color:'.$config->color_name.';'.PHP_EOL;
echo '}'.PHP_EOL;
echo PHP_EOL;
echo '#app_header{'.PHP_EOL;
echo '    background-color:'.$config->title_bar_color.';'.PHP_EOL;
echo '}'.PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo '.videomidiatv{'.PHP_EOL;
echo '    display: block;'.PHP_EOL;
echo '    margin: auto auto;'.PHP_EOL;
if($config->show_title_bar == 'Y'){
    echo '    height: calc(100vh - var(--header_height) ) !important;'.PHP_EOL;
}else{
    echo '    height: 100vh !important;'.PHP_EOL;
}
echo '    max-height: 100% !important;'.PHP_EOL;
echo '}'.PHP_EOL;
echo PHP_EOL;
echo '.imgmidiatv{'.PHP_EOL;
echo '    margin: auto auto;'.PHP_EOL;
if($config->show_title_bar == 'Y'){
    echo '    height: calc(100vh - var(--header_height) ) !important;'.PHP_EOL;
}else{
    echo '    height: 100vh !important;'.PHP_EOL;
}
echo '    max-height: 100% !important;'.PHP_EOL;
echo '}'.PHP_EOL;