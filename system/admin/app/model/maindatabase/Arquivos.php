<?php

class Arquivos extends TRecord
{
    const TABLENAME  = 'arquivos';
    const PRIMARYKEY = 'idarquivo';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'dt_exclusao';
    const CREATEDAT  = 'dt_inclusao';
    const UPDATEDAT  = 'dt_alteracao';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nrordem');
        parent::addAttribute('stAtivo');
        parent::addAttribute('img_caminho');
        parent::addAttribute('dt_inicio');
        parent::addAttribute('dt_fim');
        parent::addAttribute('nmlogin_inclusao');
        parent::addAttribute('dt_inclusao');
        parent::addAttribute('nmlogin_alteracao');
        parent::addAttribute('dt_alteracao');
        parent::addAttribute('dt_exclusao');
            
    }   
}