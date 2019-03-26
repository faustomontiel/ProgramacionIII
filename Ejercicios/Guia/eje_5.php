<?php
	$a = 5555;
    $b = 3333;
    $c = 2222;
   
    if(($a > $b && $a <$c) || ($a < $b && $a > $c )){
        echo $a;
    }elseif(($b > $a && $b < $c) || ($b < $a && $b > $c) ){
        echo $b;
    }elseif(($c > $a && $c < $b) || ($c < $a && $c > $b) ){
        echo $c;
    }else{
        echo "No hay valor del medio.";
    }
?>
