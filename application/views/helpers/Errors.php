<?php
class Zend_View_Helper_Errors extends Zend_View_Helper_Abstract
{
    public function Errors ($errors){
        if (count($errors)>0){
        	//echo '<div class="">';
            echo "<div id='errors' style='margin-top:5%' class='three columns alert-box alert'>";
           //echo "<ul>";
            foreach ($errors as $error) {
                if ($error[0]!=""){
                    printf("<p>%s</p>", $error[0]);
                }
            }
            //echo "</ul>";
            echo "</div>";
        }
    }

}
?>