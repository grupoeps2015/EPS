<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Creaci&oacute;n de Pensum</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <!--<i class="fa fa-2x fa-building-o wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/agregarPensum">
                                Agregar Pensum
                            </a>
                        </i>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <form id="frPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/agregarPensum">
            <div id="divPensum" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <input onclick="mostrar()" value="Json valor" type="button"/><br/>
                    <?php if(isset($this->lstCursos) && count($this->lstCursos)): ?>
                                <select id="slCursos" name="slCursos" class="form-control input-lg">
                                   <option value="">- Cursos disponibles -</option>
                                    <?php for($i =0; $i < count($this->lstCursos); $i++) : ?>
                                    <?php if($this->lstCursos[$i]['estado'] == "Activo"): ?>
                                     <option value="<?php echo $this->lstCursos[$i]['id'];?>">
                                         <?php echo $this->lstCursos[$i]['codigo']; echo " - "; echo $this->lstCursos[$i]['nombre'];?>
                                     </option>                                    
                                     <?php endif;?>
                                    <?php endfor;?>
                                </select>
                                <?php else : ?>
                                No hay cursos disponibles.
                                <?php endif;?>
                    <br/>
                    
                    <input type="checkbox" id="chkOtrosPrerrequisitos" name="chkOtrosPrerrequisitos"> Otros Prerrequisitos<br>
                    <input type="text" id="txtOtrosPrerrequisitos" name="txtOtrosPrerrequisitos" disabled="true" placeholder="Cantidad de créditos">
                    <br/>
                    <input onclick="agregar()" value="Agregar elemento" type="button"  class="btn btn-danger btn-lg btn-block" style="width:25%; float:left;"/>
                    <input onclick="remover()" value="Eliminar elemento" type="button"  class="btn btn-danger btn-lg btn-block" style="width:25%; float:left;"/>
                    <!--<input onclick="actualizar()" value="actualizar" type="button"/>-->
         
		    <!--  Contenedor del pensum -->
                    
                    <div id="arbolPensum"></div>
                        
                    <!--<table id="tbEdificios" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center; width: 250px;">Carrera</th>
                                <th style="text-align:center; width: 250px;">Descripción</th>
                                <th style="text-align:center; width: 200px;">Tipo</th>
                                <th style="text-align:center; width: 100px;">Fecha Inicial</th>
                                <th style="text-align:center; width: 100px;">Fecha Final</th>
                                <th style="text-align:center; width: 100px;">Duración(años)</th>
                                <th style="text-align:center; width: 100px;"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($this->lstPensum) && count($this->lstPensum)): ?>

                                <?php for ($i = 0; $i < count($this->lstPensum); $i++) : ?>
                                    <tr>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['carrera']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['descripcion']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['tipo']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['iniciovigencia']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['finvigencia']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;"><?php echo $this->lstPensum[$i]['duracionanios']; ?></td>
                                        <td style="text-align: center; padding-right: 20px;">
                                            <?php if (strcmp($this->lstPensum[$i]['finvigencia'], null) == 0): ?>
                                                <a href="<?php echo BASE_URL . 'gestionPensum/finalizarVigenciaPensum/'. $this->lstPensum[$i]['id']?>">Desactivar Pensum</a>
                                            <?php else : ?>
                                                    Pensum desactivo
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endfor; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" style="text-align: center">No hay informaci&oacute;n disponible.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>-->
                    <br />
                </div>
            </div>
        </form>
    </div>   
</section>