<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Men&uacute;</title>
  <script type="text/javascript">
    $(document).ready(function() {
      
    $('li.padres').hover(function() {
      $(this).children('ul.hijos').show('slow');
      //$(this).siblings('li').children('ul.hijos').hide(1150);
   });
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
                
    //Valida si el usuario entró por primera vez: 0 (false)->estado = activo o inactivo, 1 (true)->estado = pendiente de validacion
   if(isset($_SESSION["usuario"])){     
     $sqlValidacion = "SELECT * from spValidarPrimerIngresoUsuario( " . $_SESSION["usuario"] .  " ) AS primerintento";							
     $resultValidacion=pg_query($GLOBALS['conn'], $sqlValidacion);
     $rowValidado = pg_fetch_array($resultValidacion);
   
    if (isset($_SESSION['rol']) && $rowValidado["primerintento"]==0){ 
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
   }
   else
   {
       $GLOBALS['listamenu'] .= '';
   }
    function agregarSubMenus(&$menu){
        
            $sql = "SELECT * FROM spFuncionMenuHijo(" .$menu["funcionmenu"] ."," . $_SESSION["rol"] . ");";
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
            if($menu["url"]!=''){
            $GLOBALS['listamenu'] .= '<li class="padres"><a href="'.BASE_URL.$menu["url"].'">'.$menu["nombre"]."</a>\n";
            }
            else {
                $GLOBALS['listamenu'] .= '<li class="padres" >'." - ".$menu["nombre"]."\n</a>\n";
            
            }

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