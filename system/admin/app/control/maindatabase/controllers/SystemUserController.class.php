<?php
class SystemUserController
{
    private $dao = null;
    private static $database = 'permission';
    private static $activeRecord = 'SystemUser';
    //--------------------------------------------------------------------------------
    public static function findByIdUsario($idusuario) 
    {
        TTransaction::open(self::$database);
        $user = SystemUser::find($idusuario);
        TTransaction::close();
        return $user;
    }    
    //--------------------------------------------------------------------------------
    public static function getNomeUsuario($idusuario) 
    {
        $name = null;
        if( !empty($idusuario) ){
            $user = self::findByIdUsario($idusuario);
            $name = $user->name;
        }
        return $name;
    }

}
?>