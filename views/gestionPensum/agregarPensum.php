<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Nuevo Pensum</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionPensum/listadoPensum">
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
            <div id="divCentros" class="row">
                <form id="frPensum" method="post" action="<?php echo BASE_URL; ?>gestionPensum/agregarPensum">
                    <div id="divCarreras" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table  width="100%" style="margin-left: 135px;">
                                <col style="width: 1%">
                                <col style="width: 20%">
                                <tbody>
                                    <tr>
                                        <td > <label style="margin-top: 7px; margin-bottom: 8px; margin-left: 7px; margin-right: 7px;">Carrera:</label>
                                            <?php if (isset($this->carreras) && count($this->carreras)): ?>
                                                <select style="width: 330px; margin-bottom: 7px; margin-top: 7px; margin-left: 7px; margin-right: 7px;" id="slCarreras" name="slCarreras" class="form-control input-lg">
                                                    <option value="">(Carreras)
                                                    </option>
                                                    <?php for ($i = 0; $i < count($this->carreras); $i++) : ?>

                                                        <option value="<?php echo $this->carreras[$i]['codigo']; ?>">
                                                            <?php echo $this->carreras[$i]['nombre']; ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            <?php else : ?>
                                                <input type="text" id="txtCarrera" name="txtCarrera" class="form-control input-lg" value="-">
                                                <br/>
                                            <?php endif; ?>
                                        </td>
                                        <td> <label style="margin-top: 7px; margin-bottom: 8px; margin-left: 7px; margin-right: 7px;">Tipo:</label>
                                            <select style="margin-bottom: 7px; margin-top: 7px; margin-left: 7px; margin-right: 7px; width: 170px;" id="slTipos" name="slTipos" class="form-control input-lg">
                                                <option value="">(Tipo)
                                                </option>
                                                <option value="1">Cerrado</option>
                                                <option value="2">Abierto</option>
                                            </select>
                                        </td>

                                    </tr>

                                    <tr> 
                                        <td>
                                            <label style="margin-top: 7px; margin-bottom: 8px; margin-left: 7px; margin-right: 7px;">Duracion (ciclos):</label>
                                            <input type="text"  placeholder="(ingresa el número de ciclos)" id="txtTiempo" name="txtTiempo"  
                                                   style="width: 300px; margin-bottom: 7px; margin-top: 7px; margin-left: 7px; margin-right: 7px;" class="form-control input-lg">

                                        </td>

                                        <td>
                                            <label style="margin-top: 7px; margin-bottom: 8px; margin-left: 7px; margin-right: 7px;">Fecha inicio vigencia:</label>
                                            <br/>
                                            <input type="date" name="inputFecha" id="inputFecha" style="margin-top: 7px; margin-bottom: 8px; margin-left: 7px; margin-right: 7px;">
                                            
                                        </td>

                                    </tr>
                                    <tr> 
                                        <td colspan="2">
                                            <label style="margin-top: 7px; margin-bottom: 8px; margin-left: 7px; margin-right: 7px;">Descripcion:</label>
                                            <br/>
                                            <textarea name="txtDescripcion"  placeholder="(ingresa aquí la descripción del pensum)" id="txtDescripcion" style="height: 130px; width: 515px; resize: none; margin-left: 7px; margin-right: 7px;" rows="3"></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <input type="submit" id="btnAgregarPensum" style="width: 200px; margin-top: 10px; float: right; margin-bottom: 25px;" 
                                                   name="btnAgregarPensum" value="Guardar" class="btn btn-danger btn-lg btn-block">

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
