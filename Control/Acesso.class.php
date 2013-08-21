<?
    require_once("../Model/Usuario.class.php");
    require_once("funcoes.php");

    class Acesso extends Usuario {

        private $tabela = usuario;

        function validaLogin($_POST,$url){
            $arr = $this->dadosTabela("strEmail");
            $arr1 = $this->dadosTabela("strSenha");

            $email = $_POST["Email"];
            $senha = $_POST["Senha"];
            $manter = $_POST["Manter_Logado"];
            $erro = 0;
            if($manter){$assunto = "mantem,";}else{$assunto = "nao mantem,";}

            if($arr->not_null == 1 && $email == ""){$erro++;}
            if($arr->not_null == 1 && $senha == ""){$erro++;}
            if(!ereg("^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$", $email)){$erro++;}
            if($this->contaDadosUsuario($email,"strEmail") == 0){$erro++;}
            if($this->contaDadosUsuario(md5($senha),"strSenha") == 0){$erro++;}

            if($erro == 0){
                $assunto = $assunto.$email.",".md5($senha);
                setcookie('user',$assunto,time()+3600*24*30);
                $f = new Funcoes();
                $f->redrectTo($url);
            }else{echo "Email ou Senha errados ou inexistentes";}
        }

        function sair(){
               setcookie('user',"",time()-3600*24*30);
        }
    }
?>