<?
    $assunto = $_SESSION["user"];
    echo $_SESSION["user"]."11111";
    //unset($_SESSION["user"]);
    setcookie('user',$assunto,time()-3600*24*30);
    //echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=../View/view_modelo.php'>";
    print_r($_COOKIE['user']);
?>