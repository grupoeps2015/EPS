<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Usuarios</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-plus wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>admCrearUsuario/agregarUsuario">
                                Agregar Usuario
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>admCrearUsuario/agregarUsuario">
            <div id="divEstudiantes" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <table id="tbUsuarios" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Codigo</th>
                                <th style="text-align:center">Carnet /<br/>Registro</th>
                                <th style="text-align:center">Nombre Usuario</th>
                                <th style="text-align:center">Rol</th>
                                <th style="text-align:center">Correo</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center">&nbsp;</th>
                                <th style="text-align:center">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstUsr) && count($this->lstUsr)): ?>
                            <?php for($i =0; $i < count($this->lstUsr); $i++) : ?>
                            <tr>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['id']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['registro']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['nombre']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['rol']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['correo']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstUsr[$i]['estado']; ?></td>
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'admCrearUsuario/actualizarUsuario/' . $this->lstUsr[$i]['id'];?>">Modificar</a></td>
                                <td style="text-align: center;">
                                    <?php if(strcmp($this->lstUsr[$i]['estado'], 'Activo') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'admCrearUsuario/eliminarUsuario/-1/' . $this->lstUsr[$i]['id'];?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'admCrearUsuario/eliminarUsuario/1/' . $this->lstUsr[$i]['id'] ?>">Activar</a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endfor;?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" style="text-align: center">No hay informacion disponible</td>
                            </tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>