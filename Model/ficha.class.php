<?
    require_once("conexao.class.php");

    class Ficha extends BD {

        private $nome;
        private $jogador;
        private $cronica;
        private $experiencia;
        private $tabela = ficha;

    //Inicio dos setters
        function setNome($nome){$this->nome = $nome;}
        function setJogador($jogador){$this->jogador = $jogador;}
        function setCronica($cronica){$this->cronica = $cronica;}
        function setExperiencia($experiencia){$this->experiencia = $experiencia;}

    //fim dos setters
    //Inicio dos getters
        function getNome(){return $this->nome;}
        function getJogador(){return $this->jogador;}
        function getCronica(){return $this->cronica;}
        function getExperiencia(){return $this->experiencia;}

    //fim dos getters

        function pegaDadosFicha($id){
            $result = $this->fazQuery("SELECT * FROM ".$this->tabela." WHERE idFicha = ".$id.";");
            while($resultRow = mysql_fetch_array($result)){
                $this->nome = $resultRow["strPersonagem"];
                $this->jogador = $resultRow["strJogador"];
                $this->cronica = $resultRow["strCronica"];
                $this->experiencia = $resultRow["intExperiencia"];
            }
        }//fim do pegaDadosFicha

        function insereficha (){
            $this->fazQuery("INSERT INTO ".$this->tabela." VALUES(
            DEFAULT,'".$this->nome."', '".$this->jogador."', '".$this->cronica."', '".$this->experiencia."');");

        }//fim do insereFicha

        function excluiFicha($id){
            $this->fazQuery("DELETE FROM ".$this->tabela." WHERE idFicha = ".$id.";");
        }//fim do excluiFicha

        function atualizaFicha($id){
            $this->fazQuery("UPDATE ".$this->tabela." SET strPersonagem = '".$this->nome."'
            ,strJogador = '".$this->jogador."', strCronica = '".$this->cronica."'
            ,strExperiencia = '".$this->experiencia."' WHERE idFicha = ".$id.";");
        }//fim do alteraFicha

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

    }
?>