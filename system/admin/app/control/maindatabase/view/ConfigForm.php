<?php

class ConfigForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'maindatabase';
    private static $activeRecord = 'Config';
    private static $primaryKey = 'id';
    private static $formName = 'form_ConfigForm';

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
        $this->form->setFormTitle("Config");


        $id = new THidden('id');
        $show_title_bar = new TRadioGroup('show_title_bar');
        $title_bar_color = new TColor('title_bar_color');
        $name = new TEntry('name_title');
        $color_name = new TColor('color_name');
        $logo_file = new TFile('logo_file');
        $show_clock = new TRadioGroup('show_clock');
        $show_info = new TRadioGroup('show_info');
        $interval = new TNumeric('interval', '0', ',', '.' );

        $show_title_bar->addValidation("Show title bar", new TRequiredValidator()); 


        $show_info->addValidation("Show info", new TRequiredValidator()); 
        $interval->addValidation("Data interval", new TRequiredValidator()); 

        $logo_file->enableImageGallery('', 100);
        $logo_file->enableFileHandling();
        $show_info->addItems(Constantes::getArraySimNao());
        $show_clock->addItems(Constantes::getArraySimNao());
        $show_title_bar->addItems(Constantes::getArraySimNao());

        $show_info->setLayout('horizontal');
        $show_clock->setLayout('horizontal');
        $show_title_bar->setLayout('horizontal');

        $show_info->setUseButton();
        $show_clock->setUseButton();
        $show_title_bar->setUseButton();

        $show_info->setValue('N');
        $show_clock->setValue(Constantes::YES);
        $interval->setValue('5000');
        $show_title_bar->setValue(Constantes::YES);

        $id->setSize(200);
        $name->setSize('100%');
        $interval->setSize('100%');
        $logo_file->setSize('100%');
        //$show_info->setSize('100%');
        $color_name->setSize('100%');
        //$show_clock->setSize('100%');
        //$show_title_bar->setSize('100%');
        $title_bar_color->setSize('100%');



        $row1 = $this->form->addFields([$id],[]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addContent([new TFormSeparator("Title Bar", '#333', '18', '#eee')]);
        $row3 = $this->form->addFields([new TLabel("Show title bar:", '#ff0000', '14px', null, '100%'),$show_title_bar],[new TLabel("Title bar color:", '#ff0000', '14px', null, '100%'),$title_bar_color],[new TLabel("Name:", null, '14px', null, '100%'),$name],[new TLabel("Color name:", '#ff0000', '14px', null, '100%'),$color_name]);
        $row3->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row4 = $this->form->addFields([new TLabel("Logo file:", null, '14px', null)],[$logo_file],[new TLabel("Show clock:", '#FF0000', '14px', null, '100%')],[$show_clock]);
        $row5 = $this->form->addContent([new TFormSeparator("Geral", '#333', '18', '#eee')]);
        $row6 = $this->form->addFields([new TLabel("Show info:", '#FF0000', '14px', null, '100%'),$show_info],[new TLabel("Data interval (in milliseconds):", '#ff0000', '14px', null, '100%'),$interval]);
        $row6->layout = ['col-sm-3',' col-sm-3',' col-sm-6'];


        //------------ Eventos do Cliente ----------------
        $show_title_bar->setChangeAction( new TAction( array($this, 'onChangeRadio')) );
        self::onChangeRadio( array('show_title_bar'=>Constantes::YES) );

        //------------ SETANDO OS DADOS ----------------
        TTransaction::open(self::$database); // open a transaction
        $object = new Config(1);
        $this->form->setData($object); // fill the form 
        TTransaction::close(); // close the transaction 

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Básico","Config"]));
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
            $data = $this->form->getData(); // get form data as array
            if($data->show_title_bar == Constantes::YES){
                if( empty($data->title_bar_color) ){
                    throw new DomainException('Campo Title Bar é obrigatorio');
                }
                if( empty($data->color_name) ){
                    throw new DomainException('Campo Color Name é obrigatorio');
                }
                if( empty($data->show_clock) ){
                    throw new DomainException('Campo Show Clock é obrigatorio');
                }
            }
            
            $this->form->validate(); // validate form data
            $object = new Config(); // create an empty object 
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object 
            $this->saveFile($object, $data, 'logo_file', Constantes::IMG_PATH_LOGO);

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

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

                $object = new Config($key); // instantiates the Active Record 

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

    /**
     * on ChangeRadio change
     * @param $param Action parameters
     */
    public static function onChangeRadio($param)
    {
        if ($param['show_title_bar'] == Constantes::YES){
            TEntry::enableField(self::$formName, 'name_title');
            TColor::enableField(self::$formName, 'title_bar_color');
            TColor::enableField(self::$formName, 'color_name');
            TFile::enableField(self::$formName, 'logo_file');
            TRadioGroup::enableField(self::$formName, 'show_clock');
        } else {
            TEntry::disableField(self::$formName, 'name_title');
            TColor::disableField(self::$formName, 'title_bar_color');
            TColor::disableField(self::$formName, 'color_name');
            TFile::disableField(self::$formName, 'logo_file');
            TRadioGroup::disableField(self::$formName, 'show_clock');
        }
    }
}