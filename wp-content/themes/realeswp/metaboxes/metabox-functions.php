<?php
 
function add_my_meta_boxes($boxes = array()){
       
       if( class_exists('Custom_Add_Meta_Box') || class_exists('AT_Meta_Box') && !empty($boxes) ):
       
            foreach($boxes as $box){
                if($box['slug']){
                    require_once  $box['folder']."/".$box['slug']."-".$box['name'].".php";  
                }else{
                    require_once  $box['folder']."/".$box['name'].".php";
                }
                
            }
            
       endif;
        
   }


?>
