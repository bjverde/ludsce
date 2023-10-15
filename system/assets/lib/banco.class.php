<?php

class banco
{
    const DBMS_ACCESS   = 'ACCESS';
    const DBMS_FIREBIRD = 'ibase';
    const DBMS_MYSQL    = 'mysql';
    const DBMS_ORACLE   = 'oracle';
    const DBMS_POSTGRES = 'pgsql';
    const DBMS_SQLITE   = 'sqlite';
    const DBMS_SQLSERVER= 'sqlsrv';

    private $dbms = null;

    public function __construct($dbms)    
    {
        $this->setDbms($dbms);
    }

    /**
     * Retorna um array com o tipo de SGBD e descrição
     *
     * @return array
     */
    public static function getListDBMS()
    {
        $list = array();
        $list[]=self::DBMS_MYSQL;
        $list[]=self::DBMS_POSTGRES;
        $list[]=self::DBMS_SQLITE;
        $list[]=self::DBMS_SQLSERVER;
        return $list;
    }

    public function getDbms()
    {
        return  $this->dbms;
    }
    public function setDbms($dbms)
    {
        $listType = self::getListDBMS();
        $inArray = in_array($dbms, $listType);
        if (!$inArray) {
            throw new InvalidArgumentException('Type DBMS is not value valid');
        }
        $this->dbms = $dbms;
    }

    public function getPdoConnect($servidor,$banco,$usuario,$senha){
        if($this->dbms==self::DBMS_SQLITE){
            $conn = new PDO('sqlite:'.$banco);
        }elseif($this->dbms==self::DBMS_SQLSERVER){
            $conn = new PDO('sqlsrv:Server='.$servidor.';Database='.$banco, $usuario, $senha);
        }elseif($this->dbms==self::DBMS_MYSQL){
            $conn = new PDO('sqlsrv:Server='.$servidor.';Database='.$banco, $usuario, $senha);             
        }
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        //$conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); //array simples
        $conn->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //array de Objeto
        return $conn;
    }

    public function getConnectDatabase(){
        $banco= __DIR__.'/../database/maindatabase.db';
        $conn = $this->getPdoConnect(null,$banco,null,null);
        return $conn;
    }

    public function getConfig(){
        $conn = $this->getConnectDatabase();

        $sql = "select show_title_bar
                      ,title_bar_color 
                      ,name_title
                      ,color_name
                      ,logo_file
                      ,show_clock
                      ,interval
                      ,show_info
                from config
                where id = 1";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();
        return $result[0];
    }

    public function getListArquivos(){
        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $dataHoraAtual = $dateTime->format('Y-m-d H:i:s');

        $conn = $this->getConnectDatabase();

        $sql = "select img_caminho from arquivos 
                where dt_exclusao is null
                  and stAtivo = 'S'
                  and dt_inicio <= '".$dataHoraAtual."'
                  and '".$dataHoraAtual."' <= dt_fim
                  order by nrordem";
        $sth = $conn->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll();

        return $result;
    }
}

?>
