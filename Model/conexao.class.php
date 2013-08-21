<?
    abstract class  BD{
        private $strHost = "localhost";
        private $strLogin = "root";
        private $strSenha = "";
        private $strNomeBD = "rpg";
        private $conn;

        function __construct(){
            $this->conn = mysql_connect($this->strHost, $this->strLogin, $this->strSenha);
            mysql_select_db($this->strNomeBD, $this->conn);
            // echo "<br />Conexão Aberta<br />";
        }//fim do construtor

        function fazQuery($sql){
            $result = mysql_query($sql,$this->conn);
            return $result;
        }

        function pegaResultado($result){
            $resultado = mysql_result($result,0);
            return $resultado;
        }

        function erro ($result){
            if (!$result) {
                die('Could not query:' . mysql_error());
            }
        }

        abstract function dadosTabela();

        function __destruct(){
            mysql_close($this->conn);
            //echo "<br />Conexão Fechada<br />";
        }//fim do destrutor
    } //fim da classe
?>
