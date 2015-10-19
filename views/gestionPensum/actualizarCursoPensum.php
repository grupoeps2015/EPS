<section id="" style="background-color: beige;">
    <div class="header-content">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Actualizar Curso Pensum</h2>
                <hr class="primary">
                
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/gestionCursoPensum/<?php echo $this->idPensum?>/<?php echo $this->idCarrera;?>">
                                Regresar 
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
                <div class="col-lg-3 col-md-6 text-center"></div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <form id="frCursoPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/actualizarCursoPensum/<?php echo $this->idCursoPensum;?>/<?php echo $this->idPensum;?>/<?php echo $this->idCarrera;?>">
                <div id="divCursoPensum" class="form-group" >
                    <div class="col-md-6 col-md-offset-3">
                        <table style="width:120%">
                                    <tr style="width: 70%">
                                        <td><label>Curso:</label>
                                            <?php if(isset($this->lstCursos) && count($this->lstCursos)): ?>
                                <select id="slCursos" name="slCursos" class="form-control input-lg">
                                   <option value="">- Cursos disponibles -</option>
                                    <?php for($i =0; $i < count($this->lstCursos); $i++) : ?>
                                   <?php if($this->lstCursos[$i]['id'] == $this->datosCursoPensum[0]['curso']): ?>
                                    <?php if($this->lstCursos[$i]['estado'] == "Activo"): ?>
                                     <option value="<?php echo $this->lstCursos[$i]['id'];?>" selected="selected">
                                         <?php echo $this->lstCursos[$i]['codigo']; echo " - "; echo $this->lstCursos[$i]['nombre'];?>
                                     </option>                                    
                                     <?php endif;?>
                                     <?php else : ?>
                                        <?php if($this->lstCursos[$i]['estado'] == "Activo"): ?>
                                     <option value="<?php echo $this->lstCursos[$i]['id'];?>">
                                         <?php echo $this->lstCursos[$i]['codigo']; echo " - "; echo $this->lstCursos[$i]['nombre'];?>
                                     </option>                                    
                                     <?php endif;?>
                                     <?php endif; ?>
                                    <?php endfor;?>
                                </select>
                                <?php else : ?>
                                No hay cursos disponibles.
                                <?php endif;?>
                                <br/>
                                        </td> 
                                    </tr>
                                    <tr> 
                                        <td><br/>
                                            <label>&Aacute;rea:</label>
                                             <?php if(isset($this->lstAreas) && count($this->lstAreas)): ?>
                                <select id="slAreas" name="slAreas" class="form-control input-lg">
                                    <option value="">- &Aacute;reas disponibles -</option>
                                    <?php for($i =0; $i < count($this->lstAreas); $i++) : ?>
                                    <?php if($this->lstAreas[$i]['carreraarea'] == $this->datosCursoPensum[0]['carreraarea']): ?>
                                    <option value="<?php echo $this->lstAreas[$i]['carreraarea'];?>" selected="selected">
                                         <?php echo $this->lstAreas[$i]['nombre']; ?>
                                     </option>   
                                     <?php else :?>
                                     <option value="<?php echo $this->lstAreas[$i]['carreraarea'];?>">
                                         <?php echo $this->lstAreas[$i]['nombre']; ?>
                                     </option>   
                                     <?php endif;?>
                                    <?php endfor;?>
                                </select>
                                <?php else : ?>
                                            No hay &aacute;reas disponibles.
                                <?php endif;?>
                                <br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br/>
                                            <label>N&uacute;mero ciclo:</label>
                                            <input type="number" id="txtNumeroCiclo" name="txtNumeroCiclo" class="form-control input-lg" value="<?php echo $this->datosCursoPensum[0]['numerociclo']; ?>">
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td>
                                            <br/>
                                <label>Tipo ciclo:</label>
                                            <?php if(isset($this->lstTipoCiclo) && count($this->lstTipoCiclo)): ?>
                                <select id="slTipoCiclo" name="slTipoCiclo" class="form-control input-lg">
                                    <option value="">- Tipos de ciclo disponibles -</option>
                                    <?php for($i =0; $i < count($this->lstTipoCiclo); $i++) : ?>
                                    <?php if($this->lstTipoCiclo[$i]['tipociclo'] == $this->datosCursoPensum[0]['tipociclo']): ?> 
                                    <option value="<?php echo $this->lstTipoCiclo[$i]['tipociclo'];?>" selected="selected">
                                         <?php echo $this->lstTipoCiclo[$i]['nombre']; ?>
                                     </option>    
                                     <?php else : ?>
                                     <option value="<?php echo $this->lstTipoCiclo[$i]['tipociclo'];?>">
                                         <?php echo $this->lstTipoCiclo[$i]['nombre']; ?>
                                     </option>  
                                     <?php endif;?>
                                    <?php endfor;?>
                                </select>
                                <?php else : ?>
                                            No hay tipos de ciclos disponibles.
                                <?php endif;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br/>
                                            <label>Cr&eacute;ditos:</label>
                                            <input type="number" id="txtCreditos" name="txtCreditos" class="form-control input-lg" value = "<?php echo $this->datosCursoPensum[0]['creditos']; ?>">
                                        </td>
                                    </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <br/>
                                    <input type="submit" id="btnActualizarCursoPensum" name="btnActualizarCursoPensum" value="Actualizar" class="btn btn-danger btn-lg btn-block" style="width:100%">
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="hdEnvio" value="1" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>