<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Usuarios</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-home wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>login/inicio">
                                Inicio
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-user-plus wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionUsuario/agregarUsuario">
                                Agregar Usuario
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    
    
    <div class="form-group" >
        <div class="col-md-8 col-md-offset-2">
            <table>
                <tr>
                    <td style="width: 10%">
                        <h4>Centro Educativo: </h4>
                    </td>
                    <td style="width: 38%">
                        <select id="slCentros" name="slCentros" class="form-control input-lg">
                        <?php if (isset($this->lstCentros) && count($this->lstCentros)): ?>
                                <option value="">-- Centro Educativo --</option>
                                <?php for ($i = 0; $i < count($this->lstCentros); $i++) : ?>
                                    <option value="<?php echo $this->lstCentros[$i]['codigo']; ?>">
                                        <?php echo $this->lstCentros[$i]['nombre']; ?>
                                    </option>
                                <?php endfor; ?>
                        <?php else : ?>
                            <option value="">-- No existen centros registrados --</option>
                        <?php endif; ?>
                        </select>
                    </td>
                    <td>&nbsp;&nbsp;</td>
                    <td style="width: 10%">
                        <h4>Unidad Academica: </h4>
                    </td>
                    <td style="width:40%;">
                        <select id="slUnidad" name="slUnidad" class="form-control input-lg">
                            <option value="" disabled>-- Unidad Academica --</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="5"><hr class="hr1"/></td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Tabla con lista de estudiantes -->
    <div id="divTabla" style="display:none;">
        <form id="frEstudiantes" method="post" action="<?php echo BASE_URL; ?>gestionUsuario/agregarUsuario">
            <div id="divEstudiantes" class="form-group" >
                <div style="margin-left: 10%; margin-right: 10%">
                    <br/>
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
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionUsuario/actualizarUsuario/' . $this->lstUsr[$i]['id'];?>">Modificar</a></td>
                                <td style="text-align: center;">
                                    <?php if(strcmp($this->lstUsr[$i]['estado'], 'Activo') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'gestionUsuario/eliminarUsuario/-1/' . $this->lstUsr[$i]['id'];?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'gestionUsuario/eliminarUsuario/1/' . $this->lstUsr[$i]['id'] ?>">Activar</a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endfor;?>
                        <?php else : ?>
                            <tr>
                                <td colspan="8" style="text-align: center">No hay informaci&oacute;n disponible.</td>
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