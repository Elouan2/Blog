<?php 

abstract class Top {

    function queryAdd(PDO $dataBase ,string $table,array $tableau)
    {
        unset ($tableau['case']); /*suppression de la variable */
        unset ($tableau['submit']);
        $keys = array_keys($tableau);
        $cle = implode(', ', $keys);
        $valeur = implode(', ', array_fill(0, count($keys), '?')); // ['?', '?','?']
        $queryAdd= "INSERT INTO $table ($cle) VALUES ($valeur)";
        $query= $dataBase->prepare($queryAdd);
        $parameter = [];
        foreach($tableau as $key => $valeur){
            switch ($key) {
                case 'password':
                    $parameter[]= (!empty($valeur)) ? password_hash($valeur, PASSWORD_DEFAULT): NULL;
                    break;
                default:
                    $parameter[]= (!empty($valeur)) ? $valeur: NULL;
        }
    }
    $error = $query -> execute($parameter);
    return $error;
    }
}

?>