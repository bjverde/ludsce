<?php

class ArquivosForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'maindatabase';
    private static $activeRecord = 'Arquivos';
    private static $primaryKey = 'idarquivo';
    private static $formName = 'form_ArquivosForm';

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro");


        $idarquivo = new TEntry('idarquivo');
        $stAtivo = new TRadioGroup('stAtivo');
        $nrordem = new TSlider('nrordem');
        $dt_inicio = new TDateTime('dt_inicio');
        $dt_fim = new TDateTime('dt_fim');
        $img_caminho = new TFile('img_caminho');

        $stAtivo->addValidation("StAtivo", new TRequiredValidator()); 
        $nrordem->addValidation("Nrordem", new TRequiredValidator()); 
        $dt_inicio->addValidation("data hora fim", new TRequiredValidator()); 
        $dt_fim->addValidation("Data hora fim", new TRequiredValidator()); 
        $img_caminho->addValidation("Imagem / Vídeo", new TRequiredValidator()); 

        $idarquivo->setEditable(false);
        $stAtivo->addItems(Constantes::getArraySimNao());
        $stAtivo->setLayout('horizontal');
        $stAtivo->setBooleanMode();
        $stAtivo->setUseButton();
        $stAtivo->setValue('S');
        $nrordem->setRange(1, Constantes::ORDEM_MAX, 1);
        $dt_fim->setValue('31/12/2032 23:59');
        $img_caminho->enableFileHandling();
        $img_caminho->setAllowedExtensions(Constantes::getArrayExstensoesArquivos());
        $dt_fim->setMask('dd/mm/yyyy hh:ii');
        $dt_inicio->setMask('dd/mm/yyyy hh:ii');

        $dt_fim->setDatabaseMask('yyyy-mm-dd hh:ii');
        $dt_inicio->setDatabaseMask('yyyy-mm-dd hh:ii');

        $dt_fim->setSize(150);
        $idarquivo->setSize(100);
        $dt_inicio->setSize(150);
        $nrordem->setSize('100%');
        $img_caminho->setSize('100%');



        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null)],[$idarquivo],[],[]);
        $row2 = $this->form->addFields([new TLabel("Ativo:", '#ff0000', '14px', null)],[$stAtivo],[new TLabel("Ordem:", '#ff0000', '14px', null)],[$nrordem]);
        $row3 = $this->form->addFields([new TLabel("Data hora inicio:", '#ff0000', '14px', null)],[$dt_inicio],[new TLabel("Data hora fim:", '#ff0000', '14px', null)],[$dt_fim]);
        $row4 = $this->form->addFields([new TLabel("Imagem / Vídeo", '#FF0000', '14px', null)],[$img_caminho]);

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_voltar = $this->form->addAction("Voltar", new TAction(['ArquivosList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_voltar = $btn_voltar;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Cadastro"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Arquivos(); // create an empty object 

            $data = $this->form->getData(); // get form data as array

            $data->stAtivo = ($data->stAtivo == 1 ? 'S' : $data->stAtivo);
            if( empty($data->idarquivo) ){
                $data->nmlogin_inclusao = TSession::getValue('userid');
            }else{
                $data->nmlogin_alteracao = TSession::getValue('userid');
            }
            $object->fromArray( (array) $data); // load the object with data

            $img_caminho_dir = Constantes::IMG_PATH; 

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'img_caminho', $img_caminho_dir); 

            // get the generated {PRIMARY_KEY}
            $data->idarquivo = $object->idarquivo; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Arquivos($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    }
}