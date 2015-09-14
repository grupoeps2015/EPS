<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Agregar Asignación de Edificio</h2>
                <p><?php if (isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL ?>gestionEdificio/gestionEdificio/<?php echo $this->id; ?>">
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
                <form id="frCarreras" method="post" action="<?php echo BASE_URL; ?>gestionEdificio/asignacionEdificio">
                    <div id="divEstudiantes" class="form-group" >
                        <div class="col-md-6 col-md-offset-3">
                            <table align="center">
                                <tr>
                                    <td>
                                        <?php if (isset($this->centros) && count($this->centros)): ?>
                                            <select id="slCentros" name="slCentros" class="form-control input-lg">
                                                <option value="">(Centros)
                                                </option>
                                                <?php for ($i = 0; $i < count($this->centros); $i++) : ?>
                                                    <option value="<?php echo $this->centros[$i]['codigo']; ?>">
                                                        <?php echo $this->centros[$i]['nombre']; ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        <?php else : ?>
                                            <input type="text" id="txtCentro" name="txtCentro" class="form-control input-lg" value="-">
                                            <br/>
                                        <?php endif; ?>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                   <td  ><label style="font-weight: normal;">Unidad Academica:</label>
                                        <select id="slCarreras" name="slUnidades" class="form-control input-lg">
                                            <option value="" disabled>(Unidades)</option>
                                        </select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="width: 30%">&nbsp;</td>
                                    <td colspan="3">
                                        <br/>
                                        <input type="submit" id="btnActualizar" name="btnActualizar" value="Actualizar" class="btn btn-danger btn-lg btn-block">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>

                            <br />
                        </div>
                    </div>
                    <input type="hidden" name="hdEnvio" value="1">
                </form>
            </div>
        </div>
    </div>
</section>
