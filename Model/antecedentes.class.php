<?
    require_once("conexao.class.php");

    class Antecedentes extends BD{

        private $tabela = "antecedentes";

        function pegaAntecedentes (){
            $arrayAt = array();
            $result  = $this->fazQuery("SELECT strNome FROM ".$this->tabela.";");
            while($resultRow = mysql_fetch_array($result)){
                array_push($arrayAt,$resultRow["strNome"]);
            }
            return $arrayAt;
        }

        function listaDeAntecedentes($num=10){
            $array = $this->pegaAntecedentes();
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

    class antecedentesFicha extends BD{

        function atribuiPonto($pontos,$jogador,$antecedentes,$cronica) {
            $resultado1 = $this->pegaResultado($this->fazQuery("SELECT idantecedentes FROM atributos WHERE strNome = '".$antecedentes."'"));
            $resultado2 = $this->pegaResultado($this->fazQuery("SELECT idFicha FROM ficha WHERE strJogador = '".$jogador."'AND strCronica = '".$cronica."';"));
            $resultado3 = mysql_fetch_array($this->fazQuery("SELECT pontos FROM ficha_atributos WHERE idFicha = $resultado2 AND idAtributos = $resultado1 LIMIT 1;"));
            if($resultado3 == null){
                $this->fazQuery("INSERT INTO ficha_atributos VALUES(DEFAULT,$resultado2,$resultado1,$pontos,'$especializacao');");
            }else{
                $this->fazQuery("UPDATE ficha_atributos SET pontos = $pontos, strEspecializacao = '$especializacao' WHERE idFicha = $resultado2 AND idAtributos = $resultado1 LIMIT 1;");
            }
        }

        function pegaPonto($jogador,$antecedentes,$cronica){
            $resultado1 = $this->pegaResultado($this->fazQuery("SELECT idantecedentes FROM atributos WHERE strNome = '".$antecedentes."'"));
            $resultado2 = $this->pegaResultado($this->fazQuery("SELECT idFicha FROM ficha WHERE strJogador = '".$jogador."'AND strCronica = '".$cronica."';"));
            $resultado3 = $this->pegaResultado($this->fazQuery("SELECT pontos FROM ficha_atributos WHERE idFicha = $resultado2 AND idAtributos = $resultado1"));
            return $resultado3;
        }

        function pontuaAntecedentes($jogador,$pontos,$cronica,$antecedentes=null){
            if($antecedentes == null){
                $antecedentes = new Antecedentes();
                $num = count($antecedentes->pegaAtributos());
                $antecedentes = $antecedentes->listaDeantecedentes($num);
            }

            $arrayAt = explode(",", $antecedentes);
            $arrayPt = explode(",", $pontos);
            $i = 0;

            foreach($arrayPt as $intPontos=>$valor){
                $this->atribuiPonto($valor,$jogador,$arrayAt[$i],$cronica);
                $i++;
            }

        }

        function retornaPontosAntecedentes($jogador,$cronica){
            $antecedentes = new Antecedentes();
            $num = count($antecedentes->pegaAntecedentes());
            $arrayAt = explode(",", $antecedentes->listaDeAntecedentes($num));
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