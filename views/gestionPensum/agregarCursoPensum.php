<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Nuevo Curso Pensum</h2>
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
                            <table  width="100%">
                                <tbody class="text-primary">
                                    <tr style="width: 49%">
                                        <td><label>Carrera:</label>
                                            <?php if (isset($this->carreras) && count($this->carreras)): ?>
                                                <select id="slCarreras" name="slCarreras" class="form-control input-lg">
                                                    <option value="">(Carreras)
                                                    </option>
                                                    <?php for ($i = 0; $i < count($this->carreras); $i++) : ?>
                                                        <option value="<?php echo $this->carreras[$i]['codigo']; ?>">
                                                            <?php echo $this->carreras[$i]['nombre']; ?>
                                                        </option>
                                                    <?php endfor; ?>
                                                </select>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 2%">&nbsp;</td>
                                        <td style="width: 49%"><label>Tipo:</label>
                                            <select id="slTipos" name="slTipos" class="form-control input-lg">
                                                <option value="">(Tipo)
                                                </option>
                                                <option value="1">Cerrado</option>
                                                <option value="2">Abierto</option>
                                            </select>
                                        </td>
                                    </tr>
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
