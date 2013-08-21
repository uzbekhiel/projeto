<?
    require_once("conexao.class.php");

    class Qualidades extends BD{

        private $tabela = "qualidades_";
        private $tipo;

        function setTipo($tipo){$this->tipo = $tipo;}
        function getTipo(){return $this->tipo;}

        function pegaQualidades (){
            $arrayQua = array();
            $arrayPts = array();
            $array = array();
            $result  = $this->fazQuery("SELECT strNome,intPontos FROM ".$this->tabela.$this->tipo.";");
            while($resultRow = mysql_fetch_array($result)){
                array_push($arrayQua,$resultRow["strNome"]);
                array_push($arrayPts,$resultRow["intPontos"]);
            }
            array_push($array,$arrayQua);
            array_push($array,$arrayPts);
            return $array;
        }

        function dadosTabela($nome=""){
            $arr = array();
            $i=0;
            while ($i < mysql_num_fields($this->fazQuery("SELECT * FROM ".$this->tabela.$this->tipo.";"))) {
                $meta = mysql_fetch_field($this->fazQuery("SELECT * FROM ".$this->tabela.$this->tipo.";"), $i);
                if($meta->name == $nome){return $meta;}
                array_push($arr,$meta);
                $i++;
            }
            return $arr;
        }

        function __destruct(){}
    }//fim da classe atributo
?>