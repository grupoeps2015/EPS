<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Curso Pensum</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p>
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


    <div class="header-content">
        <div class="header-content-inner">
            <div id="divPensum" class="row">
                <form id="frCursoPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/gestionCursoPensum/<?php echo $this->idPensum?>">
                    <div id="divCursoPensum" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table  width="100%">
                                <tbody class="text-primary">
                                    <tr style="width: 49%">
                                        <td><label>Curso:</label>
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
                                        </td> 
                                    </tr>
                                    <tr> 
                                        <td><br/>
                                            <label>&Aacute;rea:</label>
                                             <?php if(isset($this->lstAreas) && count($this->lstAreas)): ?>
                                <select id="slAreas" name="slAreas" class="form-control input-lg">
                                    <option value="">- &Aacute;reas disponibles -</option>
                                    <?php for($i =0; $i < count($this->lstAreas); $i++) : ?>
                                     <option value="<?php echo $this->lstAreas[$i]['area'];?>">
                                         <?php echo $this->lstAreas[$i]['nombre']; ?>
                                     </option>    
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
                                            <input type="number" id="txtNumeroCiclo" name="txtNumeroCiclo" class="form-control input-lg">
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
                                     <option value="<?php echo $this->lstTipoCiclo[$i]['tipociclo'];?>">
                                         <?php echo $this->lstTipoCiclo[$i]['nombre']; ?>
                                     </option>    
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
                                            <input type="number" id="txtCreditos" name="txtCreditos" class="form-control input-lg">
                                        </td>
                                    </tr>
                                    <tr>
                                         <td align="center"><br />
                                            <input type="submit" id="btnAgregarPensum" name="btnAgregarPensum" value="Guardar" class="btn btn-danger btn-lg btn-block" style="width:70%">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                    <input type="hidden" name="hdPensum" value="<?php echo $this->idPensum; ?>">
                </form>
            </div>
        </div>
    </div>
</section>
