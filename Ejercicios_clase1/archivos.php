<?php

        $arch = fopen("archivo.txt","r");
        $archArray = array();
        $i = 0;
        //fwrite($arch,"Hola soy un archivo");

       while(!feof($arch)){
        $archArray[] = fgets($arch);
        $varArch[$i] = explode(";",$archArray[$i]);
        $i++;
        }
       
        foreach($varArch as $item){
                foreach($item as $var){
                        echo $var;
            }
        }

        fclose($arch);
?>