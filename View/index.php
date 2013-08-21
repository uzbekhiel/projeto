<?
    require("../Control/include.php");

    $p = new PaginaWeb();
    $a = new Acesso();
    $j = new Javascript();
    $arrBody = Array();
    $arrHead = Array();
    $arrConteudo = Array();
    $arrLogin = Array();
    $arrNoticias = Array();
    $arrFicha = Array();
    $lista = "Vampiro,Lobisomen,Fale Conosco";

    array_push($arrHead,"<link rel='stylesheet' type='text/css' href='./css/estilo.css' />");
    array_push($arrHead,"<script src='./js/jquery-1.3.2.js' type='text/javascript'></script>");
    array_push($arrHead,"<script src='./js/padrao.js' type='text/javascript'></script>");

    array_push($arrBody,$p->html->div("<img src='./css/256364g.gif' alt='logo' />","topo"));

    //array_push($arrLogin,$p->formulario($p->usuario,"Login","","post","",""));
    //array_push($arrConteudo,$p->html->div($arrLogin,"loginform"));
    array_push($arrConteudo,$p->html->div($p->html->lista($lista),"menulateral"));

    //if($_POST){
//        $a->validaLogin($_POST,"index.php?pagina=Pagina_inicial");
//    }


    if($_GET){
        switch($_GET['pagina']){
            case "Pagina_inicial":
                array_push($arrConteudo,$p->html->paragrafo("Este é o site de RPG mais maneiro do mundo!!!"));

                $p->noticias->pegaDados();
                $titulos = $p->noticias->getTitulo();
                $conteudos = $p->noticias->getConteudo();
                for($i=0;$i<count($titulos);$i++){
                    array_push($arrNoticias,$p->html->div($titulos[$i]."<br />".$conteudos[$i],"news","id=new".$i.""));
                }
                array_push($arrConteudo,$p->html->div($arrNoticias,"noticias"));
                break;
            case "Vampiro":
                array_push($arrFicha,$p->fichaStoryteller("Vampiro"));
                array_push($arrConteudo,$p->html->div($arrFicha,"ficha"));
                break;
            case "Lobisomen":
                break;
            case "Fale_Conosco":
                break;
        }
    }else{
        array_push($arrConteudo,$p->html->paragrafo("Este é o site de RPG mais maneiro do mundo!!!"));

        $p->noticias->pegaDados();
        $titulos = $p->noticias->getTitulo();
        $conteudos = $p->noticias->getConteudo();
        for($i=0;$i<count($titulos);$i++){
            array_push($arrNoticias,$p->html->div($titulos[$i]."<br />".$conteudos[$i],"news","id=new".$i.""));
        }
        array_push($arrConteudo,$p->html->div($arrNoticias,"noticias"));
    }

    array_push($arrBody,$p->html->div($arrConteudo,"conteudo"));
    array_push($arrBody,$p->html->div("","rodape"));
    $p->constroi($arrBody,$arrHead,"RPG de Mesa");


?>