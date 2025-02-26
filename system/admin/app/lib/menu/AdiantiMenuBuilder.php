<?php
class AdiantiMenuBuilder
{
    /**
     * Parse main menu and converts into HTML
     */
    public static function parse($file, $theme)
    {
        if (!extension_loaded('SimpleXML'))
        {
            throw new Exception(_t('Extension not found: ^1', 'SimpleXML'));
        }
        
        if (!file_exists($file))
        {
            throw new Exception(_t('File not found').': ' . $file);
        }
        
        switch ($theme)
        {
            case 'adminbs5':
            case 'adminbs5_t':
            case 'adminbs5_v2':
                $xml  = new SimpleXMLElement(file_get_contents($file));
                $menu = new TMenu($xml, null, 1, 'sidebar-dropdown list-unstyled collapse', 'sidebar-item', 'sidebar-link collapsed');
                $menu->class = 'sidebar-nav';
                $menu->id    = 'side-menu';

                ob_start();
                $menu->show();
                return ob_get_clean();
                break;
        }
    }
    
    /**
     *
     */
    public static function parseNavBar($file, $theme)
    {
        if (!extension_loaded('SimpleXML'))
        {
            throw new Exception(_t('Extension not found: ^1', 'SimpleXML'));
        }
        
        if (file_exists($file))
        {
            $xml = new SimpleXMLElement(file_get_contents($file));
            
            $output = '';
            foreach ($xml as $xmlElement)
            {
                $label  = null;
                $icon   = !empty( (string) $xmlElement-> icon ) ? (string) $xmlElement-> icon : null;
                $action_string = str_replace('#', '&', (string) $xmlElement-> action);
                
                if ((string) $xmlElement-> label)
                {
                    $label = (string) $xmlElement-> label;
                }
                if ((string) $xmlElement->attributes()-> label)
                {
                    $label = (string) $xmlElement->attributes()-> label;
                }
                
                if ($xmlElement->menu)
                {
                    $i = ($icon) ? new TImage($icon) : null;
                    $dropdown = new TDropDown($label, $i);
                    $dropdown->setButtonClass('dropdown-toggle btn superlight');
                    $dropdown->getButton()->style .= ';font-size:1rem;';
                    
                    if (!empty((string) $xmlElement-> mobile) && (string) $xmlElement-> mobile == 'N')
                    {
                        $dropdown->setButtonClass('dropdown-toggle btn superlight hide-mobile');
                    }
                    
                    foreach ($xmlElement->menu->menuitem as $menuItem)
                    {
                        $item_label  = (string) $menuItem->attributes()-> label;
                        $item_action = str_replace('#', '&', (string) $menuItem-> action);
                        $item_icon   = (string) $menuItem-> icon;
                        
                        if (self::checkMenuActionPermission($item_action))
                        {
                            if ($router = AdiantiCoreApplication::getRouter())
                            {
                                $action = '__adianti_load_page("'.$router("class={$item_action}", true) .'")';
                            }
                            else
                            {
                                $action = "__adianti_load_page('index.php?class={$item_action}')";
                            }
                            
                            $li = $dropdown->addAction($item_label, $action, $item_icon . ' gray');
                            
                            if (!empty((string) $menuItem-> mobile) && (string) $menuItem-> mobile == 'N')
                            {
                                $li->class .= " hide-mobile";
                            }
                        }
                    }
                    
                    if (count($dropdown->getItems()) >0)
                    {
                        $output .= $dropdown;
                    }
                }
                else
                {
                    $link = new TElement('a');
                    $link->generator = "adianti";
                    $link->class     = "btn superlight ";
                    $link->style     = "padding: 5px;";
                    
                    if (strpos($file, 'top') !== false)
                    {
                        $link->style .= ";font-size:1rem;";
                    }
                    
                    if (!empty((string) $xmlElement-> mobile) && (string) $xmlElement-> mobile == 'N')
                    {
                        $link->class .= " hide-mobile";
                    }
                    
                    if (!empty((string) $xmlElement-> title))
                    {
                        $link->title = (string) $xmlElement-> title;
                    }
                    
                    if ((substr($action_string,0,7) == 'http://') or (substr($action_string,0,8) == 'https://'))
                    {
                        $link->{'href'} = $action_string;
                        $link->{'target'} = '_blank';
                        $link->{'generator'} = '';
                    }
                    else
                    {
                        if ($router = AdiantiCoreApplication::getRouter())
                        {
                            $link->{'href'} = $router("class={$action_string}", true);
                        }
                        else
                        {
                            $link->{'href'} = "index.php?class={$action_string}";
                        }
                    }
                    
                    if ($icon)
                    {
                        $i = new TImage($icon);
                        $i->style = "color:gray;font-size:1.2rem;float: left;margin-top: 3px;";
                        $link->add($i);
                    }
                    
                    if ($label)
                    {
                        $link->add('&nbsp;'. $label);
                    }
                    
                    if ( (strpos($file, 'public') !== false) || (self::checkMenuActionPermission($action_string)) || 
                         (substr($action_string,0,7) == 'http://') || (substr($action_string,0,8) == 'https://') )
                    {
                        $output .= $link;
                    }
                }
            }
            
            return $output;
        }
        
        return '';
    }
    
    /**
     * Check menu item permission
     */
    private static function checkMenuActionPermission($action_string)
    {
        $permission_callback = self::CHECK_PERMISSION;
        
        parse_str('class='.$action_string, $parts);
        $className = $parts['class'];
        if (call_user_func($permission_callback, $className))
        {
            return true;
        }
        return false;
    }
}
