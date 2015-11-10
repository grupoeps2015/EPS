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
        <?php if(isset($this->lstCur[0]['codigo'])):?>
        <br/>        
        <button id="generarPDF" onclick="generarPDF()" class="btn btn-danger btn-lg btn-block" style="width:25%">Generar PDF</button>
        <br/>
        <?php endif;?>
            <div id="divCursosAprobados" class="form-group" >
                <div style="margin-left: 5%; margin-right: 5%">
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
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($this->lstCur) && count($this->lstCur)): ?>
                            <?php for($i =0; $i < count($this->lstCur); $i++) : ?>
                            <tr>                                
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['cursoaprobado']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['codigo']; ?></td>
                                <td style="text-align: center;"><?php echo $this->lstCur[$i]['asignatura']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['nombretipoaprobacion']; ?></td>
                                <td style="text-align: center"><?php echo $this->lstCur[$i]['calificacionnumeros']; ?></td>
                                <td style="text-align: center"><?php echo numtoletras($this->lstCur[$i]['calificacionnumeros']); ?></td>
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