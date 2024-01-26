<?php
/**
 * Application menu builder
 *
 * @version    7.6
 * @package    app
 * @subpackage lib
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    https://adiantiframework.com.br/license-template
 */
class AdiantiMenuBuilder
{
    public static function parse($file, $theme)
    {
        $ini = parse_ini_file('app/config/application.ini', true);
        
        if (!in_array('SimpleXML', get_loaded_extensions()))
        {
            throw new Exception(_t('Extension not found: ^1', 'SimpleXML'));
        }
        
        switch ($theme)
        {
            case 'theme3-adminlte3':
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $xml = new SimpleXMLElement(file_get_contents($file));
                $menu = new TMenu(
                    $xml,
                    $callback,
                    1,
                    'nav nav-treeview has-treeview',
                    'nav-item',
                    'nav-link'
                    , function($item) use ($ini) {
                        $item->class = 'nav-item';
                        $item->setClassIcon('nav-icon');
                        $item->setClassLink('nav-link');
                        $item->setTagLabel('p');

                        if (empty($ini['general']['use_tabs']) && empty($ini['general']['use_mdi_windows'])) {
                            return $item;
                        }

                        $action = $item->getAction();

                        if (empty($action)) {
                            return $item;
                        }

                        $label   = $item->getLabel();
                        $action .= "#adianti_open_tab=1#adianti_tab_name={$label}";

                        $item->setAction($action);

                        return $item;
                    }
                    , function($menu) {
                        $position = count($menu->getChildren()) - 1;
                        $menu->get($position)->add(TElement::tag('i','',['class' => "right fas fa-angle-left"]));
                        return $menu;
                    }
                );

                $menu->{'id'}             = 'side-menu';
                $menu->{'role'}           = 'menu';
                $menu->{'class'}          = 'nav nav-pills nav-sidebar flex-column';
                $menu->{'data-widget'}    = 'treeview';
                $menu->{'data-accordion'} = 'false';
                $menu->show();

                $menu_string = ob_get_clean();
                return $menu_string;
                break;
            case 'theme3':
            case 'theme3_v4':
            case 'theme3_v5':
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $xml = new SimpleXMLElement(file_get_contents($file));

                $callbackItem = null;

                if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows'])) {
                    $callbackItem = function($item) {
                        $action = $item->getAction();

                        if (empty($action)) {
                            return $item;
                        }

                        $label   = $item->getLabel();
                        $action .= "#adianti_open_tab=1#adianti_tab_name={$label}";

                        $item->setAction($action);

                        return $item;
                    };
                }

                $menu = new TMenu($xml, $callback, 1, 'treeview-menu', 'treeview', '', $callbackItem);
                $menu->class = 'sidebar-menu';
                $menu->id    = 'side-menu';
                $menu->show();
                $menu_string = ob_get_clean();
                return $menu_string;
                break;
            default:
                ob_start();
                $callback = array('SystemPermission', 'checkPermission');
                $xml = new SimpleXMLElement(file_get_contents($file));

                $callbackItem = null;

                if (! empty($ini['general']['use_tabs']) || ! empty($ini['general']['use_mdi_windows'])) {
                    $callbackItem = function($item) {
                        $action = $item->getAction();

                        if (empty($action)) {
                            return $item;
                        }

                        $label   = $item->getLabel();
                        $action .= "#adianti_open_tab=1#adianti_tab_name={$label}";

                        $item->setAction($action);

                        return $item;
                    };
                }

                $menu = new TMenu($xml, $callback, 1, 'ml-menu', 'x', 'menu-toggle waves-effect waves-block', $callbackItem);
                
                $li = new TElement('li');
                $li->{'class'} = 'active';
                $menu->add($li);
                
                $li = new TElement('li');
                $li->add('MENU');
                $li->{'class'} = 'header';
                $menu->add($li);
                
                $menu->class = 'list';
                $menu->style = 'overflow: hidden; width: auto;';
                $menu->show();
                $menu_string = ob_get_clean();
                return $menu_string;
                break;
        }
    }
}