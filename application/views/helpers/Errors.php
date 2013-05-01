<?php
class Zend_View_Helper_Errors extends Zend_View_Helper_Abstract
{
    public function Errors ($errors){
        if (count($errors)>0){
        	//echo '<div class="">';
            echo '<div  class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button>';
           //echo "<ul>";
            var_dump($errors);
            /*foreach ($errors as $error) {
                if ($error[0]!=""){
                    printf("<p>%s</p>", $error[0]);
                }
            }*/
            //echo "</ul>";
            echo "</div>";
        }
    }

} 
?>