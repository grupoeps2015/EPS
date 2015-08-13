<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title><?php if(isset($this->titulo)) echo $this->titulo; ?></title>
        <link href="<?php echo $_layoutParams['ruta_css']?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_layoutParams['ruta_css']?>bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_layoutParams['ruta_css']?>animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_layoutParams['ruta_css']?>creative.css" rel="stylesheet" type="text/css"/>

<?php if(isset($_layoutParams['public_css']) && count($_layoutParams['public_css'])):?>
    <?php for($i = 0; $i<count($_layoutParams['public_css']); $i++): ?>
    <link href="<?php echo $_layoutParams['public_css'][$i]?>" rel="stylesheet" type="text/css" />
    <?php endfor; ?>
<?php endif; ?> 
        
        <script src="<?php echo $_layoutParams['ruta_js']?>jquery.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>jquery.easing.min.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>jquery.fittext.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>wow.min.js" type="text/javascript"></script>
        <script src="<?php echo $_layoutParams['ruta_js']?>creative.js" type="text/javascript"></script>
        
<?php if(isset($_layoutParams['pubilc_js']) && count($_layoutParams['pubilc_js'])):?>
    <?php for($i = 0; $i<count($_layoutParams['pubilc_js']); $i++): ?>
    <script src="<?php echo $_layoutParams['pubilc_js'][$i]?>" type="text/javascript"></script>    
    <?php endfor; ?>
<?php endif; ?>         
        
<?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])):?>
    <?php for($i = 0; $i<count($_layoutParams['js']); $i++): ?>
    <script src="<?php echo $_layoutParams['js'][$i]?>" type="text/javascript"></script>    
    <?php endfor; ?>
<?php endif; ?> 
        
    </head>
    <body id="page-top">
        
                
                