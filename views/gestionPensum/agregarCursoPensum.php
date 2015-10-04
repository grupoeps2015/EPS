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
                            <a href="<?php echo BASE_URL ?>gestionPensum/gestionCursoPensum/<?php echo $this->idPensum?>">
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
                                    <tr> 
                                        <td><br/>
                                            <label>Duracion (ciclos):</label>
                                            <input type="number"  placeholder="(ingresa el número de ciclos)" id="txtTiempo" name="txtTiempo" class="form-control input-lg">
                                        </td>
                                        <td>&nbsp;</td>
                                        <td><br/>
                                            <label>Fecha inicio vigencia:</label>
                                            <input type="text" name="inputFecha" id="inputFecha" class="form-control input-lg" value="" placeholder="dd/mm/aaaa" >
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="3"><br/>
                                            <label>Descripcion:</label>
                                            <textarea name="txtDescripcion"  placeholder="(ingresa aquí la descripción del pensum)" id="txtDescripcion" rows="5" style="resize: none; width: 100%"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
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
