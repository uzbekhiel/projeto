<?
    require_once("conexao.class.php");

    class Habilidades extends BD{

        private $tabela = "habilidades";

        function pegaHabilidades ($tipo){
            $arrayAt = array();
            $result  = $this->fazQuery("SELECT strNome FROM ".$this->tabela." WHERE intTipo=".$tipo."");
            while($resultRow = mysql_fetch_array($result)){
                array_push($arrayAt,$resultRow["strNome"]);
            }
            return $arrayAt;
        }

        function listaDeHabilidades($tipo,$num=30){
            switch($tipo){
                case "Vampiro":
                    $type = 2;
                    break;
                default:
                    $type = 1;
                    break;
            }
            $array = $this->pegaHabilidades($type);
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
    }//fim da classe habilidades

    class HabilidadesFicha extends BD{

        function atribuiPonto($pontos,$jogador,$habilidade,$cronica,$especializacao="") {
            $resultado1 = $this->pegaResultado($this->fazQuery("SELECT idHabilidades FROM habilidades WHERE strNome = '".$habilidade."'"));
            $resultado2 = $this->pegaResultado($this->fazQuery("SELECT idFicha FROM ficha WHERE strJogador = '".$jogador."' AND strCronica = '".$cronica."';"));
            $resultado3 = mysql_fetch_array($this->fazQuery("SELECT pontos FROM ficha_habilidades WHERE idFicha = $resultado2 AND idHabilidades = $resultado1 LIMIT 1;"));
            if($resultado3 == null){
                $this->fazQuery("INSERT INTO ficha_habilidades VALUES(DEFAULT,$resultado2,$resultado1,$pontos,'$especializacao');");
            }else{
                $this->fazQuery("UPDATE ficha_habilidadess SET pontos = $pontos, strEspecializacao = '$especializacao' WHERE idFicha = $resultado2 AND idHabilidades = $resultado1 LIMIT 1;");
            }
        }

        function pegaPonto($jogador,$habilidade,$cronica){
            $resultado1 = $this->pegaResultado($this->fazQuery("SELECT idHabilidades FROM habilidades WHERE strNome = '".$habilidade."'"));
            $resultado2 = $this->pegaResultado($this->fazQuery("SELECT idFicha FROM ficha WHERE strJogador = '".$jogador."'AND strCronica = '".$cronica."';"));
            $resultado3 = $this->pegaResultado($this->fazQuery("SELECT pontos FROM ficha_habilidades WHERE idFicha = $resultado2 AND idHabilidades = $resultado1"));
            return $resultado3;
        }

        function pontuaHabilidades($jogador,$pontos,$cronica,$habilidades=null,$especializacao=""){
            if($habilidades==null){
                $habilidades = new Habilidades();
                $num = count($habilidades->pegaHabilidades());
                $habilidades = $habilidades->listaDeHabilidades($num);
            }

            $arrayAt = explode(",", $habilidades);
            $arrayPt = explode(",", $pontos);
            $arrayEsp = explode(",", $especializacao);
            $i = 0;

            foreach($arrayPt as $intPontos=>$valor){
                $this->atribuiPonto($valor,$jogador,$arrayAt[$i],$cronica,$arrayEsp[$i]);
                $i++;
            }
        }

        function retornaPontosHabilidades($jogador,$cronica){
            $habilidades = new Habilidades();
            $num = count($habilidades->pegaHabilidades());
            $arrayAt = explode(",", $habilidades->listaDeHabilidades($num));
            $arrayPts = array();
            foreach($arrayAt as $intPontos=>$valor){
                array_push($arrayPts, $this->pegaPonto($jogador,$valor,$cronica));
            }
            return $arrayPts;
        }

        function dadosTabela(){}

        function __destruct(){}

    }//fim da classe habilidadesficha
?>