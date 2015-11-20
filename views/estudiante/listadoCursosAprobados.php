
<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Listado de Cursos Aprobados</h2>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?>login/inicio">
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
                <div class="col-lg-12 text-center">
                    <?php if(isset($this->lstCur[0]['nombreestudiante']) && isset($this->lstCur[0]['carnet'])):?>
                    Listado de cursos aprobados del estudiante: <?php echo $this->lstCur[0]['nombreestudiante']?>, quien se identifica con el n&uacute;mero de carnet: <?php echo $this->lstCur[0]['carnet']?>
                 <?php endif;?>
                </div> 
                   
                <div style="margin-left: 5%; margin-right: 5%">
                     <br/>
                     <br/>
                    <table id="tbCursosAprobados" border="2">
                        <thead>
                            <tr>                                
                                <th style="text-align:center">No.</th>
                                <th style="text-align:center">C&oacute;digo</th>
                                <th style="text-align:center">Asignatura</th>
                                <th style="text-align:center">Tipo Aprobaci&oacute;n</th>
                                <th style="text-align:center">Calificaci&oacute;n</th>
                                <th style="text-align:center">Calificaci&oacute;n en letras</th>
                                <th style="text-align:center">Fecha Aprobaci&oacute;n</th>   
                                <th style="text-align:center">Estado de Asignaci&oacute;n</th>   
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCur) && count($this->lstCur)): ?>
                            <?php $contadorPromedio = 0; $promedio = 0;?>
                            <?php for($i =0; $i < count($this->lstCur); $i++) : ?>
                            <tr>                                
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['cursoaprobado']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['codigo']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['asignatura']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['nombretipoaprobacion']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['calificacionnumeros']; ?></td>
                                <td style="text-align: center"><?php echo numtoletras($this->lstCur[$i]['calificacionnumeros']); ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['fechaaprobacion']; ?></td>                                                                
                                <?php if($this->lstCur[$i]['estadoasignacion'] == -3):?>
                                <td style="text-align: center">Curso con problemas</td>                                                                
                                <?php else:?>
                                <td style="text-align: center"></td>                                                                
                                <?php endif;?>                                 
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
                    <?php if(isset($this->creditos[0]['creditos'])):?>
                        <label>Cr&eacute;ditos obtenidos: <?php echo $this->creditos[0]['creditos']?></label>
                        <?php else:?>
                        <label>Cr&eacute;ditos obtenidos: 0?></label>
                        <?php endif;?> 
                    <?php endif;?> 
                    
                        <?php if(isset($this->lstCur[0]['codigo'])):?>
                        <br/>
                        <center>
                        <button id="generarPDF" onclick="generarPDF()" class="btn btn-danger btn-lg btn-block" style="width:25%">Generar PDF</button>
                        </center>
                        <br/>
                        <?php endif;?>
                </div>
            </div>
            
    </div>   
</section>

<script text="text/javascript">
function generarPDF()
   {
       var strCarnet = "<?php echo $this->lstCur[0]['carnet']; ?>";
            var pdf = new jsPDF('o', 'pt', 'a4');
           pdf.cellInitialize();
    pdf.setFontSize(9);
    pdf.text(20, 20,  'Listado de cursos aprobados del estudiante: <?php echo $this->lstCur[0]['nombreestudiante']?>, quien se identifica con el número de carnet: <?php echo $this->lstCur[0]['carnet']?>');
    $.each( $('#tbCursosAprobados tr'), function (i, row){
        $.each( $(row).find("td, th"), function(j, cell){
        	 var txt = $(cell).text().trim().split(" ").join("\n") || " ";
             var width = (j==0) ? 70 : 70; //make with column smaller
             //var height = (i==0) ? 40 : 30;
             pdf.cell(10, 50, width, 50, txt, i);
        });
    });
    pdf.text(20, 20,  'Listado de cursos aprobados del estudiante: <?php echo $this->lstCur[0]['nombreestudiante']?>, quien se identifica con el número de carnet: <?php echo $this->lstCur[0]['carnet']?> \n\n Promedio general: <?php echo $promedioGeneral;?> - Créditos obtenidos: <?php echo $this->creditos[0]['creditos']?>');
   
                pdf.save("ListadoCursosAprobados - " + strCarnet + '.pdf');
          
        
   }
   
</script>

<?php
 
//------    CONVERTIR NUMEROS A LETRAS         ---------------
function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UNO", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); 
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); 
    }
 
    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); 
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; 
        $xexit = true; 
        while ($xexit) {
            if ($xi == $xlimite) { 
                break; 
            }
 
            $x3digitos = ($xlimite - $xi) * -1; 
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); 
            for ($xy = 1; $xy < 4; $xy++) { 
                switch ($xy) {
                    case 1: 
                        if (substr($xaux, 0, 3) < 100) { 
                             
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); 
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; 
                            }
                            else { 
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; 
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } 
                        }
                        break;
                    case 2: 
                        if (substr($xaux, 1, 2) < 10) {
                             
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } 
                        } 
                        break;
                    case 3: 
                        if (substr($xaux, 2, 1) < 1) { 
                             
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; 
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } 
                        break;
                } 
            } 
            $xi = $xi + 3;
        } 
 
        if (substr(trim($xcadena), -5, 5) == "ILLON") 
            $xcadena.= " DE";
 
        if (substr(trim($xcadena), -7, 7) == "ILLONES") 
            $xcadena.= " DE";
 
        
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UNO";
                    }
                    break;
            } // endswitch ($xz)
        } 
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena);
        $xcadena = str_replace("  ", " ", $xcadena); 
        $xcadena = str_replace("UNO UNO", "UNO", $xcadena); 
        $xcadena = str_replace("  ", " ", $xcadena); 
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); 
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); 
        $xcadena = str_replace("DE UNO", "UNO", $xcadena); 
    } 
    return trim($xcadena);
}
 

 
function subfijo($xx)
{ 
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}
 
?>