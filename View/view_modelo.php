<?
    require_once("../Model/Atributos.class.php");
    require_once("../Model/Habilidades.class.php");
    require_once("../Control/Acesso.class.php");
    require_once("../Control/paginaweb.class.php");
    require_once("../Control/include.php");
    require_once("scripts.class.php");


    $p = new PaginaWeb();
    $a = new Acesso();
    $j = new Javascript();
    $f = new Funcoes();

    //if($_GET){
//        switch($_GET["pagina"]){
//             case "inicial":
//                $arr = array();
//                $arr1 = array();
//

//                array_push($arr1,$j->tag("
//                                        $().ready(function(){
//                                            $('a').click(function(){
//                                                $.ajax({
//                                                   url: 'sair.php',
//                                                   success:function(){
//                                                        document.location = 'view_modelo.php';
//                                                   }
//                                                 });
//                                            });
//                                        });
//                                            "));
//                array_push($arr,$p->html->paragrafo("O Fabuloso Gerador de Lero-lero v2.0 � capaz de gerar qualquer
//                    quantidade de texto vazio e prolixo, ideal para engrossar uma tese de mestrado, impressionar
//                    seu chefe ou preparar discursos capazes de curar a ins�nia da plat�ia. Basta informar um t�tulo
//                    pomposo qualquer (nos moldes do que est� sugerido a� embaixo) e a quantidade de frases desejada.
//                    Voil�! Em dois nano-segundos voc� ter� um texto - ou mesmo um livro inteiro - pronto para impress�o.
//                    Ou, se preferir, fa�a copy/paste para um editor de texto para format�-lo mais sofisticadamente.
//                    Lembre-se: apar�ncia � tudo, conte�do � nada."));
//                array_push($arr,"<a href='#'>Logout</a>");
//                //print_r($_COOKIE);
//                $p->constroi($arr,$arr1,"Pagina");
//                break;
//        }
//    }
//    if(!$_GET){
//        if($_POST){
//            $a->validaLogin($_POST,"view_modelo.php?pagina=inicial");
//        }
//        //print_r($_COOKIE);
$p->constroi($p->formulario($p->usuario,"Login","","post","",""),"","Pagina");
//    }

          //$p->constroi($p->formulario($p->atributos,"atributos","","post","",""),"","Pagina");
          //$p->formulario($p->qualidades,"qualidades","","post","","","");
          
?>
