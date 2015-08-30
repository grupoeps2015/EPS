<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Menu</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#menu" ).menu();
  });
  </script>
  <style>
  .ui-menu { width: 150px; }
  </style>
</head>
<body>
	
<?php	/*
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "eps";
	$conn = new mysqli($servername, $username, $password, $dbname);	*/
	
								$user = "postgres";
								$password = "pruebas123";
								$dbname = "EPS";
								$port = "5432";
								$host = "localhost";
								$cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";
								$conn = pg_connect($cadenaConexion);              
								
		$menus = array();
		
	function agregarSubMenus(&$menu){	/*
		if ($GLOBALS['conn']->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} */
		$sql = "SELECT * FROM adm_funcionmenu WHERE FuncionPadre = ".$menu["funcionmenu"];
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
		echo '<li><a href="'.$menu["url"].'">'.$menu["nombre"]."</a>\n";
		
		if($menu["hijos"]){
			echo "<ul>\n";
			foreach($menu["hijos"] as &$hijo){
				imprimirMenu($hijo);
			}
			echo "</ul>\n";
		}
		
		echo "</li>\n";
	}
	

	function main(){
		/*if ($GLOBALS['conn']->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} */
		//$result = $GLOBALS['conn']->query($sql);
		$sql = "SELECT * FROM adm_funcionmenu WHERE FuncionPadre IS NULL";							
	
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
		
		echo '<ul id="menu">'."\n";
		
		foreach($menus as &$menu){
			imprimirMenu($menu);
		}
		
		echo "</ul>\n";
	}
	
	main();
?> 
</body>
</html>