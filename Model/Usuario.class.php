<?
    require_once("conexao.class.php");

    class Usuario extends BD {

        private $jogador;
        private $senha;
        private $email;
        private $tabela = usuario;

    //Inicio dos setters
        function setJogador($jogador){$this->jogador = $jogador;}
        function setSenha($senha){$this->senha = $senha;}
        function setEmail($email){$this->email = $email;}
    //fim dos setters
    //Inicio dos getters
        function getJogador(){return $this->jogador;}
        function getSenha(){return $this->senha;}
        function getEmail(){return $this->email;}
    //fim dos getters

        function pegaDadosUsuario($valor,$coluna="idUsuario"){
            $result = $this->fazQuery("SELECT * FROM ".$this->tabela." WHERE ".$coluna." = '".$valor."';");
            while($resultRow = mysql_fetch_array($result)){
                $this->jogador = $resultRow["strJogador"];
                $this->senha = $resultRow["strSenha"];
                $this->email = $resultRow["strEmail"];
            }
        }//fim do pegaDadosFicha

        function insereUsuario (){
            $this->fazQuery("INSERT INTO ".$this->tabela." VALUES(
            DEFAULT,'".$this->jogador."', MD5('".$this->senha."'), '".$this->email."');");

        }//fim do insereFicha

        function excluiUsuario($id){
            $this->fazQuery("DELETE FROM ".$this->tabela." WHERE idUsuario = ".$id.";");
        }//fim do excluiFicha

        function atualizaUsuario($id){
            $this->fazQuery("UPDATE ".$this->tabela." SET strJogador = '".$this->jogador."'
            ,strSenha = MD5('".$this->senha."'),strEmail = '".$this->email."'
            WHERE idUsuario = ".$id.";");
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

        function contaDadosUsuario($valor,$coluna="idUsuario"){
            $result = $this->fazQuery("SELECT COUNT(*) FROM ".$this->tabela." WHERE ".$coluna." = '".$valor."';");
            return $this->pegaResultado($result);
        }

        function __destruct(){}

    }
?>