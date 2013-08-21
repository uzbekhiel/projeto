<?
    require_once("conexao.class.php");

    class Atributos extends BD{

        private $tabela = "atributos";

        function pegaAtributos (){
            $arrayAt = array();
            $result  = $this->fazQuery("SELECT strNome FROM atributos");
            while($resultRow = mysql_fetch_array($result)){
                array_push($arrayAt,$resultRow["strNome"]);
            }
            return $arrayAt;
        }

        function listaDeAtributos($num=9){
            $array = $this->pegaAtributos();
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

    class AtributosFicha extends BD{

        function atribuiPonto($pontos,$jogador,$atributo,$cronica,$especializacao=" ") {
            $resultado1 = $this->pegaResultado($this->fazQuery("SELECT idAtributos FROM atributos WHERE strNome = '".$atributo."'"));
            $resultado2 = $this->pegaResultado($this->fazQuery("SELECT idFicha FROM ficha WHERE strJogador = '".$jogador."'AND strCronica = '".$cronica."';"));
            $resultado3 = mysql_fetch_array($this->fazQuery("SELECT pontos FROM ficha_atributos WHERE idFicha = $resultado2 AND idAtributos = $resultado1 LIMIT 1;"));
            if($resultado3 == null){
                $this->fazQuery("INSERT INTO ficha_atributos VALUES(DEFAULT,$resultado2,$resultado1,$pontos,'$especializacao');");
            }else{
                $this->fazQuery("UPDATE ficha_atributos SET pontos = $pontos, strEspecializacao = '$especializacao' WHERE idFicha = $resultado2 AND idAtributos = $resultado1 LIMIT 1;");
            }
        }

        function pegaPonto($jogador,$atributo,$cronica){
            $resultado1 = $this->pegaResultado($this->fazQuery("SELECT idAtributos FROM atributos WHERE strNome = '".$atributo."'"));
            $resultado2 = $this->pegaResultado($this->fazQuery("SELECT idFicha FROM ficha WHERE strJogador = '".$jogador."'AND strCronica = '".$cronica."';"));
            $resultado3 = $this->pegaResultado($this->fazQuery("SELECT pontos FROM ficha_atributos WHERE idFicha = $resultado2 AND idAtributos = $resultado1"));
            return $resultado3;
        }

        function pontuaAtributos($jogador,$pontos,$cronica,$atributos=null,$especializacao=""){
            if($atributos == null){
                $atributos = new Atributos();
                $num = count($atributos->pegaAtributos());
                $atributos = $atributos->listaDeAtributos($num);
            }

            $arrayAt = explode(",", $atributos);
            $arrayPt = explode(",", $pontos);
            $arrayEsp = explode(",", $especializacao);
            $i = 0;

            foreach($arrayPt as $intPontos=>$valor){
                $this->atribuiPonto($valor,$jogador,$arrayAt[$i],$cronica,$arrayEsp[$i]);
                $i++;
            }

        }

        function retornaPontosAtributos($jogador,$cronica){
            $atributos = new Atributos();
            $num = count($atributos->pegaAtributos());
            $arrayAt = explode(",", $atributos->listaDeAtributos($num));
            $arrayPts = array();
            foreach($arrayAt as $intPontos=>$valor){
                array_push($arrayPts, $this->pegaPonto($jogador,$valor,$cronica));
            }
            return $arrayPts;
        }

        function dadosTabela(){}

        function __destruct(){}
    }//fim da classe atributosficha
?>