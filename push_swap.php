<?php

// MISE EN PLACE ET GESTION D'EEREURS

$la = $argv;
$la = array();
$lb = [];

$array_operation = [];

for($i=1;$i<count($argv);$i++){
    array_push($la, $argv[$i]);
}

$sorted = array_values($la);
sort($sorted);

if($argc < 3 || $la === $sorted){
    return false;
}else {

    // LES FUNCTIONS

    function sa(&$la){

        if(!empty($la) AND count($la)>=2){
            $tmp = $la[0];
            $la[0] = $la[1];
            $la[1] = $tmp;
            array_push($array_operation, "sa");
        }
    }

    function sb(&$lb){

        if(!empty($lb) AND count($lb)>=2){
            $tmp = $lb[0];
            $lb[0] = $lb[1];
            $lb[1] = $tmp;
            array_push($array_operation, "sb");
        }
    }

    function sc(&$la, &$lb){

        sa($la);
        sb($lb);
        array_push($array_operation, "sc");
    }

    function pb(&$la, &$lb, &$array_operation){

        if (!empty($la)) {
            $first = array_shift($la);
            array_unshift($lb, $first);
        }
        array_push($array_operation, "pb");
    }

    function pa(&$la, &$lb,&$array_operation){

        if (!empty($lb)) {
            $f = array_shift($lb);
            array_unshift($la, $f);
        }
        array_push($array_operation, "pa");
    }

    function ra(&$la,&$array_operation){

        $f = array_shift($la);
        array_push($la, $f);
        array_push($array_operation, "ra");
    }

    function rb(&$lb){

        $f = array_shift($lb);
        array_push($lb, $f);
        array_push($array_operation, "rb");
    }

    function rr(&$la, &$lb){

        ra($la);
        rb($lb);
        array_push($array_operation, "rr");
    }

    function rra(&$la, &$array_operation){
        $f = array_pop($la);
        array_unshift($la, $f);
        array_push($array_operation, "rra");
    }

    function rrb(&$lb){

        $f = array_pop($lb);
        array_unshift($lb, $f);
        array_push($array_operation, "rrb");
    }

    function rrr(&$la, &$lb){
        rra($la);
        rrb($lb);
        array_push($array_operation, "rrr");
    }

    // ALGORITHME

    $min = min($la);
    $max = max($la);

    // DEPLACEMENT DU DERNIER ÉLÉMENT SEULEMENT
    $tmp1 = $la;
    $a = array_pop($tmp1);
    $sorted_tmp1 = array_values($tmp1);
    sort($tmp1);

    // DEPLACEMENT DU PREMIER ÉLÉMENT SEULEMENT
    $tmp2 = $la;
    $b = array_shift($tmp2);
    $sorted_tmp2 = array_values($tmp2);
    sort($tmp2);

    if($sorted_tmp1 === $tmp1 AND $min == end($la)){
    rra($la,$array_operation); 
    // le dernier devient premier ex:2 3 5 4 => 4 2 3 5
}
elseif($sorted_tmp2 === $tmp2 AND $max == current($la)){
    ra($la,$array_operation); 
    // le premier devient dernier ex:8 5 6 10 => 5 6 10 8
}
else{

    while(!empty($la)){
        for ($i=0; $i < count($la); $i++) { 
            if($la[0] == min($la)){
                pb($la, $lb, $array_operation);
                //premier élèment "la" et va à la première position de "lb"
            }
            else{
                ra($la,$array_operation);
                //le premier devient dernier
            }
        }
    }

    while(!empty($lb)){
        pa($la, $lb,$array_operation);
        //premier élèment "lb" et va à la première position de "la"
    }

}

// AFFICHAGE DES OPÉRATIONS

$real_string = implode(" ",$array_operation);
echo $real_string . PHP_EOL;

}