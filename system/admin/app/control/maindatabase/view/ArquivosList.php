<?php

class ArquivosList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    




    private static $primaryKey = 'idarquivo';
    private static $formName = 'form_ArquivosList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];


    // trait com onReload, onSearch, onDelete...
    use Adianti\Base\AdiantiStandardListTrait; 

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        $this->filter_criteria = new TCriteria;
        $this->setLimit(20);
        $this->setDatabase('maindatabase'); // define the database
        $this->setActiveRecord('Arquivos'); // define the Active Record        

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Lista de arquivos");
        $this->limit = 20;

        $idarquivo = new TEntry('idarquivo');
        $nrordem = new TSlider('nrordem');
        $stAtivo = new TRadioGroup('stAtivo');
        $dt_inicio = new TDateTime('dt_inicio');
        $dt_fim = new TDateTime('dt_fim');
        $nmlogin_inclusao = new TEntry('nmlogin_inclusao');
        $nmlogin_alteracao = new TEntry('nmlogin_alteracao');


        $nrordem->setRange(1, Constantes::ORDEM_MAX, 1);
        $stAtivo->addItems(Constantes::getArraySimNao());
        $stAtivo->setLayout('horizontal');
        $stAtivo->setBooleanMode();
        $dt_fim->setMask('dd/mm/yyyy hh:ii');
        $dt_inicio->setMask('dd/mm/yyyy hh:ii');

        $dt_fim->setDatabaseMask('yyyy-mm-dd hh:ii');
        $dt_inicio->setDatabaseMask('yyyy-mm-dd hh:ii');

        $nmlogin_inclusao->setMaxLength(300);
        $nmlogin_alteracao->setMaxLength(300);

        $dt_fim->setSize(150);
        $idarquivo->setSize(100);
        $dt_inicio->setSize(150);
        $nrordem->setSize('100%');
        $nmlogin_inclusao->setSize('100%');
        $nmlogin_alteracao->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$idarquivo],[new TLabel("Ordem:", null, '14px', null)],[$nrordem]);
        $row2 = $this->form->addFields([new TLabel("Ativo:", null, '14px', null)],[$stAtivo],[],[]);
        //$row3 = $this->form->addFields([new TLabel("Data inicio:", null, '14px', null)],[$dt_inicio],[new TLabel("Data fim:", null, '14px', null)],[$dt_fim]);
        $row4 = $this->form->addFields([new TLabel("Login inclusão:", null, '14px', null)],[$nmlogin_inclusao],[new TLabel("Login Alteração:", null, '14px', null)],[$nmlogin_alteracao]);

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Cadastrar", new TAction(['ArquivosForm', 'onShow']), 'fas:plus #69aa46');
        $this->btn_onshow = $btn_onshow;

        $btn_onclear = $this->form->addAction("Limpar", new TAction([$this, 'clear']), 'fas:eraser #F44336');
        $this->btn_onclear = $btn_onclear;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_idarquivo = new TDataGridColumn('idarquivo', "id", 'center' , '70px');
        $column_nrordem = new TDataGridColumn('nrordem', "Ordem", 'left');
        $column_stAtivo = new TDataGridColumn('stAtivo', "Ativo", 'left');
        $column_stAtivo->setTransformer(function($value, $object, $row){
            return Transforme::simNaoComLabel($value, $object, $row);
        });
        $column_img_caminho = new TDataGridColumn('img_caminho', "Img caminho", 'left');
        $column_img_caminho->setTransformer(function($value, $object, $row){
            return Transforme::gridImg($value, $object, $row);
        });        
        $column_dt_inicio = new TDataGridColumn('dt_inicio', "Dt inicio", 'left');
        $column_dt_inicio->setTransformer(function($value, $object, $row){
            return Transforme::gridDateTime($value, $object, $row);
        });        
        $column_dt_fim = new TDataGridColumn('dt_fim', "Dt fim", 'left');
        $column_dt_fim->setTransformer(function($value, $object, $row){
            return Transforme::gridDateTime($value, $object, $row);
        });        
        $column_nmlogin_inclusao = new TDataGridColumn('nmlogin_inclusao', "Login Inclusão", 'left');
        $column_nmlogin_inclusao->setTransformer(function($value, $object, $row){
            return Transforme::getLogin($value, $object, $row);
        });          
        $column_dt_inclusao = new TDataGridColumn('dt_inclusao', "Data Inclusão", 'left');
        $column_dt_inclusao->setTransformer(function($value, $object, $row){
            return Transforme::gridDateTime($value, $object, $row);
        });        
        $column_nmlogin_alteracao = new TDataGridColumn('nmlogin_alteracao', "Login Alteração", 'left');
        $column_nmlogin_alteracao->setTransformer(function($value, $object, $row){
            return Transforme::getLogin($value, $object, $row);
        });          
        $column_dt_alteracao = new TDataGridColumn('dt_alteracao', "Data Alteração", 'left');
        $column_dt_alteracao->setTransformer(function($value, $object, $row){
            return Transforme::gridDateTime($value, $object, $row);
        });

        $order_idarquivo = new TAction(array($this, 'onReload'));
        $order_idarquivo->setParameter('order', 'idarquivo');
        $column_idarquivo->setAction($order_idarquivo);
        $order_nrordem = new TAction(array($this, 'onReload'));
        $order_nrordem->setParameter('order', 'nrordem');
        $column_nrordem->setAction($order_nrordem);
        $order_dt_inicio = new TAction(array($this, 'onReload'));
        $order_dt_inicio->setParameter('order', 'dt_inicio');
        $column_dt_inicio->setAction($order_dt_inicio);
        $order_dt_fim = new TAction(array($this, 'onReload'));
        $order_dt_fim->setParameter('order', 'dt_fim');
        $column_dt_fim->setAction($order_dt_fim);
        $order_nmlogin_inclusao = new TAction(array($this, 'onReload'));
        $order_nmlogin_inclusao->setParameter('order', 'nmlogin_inclusao');
        $column_nmlogin_inclusao->setAction($order_nmlogin_inclusao);
        $order_dt_inclusao = new TAction(array($this, 'onReload'));
        $order_dt_inclusao->setParameter('order', 'dt_inclusao');
        $column_dt_inclusao->setAction($order_dt_inclusao);
        $order_nmlogin_alteracao = new TAction(array($this, 'onReload'));
        $order_nmlogin_alteracao->setParameter('order', 'nmlogin_alteracao');
        $column_nmlogin_alteracao->setAction($order_nmlogin_alteracao);
        $order_dt_alteracao = new TAction(array($this, 'onReload'));
        $order_dt_alteracao->setParameter('order', 'dt_alteracao');
        $column_dt_alteracao->setAction($order_dt_alteracao);



        $this->datagrid->addColumn($column_idarquivo);
        $this->datagrid->addColumn($column_nrordem);
        $this->datagrid->addColumn($column_stAtivo);
        $this->datagrid->addColumn($column_img_caminho);
        $this->datagrid->addColumn($column_dt_inicio);
        $this->datagrid->addColumn($column_dt_fim);
        $this->datagrid->addColumn($column_nmlogin_inclusao);
        $this->datagrid->addColumn($column_dt_inclusao);
        $this->datagrid->addColumn($column_nmlogin_alteracao);
        $this->datagrid->addColumn($column_dt_alteracao);

        $action_onEdit = new TDataGridAction(array('ArquivosForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onoff = Transforme::getDataGridActionTurnOnOff($this,self::$primaryKey);
        $this->datagrid->addAction($action_onoff);

        $action_onDelete = new TDataGridAction(array('ArquivosList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';
        $headerActions->style = 'background-color:#fff; justify-content: space-between;';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel->getBody()->insert(0, $headerActions);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['ArquivosList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['ArquivosList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['ArquivosList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['ArquivosList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Lista arquivos"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onTurnOnOff($param = null) 
    { 
        try
        {
            $key = $param['key'];
            // open a transaction with database
            TTransaction::open($this->database);
            $obj = Arquivos::find($key);
            if ($obj instanceof Arquivos) {
                $obj->stAtivo = $obj->stAtivo == 'S' ? 'N' : 'S';
                $obj->store();
            }
            TTransaction::close();
            $this->onReload( $param );
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }    

    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open($this->database);

                // instantiates object
                $object = new Arquivos($key, FALSE); 

                //Apagando arquivo
                $dir = dirname($object->img_caminho);
                unlink($object->img_caminho);
                rmdir($dir);

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->idarquivo) AND ( (is_scalar($data->idarquivo) AND $data->idarquivo !== '') OR (is_array($data->idarquivo) AND (!empty($data->idarquivo)) )) )
        {

            $filters[] = new TFilter('idarquivo', '=', $data->idarquivo);// create the filter 
        }

        if (isset($data->nrordem) AND ( (is_scalar($data->nrordem) AND $data->nrordem !== '') OR (is_array($data->nrordem) AND (!empty($data->nrordem)) )) )
        {

            $filters[] = new TFilter('nrordem', '=', $data->nrordem);// create the filter 
        }

        if (isset($data->stAtivo) AND ( (is_scalar($data->stAtivo) AND $data->stAtivo !== '') OR (is_array($data->stAtivo) AND (!empty($data->stAtivo)) )) )
        {

            $filters[] = new TFilter('stAtivo', '=', $data->stAtivo);// create the filter 
        }

        if (isset($data->dt_inicio) AND ( (is_scalar($data->dt_inicio) AND $data->dt_inicio !== '') OR (is_array($data->dt_inicio) AND (!empty($data->dt_inicio)) )) )
        {

            $filters[] = new TFilter('dt_inicio', '=', $data->dt_inicio);// create the filter 
        }

        if (isset($data->dt_fim) AND ( (is_scalar($data->dt_fim) AND $data->dt_fim !== '') OR (is_array($data->dt_fim) AND (!empty($data->dt_fim)) )) )
        {

            $filters[] = new TFilter('dt_fim', '=', $data->dt_fim);// create the filter 
        }

        if (isset($data->nmlogin_inclusao) AND ( (is_scalar($data->nmlogin_inclusao) AND $data->nmlogin_inclusao !== '') OR (is_array($data->nmlogin_inclusao) AND (!empty($data->nmlogin_inclusao)) )) )
        {

            $filters[] = new TFilter('nmlogin_inclusao', 'like', "%{$data->nmlogin_inclusao}%");// create the filter 
        }

        if (isset($data->nmlogin_alteracao) AND ( (is_scalar($data->nmlogin_alteracao) AND $data->nmlogin_alteracao !== '') OR (is_array($data->nmlogin_alteracao) AND (!empty($data->nmlogin_alteracao)) )) )
        {

            $filters[] = new TFilter('nmlogin_alteracao', 'like', "%{$data->nmlogin_alteracao}%");// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'maindatabase'
            TTransaction::open($this->database);

            // creates a repository for Arquivos
            $repository = new TRepository($this->activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idarquivo';    
            }

            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idarquivo}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onShow($param = null)
    {

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    /**
     * Clear filters
     */
    public function clear()
    {
        TSession::setValue(__CLASS__.'_selected_objects', null);
        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);        
        $this->clearFilters();
        $this->onReload();
    }     

}

