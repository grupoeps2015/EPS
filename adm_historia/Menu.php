<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Escuela de Historia</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css" type="text/css">

        <!-- Custom Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css" type="text/css">

        <!-- Plugin CSS -->
        <link rel="stylesheet" href="../css/animate.min.css" type="text/css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="../css/creative.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body id="page-top">
        <?php
        // put your code here
        ?>

        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="../img/img1.png" width="100px" height="50px" align="left" />
                    <a class="navbar-brand page-scroll" href="#page-top" style="margin-left: 10px; ">Escuela de Historia</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
						<li>
                            <a class="page-scroll" href="#menu">Menu</a>
                        </li>
                      
						
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>

        <header>
            <div class="header-content">
                <img class="alineado" src="../img/img2.png" width="200px" height="200px"/>
                <div class="header-content-inner">
                    <h2>Bienvenido a la Escuela de Historia</h2>
                    <center></center>
                    <br/>
                    <hr>
					<div id="menu"></div>
                </div>
            </div>
        </header>
		
		
		
		 <!-- Funciones javascript -->
			<script type="text/javascript" src="../js/jquery.js"></script>
			<script type="text/javascript">
			
			
				//un array por cada uno de los menús desplegables
				var opciones_menu = [
				{
					texto: "Menú principal",
					url: "#Enlace1",
					enlaces: [
						{
							texto: "Cursos",
							url: "#Enlace1-1"
						},
						{
							texto: "Perfil",
							url: "#Enlace1-2"
						},
						{
							texto: "Noticias",
							url: "#Enlace1-3"
						}	
					]
				}/*,
      
				{
					texto: "Enlace 2",
					url: "#Enlace2",
					enlaces: [
						{
							texto: "Enlace 2.1",
							url: "#Enlace2-1"
						},
						{
							texto: "Enlace 2.2",
							url: "#Enlace2-2"
						}
					]
				}   */
				];
				
				(function($) {

					$.fn.generaMenu = function(menu) {
						this.each(function(){
							var retardo;
							var capaMenu = $(this);
							//creo e inserto la lista principal
							var listaPrincipal = $('<ul></ul>');
							capaMenu.append(listaPrincipal);
							//enlaces principales
							var arrayEnlaces = [];
							var arrayCapasSubmenu = [];
							var arrayLiMenuPrincipal = [];
							//recorro los elementos del menú
								jQuery.each(menu, function() {
								//ahora en this tengo cada uno de los elementos.
									var elementoPrincipal = $('<li></li>');
									listaPrincipal.append(elementoPrincipal);
									//creo el enlace e inserto
								var enlacePrincipal = $('<a href="' + this.url + '">' + this.texto + '</a>');
								elementoPrincipal.append(enlacePrincipal);
         
								var capaSubmenu = $('<div class="submenu"></div>');
								//guardo la capa submenu en el elemento enlaceprincipal
								enlacePrincipal.data("capaSubmenu",capaSubmenu);
								//creo una lista para poner los enlaces
								var subLista = $('<ul></ul>');
								//añado la lista a capaMenu
								capaSubmenu.append(subLista);
								//para cada elace asociado
								jQuery.each(this.enlaces, function() {
									//en this tengo cada uno de los enlaces
									//creo el elemento de la lista del submenú actual
									var subElemento = $('<li></li>');
									//meto el elemento de la lista en la lista
									subLista.append(subElemento);
									//creo el enlace
									var subEnlace = $('<a href="' + this.url + '">' + this.texto + '</a>');
									//cargo el enlace en la lista
									subElemento.append(subEnlace);
            
							});
							//inserto la capa del submenu en el cuerpo de la página
							$(document.body).append(capaSubmenu);
                  
							//defino el evento mouseover para el enlace principal
							enlacePrincipal.mouseover(function(e){
								var enlace = $(this);
								clearTimeout(retardo)
								ocultarTodosSubmenus();
							//recupero la capa de submenu asociada
							submenu = enlace.data("capaSubmenu");
							//la muestro
							submenu.css("display", "block");
							});
         
							//defino el evento para el enlace principal
							enlacePrincipal.mouseout(function(e){
								var enlace = $(this);
								//recupero la capa de submenu asociada
								submenu = enlace.data("capaSubmenu");
								//la oculto
								clearTimeout(retardo);
							retardo = setTimeout("submenu.css('display', 'none');",1000) 
            
							});
         
							//evento para las capa del submenu
							capaSubmenu.mouseover(function(){
								clearTimeout(retardo);
							})
         
							//evento para ocultar las capa del submenu
							capaSubmenu.mouseout(function(){
								clearTimeout(retardo);
								submenu = $(this);
							retardo = setTimeout("submenu.css('display', 'none');",1000) 
							})

							//evento para cuando se redimensione la ventana
							if(arrayEnlaces.length==0){
							//Este evento sólo lo quiero ejecutar una vez
							$(window).resize(function(){
								colocarCapasSubmenus();
							});
							}
         
							/////////////////////////////////////////
							//FUNCIONES PRIVADAS DEL PLUGIN
							/////////////////////////////////////////
         
						//una función privada para ocultar todos los submenus
						function ocultarTodosSubmenus(){
							$.each(arrayCapasSubmenu, function(){
								this.css("display", "none");
						});
							}
         
						//función para colocar las capas de submenús al lado de los enlaces
						function colocarCapasSubmenus(){
							$.each(arrayCapasSubmenu, function(i){
							//coloco la capa en el lugar donde me interesa
							var posicionEnlace = arrayLiMenuPrincipal[i].offset();
							this.css({
								left: posicionEnlace.left,
								top: posicionEnlace.top + 28
							});
						});
						}
         
         
						//guardo el enlace y las capas de submenús y los elementos li en arrays
							arrayEnlaces.push(enlacePrincipal);
							arrayCapasSubmenu.push(capaSubmenu);
							arrayLiMenuPrincipal.push(elementoPrincipal);
         
						//coloco inicialmente las capas de submenús
						colocarCapasSubmenus();
					});
      
				});
   
			return this;
		};

	})(jQuery);

	$("#menu").generaMenu(opciones_menu);
		
		</script>

        <!-- jQuery -->
        <script src="../js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="../js/jquery.easing.min.js"></script>
        <script src="../js/jquery.fittext.js"></script>
        <script src="../js/wow.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/creative.js"></script>

    </body>

</html>
