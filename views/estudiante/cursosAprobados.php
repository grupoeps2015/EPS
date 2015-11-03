<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Cursos Aprobados</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>estudiante/inicio">
                                Regresar
                            </a>
                        </i>
                    </div>
                </div>
                <div class="col-lg-1 col-md-6 text-cenater"></div>
                <div class="col-lg-4 col-md-6 text-center">                    
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div>
            <div id="divCursosAprobados" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
                    <table id="tbCursosAprobados" border="2">
                        <thead>
                            <tr>                                
                                <th style="text-align:center">C&oacute;digo</th>
                                <th style="text-align:center">Asignatura</th>
                                <th style="text-align:center">Tipo Aprobaci&oacute;n</th>
                                <th style="text-align:center">Calificaci&oacute;n</th>
                                <th style="text-align:center">Fecha Aprobaci&oacute;n</th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCur) && count($this->lstCur)): ?>
                            <?php for($i =0; $i < count($this->lstCur); $i++) : ?>
                            <tr>                                
                                <td style="text-align: center; width: 13%;"><?php echo $this->lstCur[$i]['codigo']; ?></td>
                                <td style="text-align: center; width: 8%;"><?php echo $this->lstCur[$i]['asignatura']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['nombretipoaprobacion']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['calificacionnumeros']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['fechaaprobacion']; ?></td>                                
                            </tr>
                            <?php endfor;?>
                        <?php endif;?> 
                        </tbody>
                    </table>
                    <br />
                </div>
            </div>
    </div>   
</section>