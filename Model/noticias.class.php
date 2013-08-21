<?
    require_once("conexao.class.php");

    class Noticias extends BD {

        private $titulo;
        private $conteudo;
        private $tabela = noticias;

    //Inicio dos setters
        function setTitulo($titulo){$this->titulo = $titulo;}
        function setConteudo($conteudo){$this->conteudo = $conteudo;}
    //fim dos setters
    //Inicio dos getters
        function getTitulo(){return $this->titulo;}
        function getConteudo(){return $this->conteudo;}
    //fim dos getters

        function pegaDados(){
            $arr = array();
            $arr1 = array();
            $result = $this->fazQuery("SELECT * FROM ".$this->tabela.";");
            while($resultRow = mysql_fetch_array($result)){
                array_push($arr,$resultRow["strTitulo"]);
                array_push($arr1,$resultRow["strConteudo"]);
            }
            $this->titulo = $arr;
            $this->conteudo = $arr1;
        }//fim do pegaDados

        function insereUsuario (){
            $this->fazQuery("INSERT INTO ".$this->tabela." VALUES(
            DEFAULT,'".$this->titulo."','".$this->conteudo."');");

        }//fim do insereFicha

        function excluiUsuario($id){
            $this->fazQuery("DELETE FROM ".$this->tabela." WHERE idNoticias = ".$id.";");
        }//fim do excluiFicha

        function atualizaUsuario($id){
            $this->fazQuery("UPDATE ".$this->tabela." SET strTitulo = '".$this->titulo."'
            ,strConteudo = '".$this->conteudo."'
            WHERE idNoticias = ".$id.";");
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

        function contaDados($valor,$coluna="idNoticias"){
            $result = $this->fazQuery("SELECT COUNT(*) FROM ".$this->tabela." WHERE ".$coluna." = '".$valor."';");
            return $this->pegaResultado($result);
        }

        function __destruct(){}

    }
?>