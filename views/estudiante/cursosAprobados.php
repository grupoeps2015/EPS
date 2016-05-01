<script text="text/javascript">
function generarPDF()
   {
       var strCarnet = "<?php echo $this->lstCur[0]['carnet']; ?>";
            var pdf = new jsPDF('p', 'pt', 'letter');
            source = $('#divCursosAprobados')[0];

            specialElementHandlers = {
                '#bypassme': function(element, renderer) {
                    return true
                }
            };
            margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522
            };
            pdf.fromHTML(
                    source, 
                    margins.left, 
                    margins.top, {
                        'width': margins.width, 
                        'elementHandlers': specialElementHandlers
                    },
            function(dispose) {
                pdf.save("ListadoCursosAprobados - " + strCarnet + '.pdf');
            }
            , margins);
        
   }
   
</script>
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
        <!--<?//php if(isset($this->lstCur[0]['codigo'])):?>
        <br/>        
        <button id="generarPDF" onclick="generarPDF()" class="btn btn-danger btn-lg btn-block" style="width:25%">Generar PDF</button>
        <br/>
        <?//php endif;?>-->
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
                            <?php $contadorPromedio = 0; $promedio = 0;?>
                            <?php for($i =0; $i < count($this->lstCur); $i++) : ?>
                            <tr>                                
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['codigo']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['asignatura']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['nombretipoaprobacion']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['calificacionnumeros']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['fechaaprobacion']; ?></td>                                
                            </tr>
                            <?php if($this->lstCur[$i]['calificacionnumeros'] != CURSO_APROBADO && $this->lstCur[$i]['calificacionnumeros'] != CURSO_REPROBADO): ?>
                                    <?php ++$contadorPromedio; $promedio = $promedio + $this->lstCur[$i]['calificacionnumeros'];?>
                                <?php endif;?>
                            <?php endfor;?>
                        <?php endif;?> 
                        </tbody>
                    </table>
                    <br />
                    <?php if(isset($this->lstCur[0]['codigo'])):?>
                    <label>Promedio general: <?php $promedioGeneral =0; $promedioGeneral = $promedio / $contadorPromedio; echo $promedioGeneral; ?> </label>
                    <br/>    
                    <?php endif;?> 
                </div>
            </div>
    </div>   
</section>