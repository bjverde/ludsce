<?php
/**
 * WelcomeView
 *
 * @version    7.6
 * @package    control
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    https://adiantiframework.com.br/license-template
 */
class WelcomeView extends TPage
{
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        $html1 = new THtmlRenderer('app/resources/system_welcome_en.html');
        $html2 = new THtmlRenderer('app/resources/system_welcome_pt.html');
        $html3 = new THtmlRenderer('app/resources/system_welcome_es.html');

        // replace the main section variables
        $html1->enableSection('main', array());
        $html2->enableSection('main', array());
        $html3->enableSection('main', array());
        
        $panel1 = new TPanelGroup('Welcome!');
        $panel1->add($html1);
        
        $panel2 = new TPanelGroup('Bem-vindo!');
        $panel2->add($html2);
		
        $panel3 = new TPanelGroup('Bienvenido!');
        $panel3->add($html3);
        
        $vbox = TVBox::pack($panel1, $panel2, $panel3);
        $vbox->style = 'display:block; width: 100%';
        
        // add the template to the page
        parent::add( $vbox );
    }
}
