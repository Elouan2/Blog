<?php

function connect($dsL, $user, $pwd){
    $dataBase=new PDO($dsL, $user, $pwd);
    return $dataBase;
}

// // Michel cf function queryAdd de Mathilde
// function addRecord(PDO $dataBase, string $table, array $formData)
// {
//     $queryTemplate =
//         'INSERT INTO `%s`(%s)
//             VALUES (%s)';
//     unset($formData['case']);
//     unset($formData['submit']);
//     $taille = count(array_keys($formData));
//     $formKeys = implode(', ', array_keys($formData));
//     $formJokers = implode(', ', array_fill(0, $taille, '?'));
//     $query = sprintf($queryTemplate, $table, $formKeys, $formJokers);
//     $statement = $dataBase->prepare($query);
//     $parameter = [];
//     foreach($formData as $f) {
//     $parameter[] = $f; }
//     $statement->execute($parameter);
//     return $error;
// }


// Mathilde = fonction générique pour ajouter 
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

// cf function queryAdd
// function addCategory(PDO $dataBase, string $titre, string $parent, string $description) {
//     $addCategory =
//         'INSERT INTO `category`(`titre`, `parent`, `description`)
//             VALUES (?, ?, ?)';
//     $query = $dataBase->prepare($addCategory);
//     $parameter[0] = $titre;
//     $parameter[1] = (!empty($parent))? $parent : NULL;
//     $parameter[2] = $description;
//     $error = $query->execute($parameter);
//     return $error;
// }

function displayCategory(PDO $dataBase){
    $displayCategory =
        'SELECT * FROM category
            WHERE parent IS NULL';
    $query=$dataBase->prepare($displayCategory);
    $error=$query->execute();
    $result=$query->fetchAll();
    return $result;
}

// cf function queryAdd
// function addUser(PDO $dataBase, string $email, string $firstname, string $lastname, string $role, string $password) {
//     $addUser =
//         'INSERT INTO `users`(`email`, `firstname`, `lastname`, `role`, `password`) 
//             VALUES (?, ?, ?, ?, ?)';
//     $query = $dataBase->prepare($addUser);
//     $parameter[0] = $email;
//     $parameter[1] = $firstname;
//     $parameter[2] = $lastname;
//     $parameter[3] = $role;
//     $parameter[4] = password_hash($password, PASSWORD_DEFAULT);
//     $error = $query->execute($parameter);
//     return $error;
// }

function displayUser(PDO $dataBase){
    $displayUser =
        'SELECT id, `firstname`,`lastname`,`email`,`password`,`role`
            FROM `users`';
    $query=$dataBase->prepare($displayUser);
    $error=$query->execute();
    $result=$query->fetchAll();
    return $result;
}

// cf function queryAdd
// function addBillet(PDO $dataBase, string $titre, string $author, string $texte) {
//     $addBillet =
//         'INSERT INTO `billet`(`titre`, `author`, `texte`)
//             VALUES (?, ?, ?)';
//     $query = $dataBase->prepare($addBillet);
//     $parameter = [$titre, $author, $texte];
//     $error = $query->execute($parameter);
//     return $error;
// }

function displayBillet(PDO $dataBase){
    $affichage =
        'SELECT *, B.`id` AS idBillet
            FROM `billet` AS B
            INNER JOIN `users` AS U
            ON B.`author` = U.`id`';
    $query=$dataBase->prepare($affichage);
    // var_dump($query); die;
    $error=$query->execute();
    $result=$query->fetchAll();
    return $result;
}

function displayBilletSingle(PDO $dataBase, int $idBillet){
    $singleAffichage =
        'SELECT *, B.`id` AS idBillet
            FROM `billet` AS B
            LEFT JOIN `commentaires` AS C
            ON B.`id` = C.`link`
            LEFT JOIN `users` AS U
            ON B.`author` = U.`id`
            WHERE B.`id` = ?';
    $query=$dataBase->prepare($singleAffichage);
    $error=$query->execute([$idBillet]);
    $result=$query->fetchAll();
    return $result;
}


// Pour menu déroulant générique
// function select($table, $columns, $name, $id) {
//     $select = "<select name='$name' id='$name'>";
//     foreach($table as $tab) {
//         $select. = '<option value="'.$tab['id'].'">';
//     foreach($columns as $c) {
//         $select. = $tab[$c]. " ";
//     }
//     $select. = '</option>';
// }