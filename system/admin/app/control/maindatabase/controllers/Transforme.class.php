<?php
class Transforme
{
    public static function getDataGridActionDetalharSaidaView()
    {
        $action = new TDataGridAction(array('SaidasVeiculosViewForm', 'onView'));
        $action->setLabel('Detalhar Saída');
        $action->setImage('fas:search');
        $action->setParameter('id', '{id}');
        $action->setField('id');
        return $action;
    }

    public static function getDataGridActionTurnOnOff($class, $field)
    {
        $action = new TDataGridAction(array($class, 'onTurnOnOff'));
        $action->setButtonClass('btn btn-default');
        $action->setLabel('Ativar/Desativar');
        $action->setImage('fa:power-off orange');
        $action->setField($field);
        return $action;
    }

    public static function getDataGridActionOnDelete($class, $field)
    {
        $action = new TDataGridAction(array($class, 'onDelete'));
        $action->setUseButton(false);
        $action->setButtonClass('btn btn-default btn-sm');
        $action->setLabel("Excluir");
        $action->setImage('fas:trash-alt #dd5a43');
        $action->setField($field);
        return $action;
    }

    public static function getDataGridActionOnEdit($class, $field)
    {
        $action = new TDataGridAction(array($class, 'onEdit'));
        $action->setUseButton(false);
        $action->setButtonClass('btn btn-default btn-sm');
        $action->setLabel("Editar");
        $action->setImage('far:edit #478fca');
        $action->setField($field);
        return $action;
    }    

    public static function simNao($value)
    {
        if($value === true || $value == 't' || $value === 1 || $value == '1' || $value == 's' || $value == 'S' || $value == 'T'){
            return 'Sim';
        }
        return 'Não';
    }

    public static function simNaoComLabel($value, $object, $row)
    {
        $class = ($value=='N') ? 'danger' : 'success';
        $label = ($value=='N') ? _t('No') : _t('Yes');
        $div = new TElement('span');
        $div->class="label label-{$class}";
        $div->style="text-shadow:none; font-size:12px; font-weight:lighter";
        $div->add($label);
        return $div;
    }

    public static function celularWhatsApp($value, $object, $row)
    {
        if ($value)
        {
            $numeroLimpo = str_replace([' ','-','(',')'],['','','',''], $value);
            $msg  = 'A Visionet Fibra tem um super presente de Ano Novo para você!!!';
            $icon = "<i class='fab fa-whatsapp' aria-hidden='true'></i>";
            return "{$icon} <a target='newwindow' href='https://api.whatsapp.com/send?phone=55{$numeroLimpo}&text={$msg}'> {$value} </a>";
        }
        return $value;
    }      

    public static function numeroBrasil($value)
    {
        if(!$value){
            $value = 0;
        }        
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }
        if(is_numeric($value)){
            return number_format($value, 2, ",", ".");
        }else{
            return $value;
        }
    }

    public static function date($value)
    {
        if( !empty(trim($value)) && $value!='0000-00-00'){
            try{
                $date = new DateTime($value);
                return $date->format('d/m/Y');
            }catch (Exception $e){
                return $value;
            }
        }
    }

    public static function gridDate($value, $object, $row)
    {
        return  self::date($value);
    }

    public static function gridImg($value, $object, $row)
    {
        if (file_exists($value)){
            $arquivo = explode('.',$value);
            if( $arquivo[3]=='mp4' ){
                $value=Constantes::IMG_PATH.'../../icone_video.png';
            }
            $image = new TImage($value);
            $image->style = 'max-width: 100px';
            return $image;
        }
    }

    public static function dateTime($value)
    {
        if( !empty(trim($value)) && $value!='0000-00-00'){
            try{
                $date = new DateTime($value);
                return $date->format('d/m/Y H:i');
            }catch (Exception $e){
                return $value;
            }
        }
    }

    public static function gridDateTime($value, $object, $row)
    {
        return  self::dateTime($value);
    }
    public static function getLogin($value, $object, $row)
    {
        return  SystemUserController::getNomeUsuario($value);
    }     
}