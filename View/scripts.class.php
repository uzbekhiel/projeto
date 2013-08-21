<?
    class Javascript{

        /*Método que insere a tag de javascript*/
        function tag($content){
            $arr = array();
            array_push($arr,"<script type='text/javascript'>
                            //<!--");
            if(is_array($content)){
                foreach($content as $tags=>$valor){
                    if(!is_array($valor)){array_push($arr,$valor);continue;}
                    foreach($valor as $tags2=>$valor2){
                        array_push($arr,$valor2);
                    }
                }
            }else{array_push($arr,$content);}
            array_push($arr,"
            //--></script>");
            return $arr;
    	}//fim do método tag

    }
?>