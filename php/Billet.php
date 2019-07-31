<?php

class Billet {
    const displayBillet =
        'SELECT *, B.`id` AS idBillet
            FROM `billet` AS B
            INNER JOIN `users` AS U
            ON B.`author` = U.`id`';
    protected $id;
    protected $titre;
    protected $author;
    protected $date;
    protected $texte;
    protected $note;
    protected $link;
    
    public function findAll(PDO $db) {
        $displayBillet = $db->prepare(self::displayBillet);
        $result = $displayBillet->execute();
        return $displayBillet->fetchAll();
    }

    const displayBilletSingle =
        'SELECT *, B.`id` AS idBillet
            FROM `billet` AS B
            LEFT JOIN `commentaires` AS C
            ON B.`id` = C.`link`
            LEFT JOIN `users` AS U
            ON B.`author` = U.`id`
            WHERE B.`id` = ?';

    public function find(PDO $db, int $id) {
        $displayBilletSingle = $db->prepare(self::displayBilletSingle);
        $result = $displayBilletSingle->execute([$id]);
        return $displayBilletSingle->fetchAll();
    }
}

// final class Billet extends Top {

// }

?>