<?php

class banco
{
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
     * Retorna um array com o tipo de SGBD e descrição suportados via PDO
     *
     * @return array
     */
    public static function getListDBMS()
    {
        return [
            self::DBMS_FIREBIRD,
            self::DBMS_MYSQL,
            self::DBMS_ORACLE,
            self::DBMS_POSTGRES,
            self::DBMS_SQLITE,
            self::DBMS_SQLSERVER,
        ];
    }

    public function getDbms()
    {
        return  $this->dbms;
    }

    public function setDbms($dbms)
    {
        if ($dbms === 'firebird' || $dbms === 'fbird') {
            $dbms = self::DBMS_FIREBIRD;
        }
        $listType = self::getListDBMS();
        $inArray = in_array($dbms, $listType);
        if (!$inArray) {
            throw new InvalidArgumentException("Tipo de DBMS '{$dbms}' não é suportado via PDO.");
        }
        $this->dbms = $dbms;
    }

    public function getPdoConnect($servidor, $banco, $usuario, $senha, $porta = null)
    {
        switch ($this->dbms) {
            case self::DBMS_SQLITE:
                $conn = new PDO('sqlite:' . $banco);
                break;
            case self::DBMS_MYSQL:
                $dsn = "mysql:host={$servidor};dbname={$banco};charset=utf8mb4";
                if (!empty($porta)) {
                    $dsn .= ";port={$porta}";
                }
                $conn = new PDO($dsn, $usuario, $senha);
                break;
            case self::DBMS_POSTGRES:
                $dsn = "pgsql:host={$servidor};dbname={$banco}";
                if (!empty($porta)) {
                    $dsn .= ";port={$porta}";
                }
                $conn = new PDO($dsn, $usuario, $senha);
                break;
            case self::DBMS_SQLSERVER:
                $serverPart = !empty($porta) ? "{$servidor},{$porta}" : $servidor;
                $conn = new PDO("sqlsrv:Server={$serverPart};Database={$banco}", $usuario, $senha);
                break;
            case self::DBMS_ORACLE:
                $port = !empty($porta) ? $porta : '1521';
                $conn = new PDO("oci:dbname={$servidor}:{$port}/{$banco};charset=UTF8", $usuario, $senha);
                break;
            case self::DBMS_FIREBIRD:
                $dbString = empty($porta) ? "{$servidor}:{$banco}" : "{$servidor}/{$porta}:{$banco}";
                $conn = new PDO("firebird:dbname={$dbString};charset=UTF8", $usuario, $senha);
                break;
            default:
                throw new InvalidArgumentException("DBMS não suportado via PDO: {$this->dbms}");
        }
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
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
