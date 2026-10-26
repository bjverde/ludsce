<?php

/**
 * Classe responsável pelo gerenciamento de conexão e consultas PDO ao banco de dados
 *
 * Suporta exclusivamente conexões nativas PDO para os SGBDs:
 * SQLite, MySQL, PostgreSQL, SQL Server, Oracle e Firebird.
 *
 * @package Luds
 * @subpackage Lib
 */
class banco
{
    const DBMS_FIREBIRD = 'ibase';
    const DBMS_MYSQL    = 'mysql';
    const DBMS_ORACLE   = 'oracle';
    const DBMS_POSTGRES = 'pgsql';
    const DBMS_SQLITE   = 'sqlite';
    const DBMS_SQLSERVER= 'sqlsrv';

    /**
     * Tipo de SGBD configurado na instância
     *
     * @var string|null
     */
    private $dbms = null;

    /**
     * Construtor da classe banco
     *
     * @param string $dbms Tipo de SGBD (ex: sqlite, mysql, pgsql, sqlsrv, oracle, ibase)
     * @throws InvalidArgumentException Se o DBMS informado não for suportado via PDO
     */
    public function __construct($dbms)    
    {
        $this->setDbms($dbms);
    }

    /**
     * Retorna a lista de tipos de SGBD suportados nativamente via PDO
     *
     * @return array<int, string> Lista com identificadores dos bancos suportados
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

    /**
     * Retorna o tipo de SGBD atualmente configurado
     *
     * @return string|null Identificador do SGBD configurado
     */
    public function getDbms()
    {
        return $this->dbms;
    }

    /**
     * Define o tipo de SGBD a ser utilizado, validando se é suportado via PDO
     *
     * @param string $dbms Identificador do SGBD (suporta aliases como firebird e fbird)
     * @return void
     * @throws InvalidArgumentException Se o tipo informado não for suportado via PDO
     */
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

    /**
     * Cria e retorna uma nova instância de conexão PDO de acordo com o SGBD configurado
     *
     * @param string|null $servidor Endereço do servidor/host de banco de dados
     * @param string $banco Nome da base de dados ou caminho do arquivo SQLite
     * @param string|null $usuario Usuário para autenticação no banco
     * @param string|null $senha Senha para autenticação no banco
     * @param int|string|null $porta Porta de conexão opcional
     * @return PDO Instância de conexão PDO configurada
     * @throws InvalidArgumentException Se o SGBD configurado não for suportado
     * @throws PDOException Se ocorrer erro ao instanciar a conexão PDO
     */
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

    /**
     * Retorna a conexão PDO com o banco de dados principal da aplicação
     *
     * @return PDO Conexão PDO configurada
     * @throws PDOException Se ocorrer erro ao conectar
     */
    public function getConnectDatabase()
    {
        $banco = __DIR__ . '/../database/maindatabase.db';
        $conn = $this->getPdoConnect(null, $banco, null, null);
        return $conn;
    }

    /**
     * Recupera as configurações visuais e operacionais do player
     *
     * @return object Registro de configuração (id = 1) contendo opções de barra de título, cores, intervalo, etc.
     * @throws PDOException Se ocorrer erro na execução da consulta SQL
     */
    public function getConfig()
    {
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

    /**
     * Recupera a lista de arquivos de mídia ativos e válidos para a data/hora atual
     *
     * Filtra apenas registros ativos (stAtivo = 'S'), não excluídos e dentro do período de vigência.
     *
     * @return array<int, object> Lista de objetos contendo os caminhos das mídias (img_caminho) ordenados por nrordem
     * @throws PDOException Se ocorrer erro na execução da consulta SQL
     */
    public function getListArquivos()
    {
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
