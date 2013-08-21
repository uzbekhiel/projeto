<?
    require_once("conexao.class.php");

    class Caracteristicas extends BD{

        private $tabela = "caracteristicas";

        function pegaCaracteristicas ($tipo){
            $arrayAt = array();
            $result  = $this->fazQuery("SELECT strNome FROM ".$this->tabela." WHERE intTipo = ".$tipo."");
            while($resultRow = mysql_fetch_array($result)){
                array_push($arrayAt,$resultRow["strNome"]);
            }
            return $arrayAt;
        }

        function listaDeCaracteristicas($tipo,$num=6){
            switch($tipo){
                case "Vampiro":
                    $type = 2;
                    break;
                default:
                    $type = 1;
                    break;
            }
            $array = $this->pegaCaracteristicas($type);
            $lista = $array[0];
            for($i=1;$i<$num;$i++){
                $lista = $lista.",".$array[$i];
            }
            return $lista;
        }

        function dadosTabela($nome=""){
            $arr = array();
            $i=0;
            while ($i < mysql_num_fields($this->fazQuery("SELECT * FROM ".$this->tabela.";"))) {
                $meta = mysql_fetch_field($this->fazQuery("SELECT * FROM ".$this->tabela.";"), $i);
                if($meta->name == $nome){return $meta;}
                array_push($arr,$meta);
                $i++;
            }
            return $arr;
        }

        function __destruct(){}
    }//fim da classe atributo

?>