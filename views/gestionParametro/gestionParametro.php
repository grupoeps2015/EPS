<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Gesti&oacute;n de Par&aacute;metros</h2>
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
                        <i class="fa fa-2x fa-plus wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL?>gestionParametro/agregarParametro">
                                Agregar Par&aacute;metro
                            </a>
                        </i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frParametros" method="post" action="<?php echo BASE_URL; ?>admCrearParametro/agregarParametro">
            <div id="divParametros" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <table id="tbParametros" border="2">
                        <thead>
                            <tr>
                                <th style="text-align:center">Par&aacute;metro</th>
                                <th style="text-align:center">Nombre</th>
                                <th style="text-align:center">Valor</th>
                                <!--<th style="text-align:center">Descripci&oacute;n</th>-->
                                <th style="text-align:center">Centro</th>
                                <th style="text-align:center">Unidad acad&eacute;mica</th>
                                <th style="text-align:center">Carrera</th>
                                <!--<th style="text-align:center">Extensi&oacute;n</th>-->
                                <th style="text-align:center">Tipo par&aacute;metro</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center">Modificar</th>                               
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstPar) && count($this->lstPar)): ?>
                            <?php for($i =0; $i < count($this->lstPar); $i++) : ?>
                            <tr>
                                <td style="text-align: center; width: 5%;"><?php echo $this->lstPar[$i]['parametro']; ?></td>
                                <td style="text-align: center; width: 8%;"><?php echo $this->lstPar[$i]['nombreparametro']; ?></td>
                                <td style="text-align: center; width: 8%;"><?php echo $this->lstPar[$i]['valorparametro']; ?></td>
                                <!--<td style="text-align: center"><?php echo $this->lstPar[$i]['descripcionparametro']; ?></td>-->
                                <td style="text-align: center"><?php echo $this->lstPar[$i]['nombrecentro']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPar[$i]['nombreunidadacademica']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstPar[$i]['nombrecarrera']; ?></td>
                                <!--<td style="text-align: center"><?php echo $this->lstPar[$i]['extensionparametro']; ?></td>-->
                                <td style="text-align: center"><?php echo $this->lstPar[$i]['nombretipoparametro']; ?></td>
                                <td style="text-align: center">
                                    <?php if(strcmp($this->lstPar[$i]['estadoparametro'], '1') == 0): ?>
                                    <a href="<?php echo BASE_URL . 'gestionParametro/eliminarParametro/-1/' . $this->lstPar[$i]['parametro'];?>">Desactivar</a>
                                    <?php else : ?>
                                    <a href="<?php echo BASE_URL . 'gestionParametro/eliminarParametro/1/' . $this->lstPar[$i]['parametro'] ?>">Activar</a>
                                    <?php endif;?>
                                </td>
                                <td style="text-align: center;"><a href="<?php echo BASE_URL . 'gestionParametro/actualizarParametro/' . $this->lstPar[$i]['parametro'];?>">Modificar</a></td>
                            </tr>
                            <?php endfor;?>
                        <?php endif;?>
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>