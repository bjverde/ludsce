<?php

/**
 * Classe utilitária com funções auxiliares para exibição do carrossel e barra de títulos
 *
 * Fornece métodos estáticos para formatação de caminhos de arquivos, cálculo de tempo de refresh,
 * renderização de indicadores, slides de imagens/vídeos e barra de cabeçalho do player.
 *
 * @package Luds
 * @subpackage Lib
 */
class funcoes
{
    /**
     * Versão atual da aplicação/player
     *
     * @var string
     */
    const VERSAO_SISTEMA = "0.5";

    /**
     * Calcula o tempo total em segundos para recarga automática da página (slideshow completo)
     *
     * Retorna um tempo de segurança de 30 segundos caso não haja arquivos ativos na lista.
     *
     * @param int|float $timeMilliseconds Tempo de transição de cada slide em milissegundos
     * @param array<int, string> $listFiles Lista de arquivos/slides a serem exibidos
     * @return int Tempo total em segundos para atualização da página via meta-refresh
     */
    public static function getTotalTimeRefreshSlideShow($timeMilliseconds, $listFiles)
    {
        $cont = count($listFiles);
        if ($cont === 0) {
            return 30; // Tempo mínimo de segurança em segundos para buscar novas mídias
        }
        $intervalSeconds = max(1, (int)ceil($timeMilliseconds / 1000));
        return $cont * $intervalSeconds;
    }

    /**
     * Constrói a lista de caminhos relativos dos arquivos prefixando com o diretório 'admin/'
     *
     * @param array<int, object> $listArquivosBanco Lista de registros vindos do banco de dados com atributo img_caminho
     * @return array<int, string> Lista de caminhos relativos para acesso público aos arquivos
     */
    public static function recuperarListaArquivosComCaminho($listArquivosBanco)
    {
        $listArquivos = array();
        foreach ($listArquivosBanco as $indice => $objArquivo){
            $listArquivos[$indice]='admin/'.$objArquivo->img_caminho;
        }
        return $listArquivos;
    }

    /**
     * Renderiza o HTML dos indicadores (bolinhas/tracinhos de navegação) do carrossel Bootstrap
     *
     * @param array<int, string> $arrListaArquivos Lista com caminhos dos arquivos do carrossel
     * @return void
     */
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
    
    /**
     * Renderiza o container e os itens de slide (imagens ou vídeos HTML5) do carrossel Bootstrap
     *
     * Identifica arquivos com extensão .mp4 para renderizar a tag <video>, e as demais mídias como <img>.
     *
     * @param array<int, string> $arrListaArquivos Lista com caminhos dos arquivos a serem exibidos
     * @return void
     */
    public static function wrapper($arrListaArquivos)
    {
        echo '<!-- Wrapper for slides -->'.PHP_EOL;
        echo '      <div class="carousel-inner">'.PHP_EOL;
        foreach ($arrListaArquivos as $indice => $arquivo) {
            $class = ($indice === 0) ? 'item active' : 'item';
            echo '    <div class="'.$class.'">'.PHP_EOL;
            $ext = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
            $safeArquivo = htmlspecialchars($arquivo, ENT_QUOTES, 'UTF-8');
            if ($ext === 'mp4' || $ext === 'webm' || $ext === 'ogg') {
                echo '      <video class="videomidiatv" autoplay loop muted controls>'.PHP_EOL;
                echo '         <source src="'.$safeArquivo.'" type="video/'.$ext.'">'.PHP_EOL;
                echo '         Your browser does not support HTML video.'.PHP_EOL;
                echo '      </video>'.PHP_EOL;
            }else{
                echo '      <img src="'.$safeArquivo.'" class="imgmidiatv">'.PHP_EOL;
            }
            echo '    </div>'.PHP_EOL;
        }
        echo '      </div>'.PHP_EOL;
    }

    /**
     * Renderiza o slide padrão informando que nenhuma imagem foi cadastrada ou está ativa
     *
     * @return void
     */
    public static function semImg()
    {
        echo '      <div class="carousel-inner">'.PHP_EOL;
        echo '          <div class="item active">'.PHP_EOL;
        echo '          <h1>Nenhuma imagem informada !! </h1>'.PHP_EOL;
        echo '          </div>'.PHP_EOL;
        echo '      </div>'.PHP_EOL;
    }

    /**
     * Controla a exibição do carrossel de mídias
     *
     * Caso a lista esteja vazia, invoca semImg(); caso contrário, renderiza os indicadores e slides.
     *
     * @param array<int, string> $arrListaArquivos Lista com caminhos dos arquivos do carrossel
     * @return void
     */
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

    /**
     * Imprime o atributo onload do elemento <body> chamando a função JavaScript info()
     *
     * @param object $config Objeto com configurações do sistema (show_title_bar, show_clock)
     * @return void
     */
    public static function showBodyOnLoadJsFuncition($config)
    {
        $showTitleBar = htmlspecialchars($config->show_title_bar ?? 'N', ENT_QUOTES, 'UTF-8');
        $showClock    = htmlspecialchars($config->show_clock ?? 'N', ENT_QUOTES, 'UTF-8');
        echo 'onload="info(\''.$showTitleBar.'\',\''.$showClock.'\')"';
    }

    /**
     * Renderiza o HTML da logo na barra de títulos caso esteja configurada
     *
     * @param object $config Objeto com configurações do sistema (logo_file)
     * @return void
     */
    public static function showTitleBarLogo($config)
    {
        echo '          <div id="app_header_left">'.PHP_EOL;
        if( !empty($config->logo_file) ){
            $safeLogo = htmlspecialchars($config->logo_file, ENT_QUOTES, 'UTF-8');
            echo '              <img class="imglogo" src="admin/'.$safeLogo.'">'.PHP_EOL;
        }
        echo '          </div>'.PHP_EOL;
    }

    /**
     * Renderiza a barra de título superior completa (logo, título principal e relógio)
     *
     * A barra só é impressa se show_title_bar estiver configurado como 'Y'.
     *
     * @param object $config Objeto com configurações do sistema (show_title_bar, name_title, etc.)
     * @return void
     */
    public static function showTitleBar($config)
    {
        if( $config->show_title_bar == 'Y' ){
            echo '<div class="navbar-header header-login">'.PHP_EOL;
            echo '  <div id="app_header">'.PHP_EOL;
            echo '      <div id="app_header_fd5">'.PHP_EOL;
            self::showTitleBarLogo($config);
            echo '          <div id="app_header_title">'.PHP_EOL;
            echo '              <div id="app_header_title_main">'.PHP_EOL;
            echo htmlspecialchars($config->name_title ?? '', ENT_QUOTES, 'UTF-8').PHP_EOL;
            echo '              </div>'.PHP_EOL;
            echo '          </div>'.PHP_EOL;
            echo '          <div id="app_header_login">'.PHP_EOL;
            echo '              <div id="clock"></div>'.PHP_EOL;
            echo '              <span id="resolucao"></span>'.PHP_EOL;
            echo '          </div>'.PHP_EOL;
            echo '      </div>'.PHP_EOL;
            echo '  </div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
    }    
}

?>
