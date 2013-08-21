<?
    require_once("include.php");

     class PaginaWeb {

        public $html;
        public $usuario;
        public $ficha;
        public $caracteristicas;
        public $atributos;
        public $habilidades;
        public $disciplinas;
        public $antecedentes;
        public $virtudes;
        public $qualidades;
        public $noticias;

        /*Método construtor da classe*/
        function __construct(){
            $this->html = new Html();
            $this->usuario = new Usuario();
            $this->ficha = new Ficha();
            $this->caracteristicas = new Caracteristicas();
            $this->atributos = new Atributos();
            $this->noticias = new Noticias();
            $this->disciplinas = new Disciplinas();
            $this->antecedentes = new Antecedentes();
            $this->virtudes = new Virtudes();
            $this->habilidades = new Habilidades();
            $this->qualidades = new qualidades();
            $this->qualidades->setTipo("fisicas");
            $this->qualidades->setTipo("mentais");
            $this->qualidades->setTipo("sociais");
            $this->qualidades->setTipo("sobrenaturais");
        }//fim do construtor

        /*Método que constroi a página web*/
        function constroi($tags,$tagHead="",$pagina=""){
            $arr = array();
            $arr1 = array();
            $arr2 = array();
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr1,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr1,$valor2);
                    }
                }
            }else{array_push($arr1,$tags);}
            if(is_array($tagHead)){
                foreach($tagHead as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr2,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr2,$valor2);
                    }
                }
            }else{array_push($arr2,$tagHead);}
            array_push($arr,$this->html->head($tagHead,$pagina));
            array_push($arr,$this->html->body($arr1));
            $this->html->pagina($arr);
        }//fim do método constroi

        /*Método para gerar inputs podendo ser vários de uma vez ou um d cada vez, dependendo da necessidade
        e dos parâmetros passados*/
        function geraInputs($types,$names,$num=0,$value=""){
            $name = explode(",",$names);
            $type = explode(",",$types);
            $arr1 = array();
            $i = 0;
            if($num == 0){
                foreach($name as $names=>$valor){
                    if(count($type) != 1){
                        if($type[$i] != "button" && $type[$i] != "submit" ){
                            array_push($arr1,$this->html->label(str_replace("_"," ",$valor)));
                        }
                        array_push($arr1,$this->html->input($type[$i],$valor,$valor,$value));
                    }else{
                        if($type[0] != "button" && $type[0] != "submit"){
                            array_push($arr1,$this->html->label(str_replace("_"," ",$valor)));
                        }
                        array_push($arr1,$this->html->input($type[0],$valor,$valor,$value));
                    }
                    $i++;
                }
            }else{
                for($i=0;$i<$num;$i++){
                    if(count($type) != 1){
                        if($type[$i] != "button" && $type[$i] != "submit"){
                            array_push($arr1,$this->html->label(str_replace("_"," ",$names)));
                        }
                        array_push($arr1,$this->html->input($type[$i],$names.$i,$names.$i,$value));
                    }else{
                        if($type[0] != "button" && $type[0] != "submit"){
                            array_push($arr1,$this->html->label(str_replace("_"," ",$names)));
                        }
                        array_push($arr1,$this->html->input($type[0],$names.$i,$names.$i,$value));
                    }
                }
            }
            return $arr1;
        }//fim do método geraInputs

        /*Método que gera formulários passando para ele o tipo de formulário a ser gerado e um objeto
        de onde ele vai pegar os dados*/
        function formulario($obj,$form="",$nome="",$method = "post",$action="",$pulaLinha="",$pula="<br />"){
            $arr = $obj->dadosTabela();
            $arr1 = array();
            $arr2 = array();
            $arr3 = array();
            $arr4 = array();
            $hab = "";
            $j = 0;
            foreach($arr as $nomes=>$valor){
                if($nomes != 0 ){
                    switch ($form){
                        case "Login":
                            if(substr($valor->name,3) == "Senha" || substr($valor->name,3) == "Password"){$senha = substr($valor->name,3);}
                            if(substr($valor->name,3) == "Email"){
                                array_push($arr1,$this->geraInputs("text",substr($valor->name,3)));
                                array_push($arr1,$this->geraInputs("password",$senha));
                                if(count($arr1[1]) == 2){
                                   array_push($arr1,$this->geraInputs("radio","Manter_Logado",0,"1"));
                                   array_push($arr1,$this->geraInputs("submit",$form));
                                }
                           }
                           break 1;
                        case "usuario":
                            if(substr($valor->name,3) == "Senha" ){
                                array_push($arr1,$this->geraInputs("password",substr($valor->name,3)));
                            }else{
                                array_push($arr1,$this->geraInputs("text",substr($valor->name,3)));
                                if(count($arr1[2]) == 2){array_push($arr1,$this->geraInputs("submit","Enviar"));}
                            }
                            break 1;
                        default:
                            break 1;
                    }
                }
            }
            return $this->html->forms($arr1,$nome,$method,$action,$pulaLinha,$pula);
        }//fim do método formulario

        function fichaStoryteller($tipo){
            //Primeira parte da ficha
            $arr = $this->ficha->dadosTabela();
            $arr1 = array(); $arr2 = array(); $arr3 = array(); $arr4 = array();
            $hab = ""; $j = 0;
            foreach($arr as $nomes=>$valor){
                if($nomes != 0 ){
                    array_push($arr2,$this->geraInputs("text",substr($arr[$nomes]->name,3)));
                    array_push($arr2,"<br />");
                    $j++;
                    if($j == 3){break;}
                }
            }
            array_push($arr3,$this->html->div($arr2,"fichaBasica"));
            foreach($arr2 as $valor){array_shift($arr2);}
            foreach($arr as $valor){array_shift($arr);}

            $arr = explode(",",$this->caracteristicas->listaDeCaracteristicas($tipo));
            for($i=0;$i<count($arr);$i++){
                 array_push($arr2,$this->geraInputs("text",$arr[$i]));
                 array_push($arr2,$this->geraInputs("text",$arr[$i+3]));
                 array_push($arr2,"<br />");
                 if($i==2){break;}
            }
            array_push($arr3,$this->html->div($arr2,"caracteristicas"));
            array_push($arr1,$this->html->div($arr3,"part1"));
            //fim da primeira parte da ficha

            foreach($arr as $valor){array_shift($arr);}
            foreach($arr2 as $valor){array_shift($arr2);}
            foreach($arr3 as $valor){array_shift($arr3);}
            foreach($arr4 as $valor){array_shift($arr4);}

            //Segunda parte da ficha
            array_push($arr,$this->html->div("","atributos"));

            $atrs = $this->atributos->listaDeAtributos();
            $atrs = explode(",",$atrs);
            for($i=0;$i<3;$i++){
               array_push($arr2,$this->html->label($atrs[$i],"class='atributos'"));
               array_push($arr2,$this->html->span("","id='spfc_1_$i'","class='spc'"));
               array_push($arr2,$this->html->span("","id='spf_2_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spf_3_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spf_4_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spf_5_$i'","class='spv'"));
               array_push($arr,$this->html->div($arr2,"".$atrs[$i].""));

               array_push($arr3,$this->html->label($atrs[$i+3],"class='atributos'"));
               array_push($arr3,$this->html->span("","id='spsc_1_$i'","class='spc'"));
               array_push($arr3,$this->html->span("","id='sps_2_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='sps_3_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='sps_4_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='sps_5_$i'","class='spv'"));
               array_push($arr,$this->html->div($arr3,"".$atrs[$i+3].""));

               array_push($arr4,$this->html->label($atrs[$i+6],"class='atributos'"));
               array_push($arr4,$this->html->span("","id='spmc_1_$i'","class='spc'"));
               array_push($arr4,$this->html->span("","id='spm_2_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spm_3_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spm_4_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spm_5_$i'","class='spv'"));
               array_push($arr,$this->html->div($arr4,"".$atrs[$i+6].""));

               array_push($arr,"<br />");
               foreach($arr2 as $valor){
                    array_shift($arr2);
                    array_shift($arr3);
                    array_shift($arr4);
               }
            }
            array_push($arr1,$this->html->div($arr,"part2"));
            //Fim da segunda parte

            foreach($arr as $valor){array_shift($arr);}
            foreach($arr2 as $valor){array_shift($arr2);}
            foreach($arr3 as $valor){array_shift($arr3);}
            foreach($arr4 as $valor){array_shift($arr4);}

            //Terceira parte da ficha
            array_push($arr,$this->html->div("","habilidades"));

            $habs = $this->habilidades->listaDeHabilidades($tipo);
            $habs = explode(",",$habs);
            for($i=0;$i<10;$i++){
                if($habs[$i+10] == "Empatia c/ Animais"){$hab = "Empatia2";}
               array_push($arr2,$this->html->label($habs[$i],"class='habilidades'"));
               array_push($arr2,$this->html->span("","id='spt_1_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spt_2_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spt_3_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spt_4_$i'","class='spv'"));
               array_push($arr2,$this->html->span("","id='spt_5_$i'","class='spv'"));
               array_push($arr,$this->html->div($arr2,"".$habs[$i].""));

               array_push($arr3,$this->html->label($habs[$i+10],"class='habilidades'"));
               array_push($arr3,$this->html->span("","id='spp_1_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='spp_2_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='spp_3_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='spp_4_$i'","class='spv'"));
               array_push($arr3,$this->html->span("","id='spp_5_$i'","class='spv'"));
               if($hab==""){array_push($arr,$this->html->div($arr3,"".$habs[$i+10].""));}
               else{array_push($arr,$this->html->div($arr3,"".$hab.""));}

               array_push($arr4,$this->html->label($habs[$i+20],"class='habilidades'"));
               array_push($arr4,$this->html->span("","id='spc_1_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spc_2_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spc_3_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spc_4_$i'","class='spv'"));
               array_push($arr4,$this->html->span("","id='spc_5_$i'","class='spv'"));
               array_push($arr,$this->html->div($arr4,"".$habs[$i+20].""));

               array_push($arr,"<br />");
               foreach($arr2 as $valor){
                    array_shift($arr2);
                    array_shift($arr3);
                    array_shift($arr4);
               }
               if($hab!=""){$hab = "";}
            }
            array_push($arr1,$this->html->div($arr,"part3"));
            //Fim da terceira parte

            foreach($arr as $valor){array_shift($arr);}
            foreach($arr2 as $valor){array_shift($arr2);}
            foreach($arr3 as $valor){array_shift($arr3);}
            foreach($arr4 as $valor){array_shift($arr4);}

            //Quarta parte da ficha
//            //antecedentes da ficha
//               $disc = $this->antecedentes->listaDeAntecedentes();
//               $disc = explode(",",$disc);
//               array_push($arr3,$this->html->option("0","Selecione um antecedente"));
//               for($j=0;$j<count($disc);$j++){
//                    array_push($arr3,$this->html->option("".($j+1)."","".$disc[$j].""));
//               }
//               for($i=0;$i<7;$i++){
//                   array_push($arr4,$this->html->select($arr3,"class=antecedentes"));
//                    array_push($arr4,$this->html->span("","id='spa_1_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spa_2_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spa_3_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spa_4_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spa_5_$i'","class='spv'"));
//                    array_push($arr2,$this->html->div($arr4,"antecedente_$i"));
//                    array_push($arr2,"<br />");
//                   foreach($arr4 as $valor){
//                        array_shift($arr4);
//                   }
//               }
//                array_push($arr1,$this->html->div($arr2,"antecedentes"));
//               foreach($arr2 as $valor){array_shift($arr2);}
//               foreach($arr3 as $valor){array_shift($arr3);}
//               foreach($arr4 as $valor){array_shift($arr4);}
//
//               //disciplinas da ficha
//               $disc = $this->disciplinas->listaDeDisciplinas();
//                $disc = explode(",",$disc);
//                array_push($arr3,$this->html->option("0","Selecione uma disciplina"));
//                for($j=0;$j<count($disc);$j++){
//                    array_push($arr3,$this->html->option("".($j+1)."","".$disc[$j].""));
//                }
//                for($i=0;$i<7;$i++){
//                    array_push($arr4,$this->html->select($arr3,"class=disciplinas"));
//                    array_push($arr4,$this->html->span("","id='spd_1_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spd_2_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spd_3_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spd_4_$i'","class='spv'"));
//                    array_push($arr4,$this->html->span("","id='spd_5_$i'","class='spv'"));
//                    array_push($arr2,$this->html->div($arr4,"disciplina_$i"));
//                    array_push($arr2,"<br />");
//                    foreach($arr4 as $valor){
//                        array_shift($arr4);
//                   }
//                }
//                array_push($arr1,$this->html->div($arr2,"disciplinas"));
//                foreach($arr2 as $valor){array_shift($arr2);}
//                foreach($arr3 as $valor){array_shift($arr3);}
//                foreach($arr4 as $valor){array_shift($arr4);}
//
//                //virtudes da ficha
//                $disc = $this->virtudes->listaDeVirtudes();
//                $disc = explode(",",$disc);
//                for($i=0;$i<count($disc);$i++){
//                    array_push($arr3,$this->html->label($disc[$i],"class=virtudes"));
//                    array_push($arr3,$this->html->span("","id='spv_1_$i'","class='spc'"));
//                    array_push($arr3,$this->html->span("","id='spv_2_$i'","class='spv'"));
//                    array_push($arr3,$this->html->span("","id='spv_3_$i'","class='spv'"));
//                    array_push($arr3,$this->html->span("","id='spv_4_$i'","class='spv'"));
//                    array_push($arr3,$this->html->span("","id='spv_5_$i'","class='spv'"));
//                    array_push($arr2,$this->html->div($arr3,"virtude_$i"));
//                    array_push($arr2,"<br />");
//                    foreach($arr3 as $valor){
//                        array_shift($arr3);
//                   }
//                }
//                array_push($arr1,$this->html->div($arr2,"virtudes"));
//                foreach($arr2 as $valor){array_shift($arr2);}
//                foreach($arr3 as $valor){array_shift($arr3);}
//                foreach($arr4 as $valor){array_shift($arr4);}
//
//                //qualidades da ficha
//                $j=0;
//                array_push($arr3,$this->html->option("0","Selecione uma qualidade"));
//                //qualidades fisicas
//                $this->qualidades->setTipo("fisicas");
//                $fis = $this->qualidades->pegaQualidades();
//                for($i=0;$i<count($fis[0]);$i++){
//                    array_push($arr2,$this->html->option("".($j+1)."","".$fis[0][$i]."(".$fis[1][$i].")"));
//                    $j++;
//                }
//                array_push($arr3,$this->html->optgroup("Físicas",$arr2));
//                foreach($arr2 as $valor){array_shift($arr2);}
//                //qualidades mentais
//                $this->qualidades->setTipo("mentais");
//                $fis = $this->qualidades->pegaQualidades();
//                for($i=0;$i<count($fis[0]);$i++){
//                    array_push($arr2,$this->html->option("".($j+1)."","".$fis[0][$i]."(".$fis[1][$i].")"));
//                    $j++;
//                }
//                array_push($arr3,$this->html->optgroup("Mentais",$arr2));
//                foreach($arr2 as $valor){array_shift($arr2);}
//                //qualidades sociais
//                $this->qualidades->setTipo("sociais");
//                $fis = $this->qualidades->pegaQualidades();
//                for($i=0;$i<count($fis[0]);$i++){
//                    array_push($arr2,$this->html->option("".($j+1)."","".$fis[0][$i]."(".$fis[1][$i].")"));
//                    $j++;
//                }
//                array_push($arr3,$this->html->optgroup("Sociais",$arr2));
//                foreach($arr2 as $valor){array_shift($arr2);}
//                //qualidades sobrenaturais
//                $this->qualidades->setTipo("sobrenaturais");
//                $fis = $this->qualidades->pegaQualidades();
//                for($i=0;$i<count($fis[0]);$i++){
//                    array_push($arr2,$this->html->option("".($j+1)."","".$fis[0][$i]."(".$fis[1][$i].")"));
//                    $j++;
//                }
//                array_push($arr3,$this->html->optgroup("Sobrenaturais",$arr2));
//
//                for($i=0;$i<11;$i++){array_push($arr4,$this->html->select($arr3,"class=qualidades")); array_push($arr4,"<br />");}
//                array_push($arr1,$this->html->div($arr4,"qualidades"));


            return $arr1;
        }//fim do método fichaStoryTeller
    }//fim da classe PaginaWeb
?>