<?php
require_once 'init.php';

$ini = AdiantiApplicationConfig::get();
$theme  = $ini['general']['theme'];
new TSession;

$content     = file_get_contents("app/templates/{$theme}/layout.html");
$menu_string = AdiantiMenuBuilder::parse('menu.xml', $theme);
$content     = ApplicationTranslator::translateTemplate($content);
$content     = str_replace('{LIBRARIES}', file_get_contents("app/templates/{$theme}/libraries.html"), $content);
$content     = str_replace('{class}', isset($_REQUEST['class']) ? $_REQUEST['class'] : '', $content);
$content     = str_replace('{template}', $theme, $content);
$content     = str_replace('{MENU}', $menu_string, $content);
$content     = str_replace('{MENUTOP}', AdiantiMenuBuilder::parseNavBar('menu-top-public.xml', $theme), $content);
$content     = str_replace('{MENUBOTTOM}', AdiantiMenuBuilder::parseNavBar('menu-bottom-public.xml', $theme), $content);
$content     = str_replace('{lang}', $ini['general']['language'], $content);
$content     = str_replace('{title}', $ini['general']['title'] ?? '', $content);
$content     = str_replace('{template_options}',  json_encode($ini['template'] ?? []), $content);
$content     = str_replace('{adianti_options}',  json_encode($ini['general']), $content);

//--------------- adminbs5_t -----------------------
$content     = str_replace('{system_name_sub}', $ini['general']['system_name_sub'] ?? '', $content);
$content     = str_replace('{login}','usuario.logado', $content); //Aqui informe seu metodo de login
//--------------- FIM adminbs5_t ------------------


$css         = TPage::getLoadedCSS();
$js          = TPage::getLoadedJS();
$content     = str_replace('{HEAD}', $css.$js, $content);

echo $content;

if (isset($_REQUEST['class']))
{
    $method = isset($_REQUEST['method']) ? $_REQUEST['method'] : NULL;
    AdiantiCoreApplication::loadPage($_REQUEST['class'], $method, $_REQUEST);
}
