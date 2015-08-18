<header style="background-image: url(<?php echo $_layoutParams['ruta_img']?>fuente.jpg);">
    <div class="header-content">
        <br/> <br/>

        <div class="header-content-inner">
            <h2>Administradores</h2>
            <hr />
            <div class="row">
                <form class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3" id="frLogin" method="post" action="<?php echo BASE_URL; ?>admHistoriaLogin/autenticar">
                    <div class="form-group">
                        <input name="usuario" type="text" class="form-control input-lg" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <input name="pass" type="password" class="form-control input-lg" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger btn-lg btn-block">Iniciar Sesi&oacute;n</button>
                        <br/><br/>
                        <span class="pull-right"><a href="#">Olvidaste tu password?</a></span>
                    </div>
                    <input id="tipo" name="tipo" type="hidden" value="3"/>
                </form>
            </div>
        </div>
    </div>
</header>

<?php 
//if(isset($this->respuesta)) print_r($this->respuesta)
?>