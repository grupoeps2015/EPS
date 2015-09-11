<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Men&uacute;</title>
  <script type="text/javascript">
    $(document).ready(function() {
        
    $('li.padres').hover(function() {
        $(this).children('ul.hijos').show('slow');
    });
    //$('li.padres').mouseleave(function(event) {
        //$('ul.hijos').hide('slow');
    //});
    $('#titulomenu').click(function() {
        $('ul.hijos').hide('slow');
    });
               
});
  </script>
  </head>
<body>
    
    <?php	
    include(realpath(dirname(__FILE__)) . "/application/Config.php");
    session_start();
    $user = DB_USER;
    $password = DB_PASS;
    $dbname = DB_NAME;
    
    $host = DB_HOST;
    $cadenaConexion = "host=$host dbname=$dbname user=$user password=$password";
    $conn = pg_connect($cadenaConexion);              
    $menus = array();    
    $listamenu = '';
    
    /*$file = fopen("log.txt", "a");
                fwrite($file, "HOST: " . DB_HOST. PHP_EOL);
                fclose($file);*/
                
    if (isset($_SESSION['rol'])){ 
       $GLOBALS['listamenu'] .= '<a id="titulomenu" href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#000080">Men&uacute; <b class="caret"></b></a>';
       $GLOBALS['listamenu'] .= '<ul class="dropdown-menu">';
                                   
    $sql = "SELECT * FROM spFuncionMenuPadre(" . $_SESSION["rol"] . ");";							

            $result=pg_query($GLOBALS['conn'], $sql); 
            $cantidadFilas=pg_num_rows($result);
    
            if ($cantidadFilas > 0) {
                    while($row = pg_fetch_array($result)) {
                            $row["hijos"] = array(); 
                            $menus[$row["funcionmenu"]] = $row;
                    }		
            } else {

            }	
            
             foreach($menus as &$menu){
                    agregarSubMenus($menu);
            }
            
            pg_close($GLOBALS['conn']);

            foreach($menus as &$menu){
                    imprimirMenu($menu);
            }
            $GLOBALS['listamenu'] .= '</ul>';
    }
    else {     
        $GLOBALS['listamenu'] .= '';
    }
    
    function agregarSubMenus(&$menu){
        
            $sql = "SELECT * FROM spFuncionMenuHijo(" .$menu["funcionmenu"] ."," ."0);";
            $result=pg_query($GLOBALS['conn'], $sql); 
            $cantidadFilas=pg_num_rows($result);		
            if ($cantidadFilas > 0) {
                    while($row = pg_fetch_array($result)) {
                            $row["hijos"] = array(); 
                            $menu["hijos"][$row["funcionmenu"]] = $row;
                    }		
            } else {
            }	

            foreach($menu["hijos"] as &$hijo){
                    agregarSubMenus($hijo);
            }
    }

    function imprimirMenu(&$menu){
            
            $GLOBALS['listamenu'] .= '<li class="padres"><a href="'.$menu["url"].'">'.$menu["nombre"]."</a>\n";

            if($menu["hijos"]){
                    $GLOBALS['listamenu'] .= "<ul class='hijos' style='list-style:none;'>\n";
                    foreach($menu["hijos"] as &$hijo){
                            imprimirMenu($hijo);
                    }
                    $GLOBALS['listamenu'] .= "</ul>\n";
            }

            $GLOBALS['listamenu'] .= "</li>\n";
    }
    ?>
    <div id="menugenerado" name="menugenerado" class="navbar navbar-default navbar-fixed-side navbar-fixed-side-left" role="navigation">
                        <div class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                <li class="dropdown" >
                                     <?php echo $listamenu ?>   
                                </li>
                            </ul>
                        </div>
                </div>
</body>
</html>