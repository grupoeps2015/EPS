<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of encriptedEasy
 *
 * @author ARIAS
 */
class encriptedEasy {
//   var $characters2 = 'abcdefghijklmnñopqrstuvwxyz0123456789';
//   var $characters = '#%bc1de2f3gh/(j)kl6m7nñ8op9qr?tuv¡¿yz&';
   private static $charAllows = 'a0bc1de2f3gh4ij5kl6m7nñ8op9qrstuvwxyz ';
   private static $characters = 'a0bc1de2f3gh4ij5kl6m7nñ8op9qrstuvwx&yz';
   private static $num_encript;
   public static $string;
   public static function encode($texto, $key = '12345678901234567890123456789012')
   {

        // Proceso de cifrado
        $iv    = 'abcdefwxyz012345';
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
        mcrypt_generic_init($td, $key, $iv);
        $texto_cifrado = mcrypt_generic($td, $texto);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        // Opcionalmente codificamos en base64
        $texto_cifrado = base64_encode($texto_cifrado);
      return $texto_cifrado;
   }
   public static function decode($texto_cifrado, $key = '12345678901234567890123456789012')
   {
      $texto_cifrado = base64_decode($texto_cifrado);

        // Proceso de descifrado
        $iv    = 'abcdefwxyz012345';
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
        mcrypt_generic_init($td, $key, $iv);
        $texto = mdecrypt_generic($td, $texto_cifrado);
        $texto = trim($texto, "\0");
      return $texto;
   }

}

?>
