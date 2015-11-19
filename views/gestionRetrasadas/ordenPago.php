<section id="" style="background-color: beige;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2 class="section-heading">Orden de Pago</h2>
                <p><?php if(isset($this->query)) echo $this->query; ?></p>
                <hr class="primary">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="service-box">
                        <i class="fa fa-2x fa-backward wow bounceIn text-primary" data-wow-delay=".2s">
                            <a href="<?php echo BASE_URL; ?><?php if(isset($_SESSION["rol"])){if($_SESSION["rol"] == ROL_ESTUDIANTE){echo "estudiante";} else{echo "login";}} ;?>/inicio">
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
    <br/>
    <div class="container">
        <div class="col-md-8 col-md-offset-2" id="orden" name="orden">
                <table style="width:100%; text-align: center" border="1">
                    <tr>
                        <td style="width:60%">
                            <table style="width:100%; border-spacing: 5pt; border-collapse: separate">
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        Fecha de generación: <?php if (isset($this->fecha)) echo $this->fecha?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        <b>Orden de Pago</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        No.
                                    </td>
                                    <td>
                                        <?php if (isset($this->orden)) echo $this->orden?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Carné
                                    </td>
                                    <td>
                                        <?php if (isset($this->carnet)) echo $this->carnet?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Nombre
                                    </td>
                                    <td>
                                        <?php if (isset($this->nombre)) echo $this->nombre?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Unidad
                                    </td>
                                    <td>
                                        <?php if (isset($this->unidad)) echo $this->unidad?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Extensión
                                    </td>
                                    <td>
                                        <?php if (isset($this->ext)) echo $this->ext?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Carrera
                                    </td>
                                    <td>
                                        <?php if (isset($this->carrera)) echo $this->carrera?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        <b>Detalle de Pago</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        Pago de examen de primera retrasada
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;">
                                        Total
                                    </td>
                                    <td>
                                        <?php if (isset($this->total)) echo number_format((float)$this->total, 2, '.', '')?>
                                    </td>
                                </tr>
                            </table>
                        </td>    
                        <td style="width:40%">
                            <table style="width:100%; border-spacing: 5pt; border-collapse: separate">
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        <b>Para uso exclusivo del banco</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Orden No.
                                    </td>
                                    <td>
                                        <?php if (isset($this->orden)) echo $this->orden?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Carné
                                    </td>
                                    <td>
                                        <?php if (isset($this->carnet)) echo $this->carnet?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Total a pagar
                                    </td>
                                    <td>
                                        <?php if (isset($this->total)) echo number_format((float)$this->total, 2, '.', '') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Unidad
                                    </td>
                                    <td>
                                        <?php if (isset($this->unidad)) echo $this->unidad?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Extensión
                                    </td>
                                    <td>
                                        <?php if (isset($this->ext)) echo $this->ext?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Carrera
                                    </td>
                                    <td>
                                        <?php if (isset($this->carrera)) echo $this->carrera?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Rubro de pago
                                    </td>
                                    <td>
                                        <?php if (isset($this->rubro)) echo $this->rubro?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right">
                                        Llave
                                    </td>
                                    <td>
                                        <?php if (isset($this->llave)) echo $this->llave?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center">
                                        Puede efecutar su pago en cualquier agencia o banca virtual de BANRURAL (ATX-253) o GyT Continental.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        
        <div class="col-md-8 col-md-offset-2">
            <br/>
            <button id="generarPDF" onclick="generarPDF()" class="btn btn-danger btn-lg btn-block" style="width:25%; float: right">Imprimir</button>
        </div>
        
    </div>
    <br/>
</section>
<script src="//html2canvas.hertzen.com/build/html2canvas.js"></script>
<script text="text/javascript">
function generarPDF()
   {
//    var printDoc = new jsPDF();
//    printDoc.fromHTML($('#orden').get(0), 10, 10, {'width': 180});
//    printDoc.output("dataurlnewwindow");
    
//            var pdf = new jsPDF('o', 'pt', 'a4');
//           pdf.cellInitialize();
//    pdf.setFontSize(9);
//    $.each( $('#orden tr td'), function (i, table){
//        $.each( $(table).find("table tr"), function(j, row){
//            $.each( $(row).find("td"), function(j, cell){
//        	 var txt = $(cell).text().trim().split(" ").join("\n") || " ";
//             var width = (j==0) ? 70 : 70; //make with column smaller
//             //var height = (i==0) ? 40 : 30;
//             pdf.cell(10, 50, width, 50, txt, i);
//            });
//        });
//    });
//   
//   pdf.output("dataurlnewwindow");

var printContents = document.getElementById('orden').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
//     var w = window.open();
//  var html = $("#orden").html();
//
//    $(w.document.body).html(html);
   }
</script>