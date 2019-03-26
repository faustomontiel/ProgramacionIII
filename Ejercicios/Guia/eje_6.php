<?php
    $operador = "+";
    $op1 = 15;
    $op2 = 30;
    $resultado; 
    switch($operador){
        case "+":
            $resultado=$op1+$op2;
            break;
        case "-":
            $resultado=$op1-$op2;
            break;
        case "*":
            $resultado=$op1*$op2;
            break;
        case "/":
            if($op2 != 0){
            $resultado=$op1/$op2;
            }else{
                echo "No se puede dividir por 0";
            }
            break;
         default:
            echo "Signo erroneo";
            break;               
    }
    echo $resultado;

?>