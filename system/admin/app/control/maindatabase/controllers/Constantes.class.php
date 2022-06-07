<?php
class Constantes
{
    const MAX = 4000;
    const ORDEM_MAX = 30;
    const IMG_PATH = '../assets/img/ds';
    const IMG_PATH_LOGO = '../assets/img/logo';
    const YES = 'Y';

    public function __construct()
    {        
    }

    public static function getArraySimNao(){
        return [self::YES=>'Sim','N'=>'Não'];
    }

    public static function getArrayExstensoesArquivos(){
        return ['png','jpg','jpeg','mp4'];
    }
}