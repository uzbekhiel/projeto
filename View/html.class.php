<?
    class Html{

        function pagina($tags){
            echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN'>";
            echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='pt-br'>";
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){echo $valor;continue;}
                    foreach($valor as $tags2=>$valor2){
                        echo $valor2;
                    }
                }
            }else{echo $tags;}
            echo "</html>";
        }//fim do método pagina

        function head($tags,$titulo){
            $arr = array();
            array_push($arr,"<head><meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"<title>".$titulo."</title>");
            array_push($arr,"</head>");
            return $arr;
        }//fim do método head

        function body($tags){
            $arr = array();
            array_push($arr,"<body>");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"</body>");
            return $arr;
        }//fim do método body

        function forms($tags,$nome="",$method = "post",$action="",$pulaLinha="",$pula="<br />"){
            $arr = array();
            array_push($arr,"<form method='$method' action='$action'>");
            if($nome){array_push($arr,"
					<fieldset>
						<legend>$nome</legend>");}

            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){
                        array_push($arr,$valor);
                        if(substr($valor,0,6) == "<label" && $pulaLinha == ""){
                            array_push($arr,$pulaLinha);
                        }else{
                            array_push($arr,$pula);
                        }
                        continue;
                    }
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                        if(substr($valor2,0,6) == "<label" && $pulaLinha == ""){
                            array_push($arr,$pulaLinha);
                        }else{
                            array_push($arr,$pula);
                        }
                    }
                }
            }else{
                array_push($arr,$tags);
                if(substr($tags,0,6) == "<label" && $pulaLinha == ""){
                    array_push($arr,$pulaLinha);
                }else{
                    array_push($arr,$pula);
                }
            }
            if($nome){array_push($arr,"</fieldset>");}
            array_push($arr,"</form>");

            return $arr;
        }//fim do método forms

        function input($type,$name,$id,$value=""){
            $ids = str_replace("ç","c",$id);
            $ids = str_replace("ú","u",$ids);
            $ids = str_replace("ã","a",$ids);

            if($type != "button" && $type != "submit"){
                return "<input type='$type' name='$name' id='$ids' value='$value' />";
            }else{
                return "<input type='$type' name='$name' id='$ids' value='$name' />";
            }
            if($type == "submit"){
                return "<input type='$type' name='$name' id='$ids' value='$name' />";
            }
        }//fim do método input

        function label($name,$class=""){
            $names = str_replace(" ","_",$name);
            $names = str_replace("ç","c",$names);
            $names = str_replace("ú","u",$names);
            $names = str_replace("ã","a",$names);
            return "<label for='$names' $class>$name: </label>";
        }//fim do método label

        function paragrafo($texto){
            return "<p class='paragrafo'>$texto</p>";
        }//fim do método paragrafo

        function div($tags,$class="",$id=""){
            $arr = array();
            $class = str_replace(" ","_",$class);
            array_push($arr,"<div class='$class' $id>");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"</div>");
            return $arr;
        }//fim do método div

        function navegacao($tags){
            $arr = array();
            array_push($arr,"<nav>");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"</nav>");
            return $arr;
        }//fim do método navegacao

        function header($tags){
            $arr = array();
            array_push($arr,"<header>");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"</header>");
            return $arr;
        }//fim do método header

        function titulos($content,$tipo){
            return "<$tipo>$content</$tipo>";
        }//fim do método titulos

        function link($src,$nome,$class=""){
            return "<a href='$src' $class>$nome</a>";
        }//fim do método link

        function lista($nomes){
            $arr = array();
            $nome = explode(",",$nomes);
            array_push($arr,"<ul>");
            for($i=0;$i<count($nome);$i++){
                $link = str_replace(" ","_",$nome[$i]);
                array_push($arr,"<li>".$this->link("index.php?pagina=".$link,$nome[$i])."</li>");
            }
            array_push($arr,"</ul>");

            return $arr;
        }

        function span($content,$id="",$class=""){
            return "<span $id $class>$content</span>";
        }

        function option($value,$content){
            return "<option value = '$value'>$content</option>";
        }

        function select($tags,$class="",$id=""){
            $arr = array();
            array_push($arr,"<select $class $id>");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"</select>");
            return $arr;
        }

        function optgroup($label,$tags){
            $arr = array();
            array_push($arr,"<optgroup label='$label'>");
            if(is_array($tags)){
                foreach($tags as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$tags);}
            array_push($arr,"</optgroup>");
            return $arr;
        }

    }//fim da classe html


?>