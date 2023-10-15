<?php

class funcoes
{
    const VERSAO_SISTEMA = "0.5";

    /**
     * Calculate the time to load everything
     *
     * @param int $timeMilliseconds
     * @param array $listFiles
     * @return int
     */
    public static function getTotalTimeRefreshSlideShow($timeMilliseconds, $listFiles)
    {
        $cont  = count( $listFiles );
        $total = $cont * ($timeMilliseconds/1000);
        return $total;
    }

    public static function recuperarListaArquivosComCaminho($listArquivosBanco)
    {
        $listArquivos = array();
        foreach ($listArquivosBanco as $indice => $objArquivo){
            $listArquivos[$indice]='admin/'.$objArquivo->img_caminho;
        }
        return $listArquivos;
    }

    public static function indicadores($arrListaArquivos)
    {
        $cont =  count( $arrListaArquivos );
        if ( $cont > 0 ) {
            echo '<!-- Indicators -->'.PHP_EOL;
            echo '<ol class="carousel-indicators">'.PHP_EOL;
            echo '  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>'.PHP_EOL;
            $indicador = 1;
            while ($cont-1>0){
                echo '  <li data-target="#myCarousel" data-slide-to="'.$indicador.'"></li>'.PHP_EOL;
                $cont--;
                $indicador++;
            }
            echo '</ol>'.PHP_EOL;
        }
    }
    
    public static function wrapper($arrListaArquivos)
    {
        echo '<!-- Wrapper for slides -->'.PHP_EOL;
        echo '      <div class="carousel-inner">'.PHP_EOL;
        foreach ($arrListaArquivos as $indice => $arquivo) {
            $class = 'item';
            if( $indice==0 ){
                $class = 'item active';
            }
            echo '    <div class="'.$class.'">'.PHP_EOL;
            $parteArquivo = explode('.',$arquivo);
            if(end($parteArquivo)=='mp4'){
                echo '      <video class="videomidiatv" autoplay loop muted controls>'.PHP_EOL;
                echo '         <source src="'.$arquivo.'" type="video/mp4">'.PHP_EOL;
                echo '         Your browser does not support HTML video.'.PHP_EOL;
                echo '      </video>'.PHP_EOL;
            }else{
                echo '      <img src="'.$arquivo.'" class="imgmidiatv">'.PHP_EOL;
            }
            echo '    </div>'.PHP_EOL;
        }
        echo '      </div>'.PHP_EOL;
    }

    public static function semImg()
    {
        echo '      <div class="carousel-inner">'.PHP_EOL;
        echo '          <div class="item active">'.PHP_EOL;
        echo '          <h1>Nenhuma imagem informada !! </h1>'.PHP_EOL;
        echo '          </div>'.PHP_EOL;
        echo '      </div>'.PHP_EOL;
    }

    public static function showCarousel($arrListaArquivos)
    {
        $cont =  count( $arrListaArquivos );
        if( $cont == 0 ){
            funcoes::semImg(); 
        }else{
            funcoes::indicadores($arrListaArquivos); 
            funcoes::wrapper($arrListaArquivos);
        }
    }

    public static function showBodyOnLoadJsFuncition($config)
    {
        echo 'onload="info(\''.$config->show_title_bar.'\',\''.$config->show_clock.'\')"';
    }

    public static function showTitleBarLogo($config)
    {
        echo '          <div id="app_header_left">'.PHP_EOL;
        if( !empty($config->logo_file) ){
            echo '              <img class="imglogo" src="admin/'.$config->logo_file.'">'.PHP_EOL;
        }
        echo '          </div>'.PHP_EOL;
    }

    public static function showTitleBar($config)
    {
        if( $config->show_title_bar == 'Y' ){
            echo '<div class="navbar-header header-login">'.PHP_EOL;
            echo '  <div id="app_header">'.PHP_EOL;
            echo '      <div id="app_header_fd5">'.PHP_EOL;
            self::showTitleBarLogo($config);
            echo '          <div id="app_header_title">'.PHP_EOL;
            echo '              <div id="app_header_title_main">'.PHP_EOL;
            echo $config->name_title.PHP_EOL;
            echo '              </div>'.PHP_EOL;
            echo '          </div>'.PHP_EOL;
            echo '          <div id="app_header_login">'.PHP_EOL;
            echo '              <div id="clock"></div>'.PHP_EOL;
            echo '              <spam id="resolucao"></spam>'.PHP_EOL;
            echo '          </div>'.PHP_EOL;
            echo '      </div>'.PHP_EOL;
            echo '  </div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
    }    
}

?>
