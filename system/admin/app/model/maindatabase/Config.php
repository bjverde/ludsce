<?php

class Config extends TRecord
{
    const TABLENAME  = 'config';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('show_title_bar');
        parent::addAttribute('title_bar_color');
        parent::addAttribute('name_title');
        parent::addAttribute('color_name');
        parent::addAttribute('logo_file');
        parent::addAttribute('show_clock');
        parent::addAttribute('interval');
        parent::addAttribute('show_info');
    }   
}