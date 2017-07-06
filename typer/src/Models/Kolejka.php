<?php
/**
 * Created by PhpStorm.
 * User: Krzysiek
 * Date: 2016-12-01
 * Time: 23:20
 */

namespace Models;
use \PDO;

class Kolejka extends  Model
{



    //model zwraca tablice wszystkich kolejek
    public function getAll($status)
    {
        $data = array();
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM kolejka WHERE status=:status');
            $stmt->bindValue(':status', $status, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $stmt1 = $this->pdo->prepare('SELECT count(*) as ile FROM `mecz` WHERE `idKolejka`=:idKolejka');
                $stmt1->bindValue(':idKolejka', $row['idKolejka'], PDO::PARAM_INT);
                $stmt1->execute();
                $result = $stmt1->fetch();
                $stmt1->closeCursor();

                $data[$row['idKolejka']]=array(
                    'idKolejka' => $row['idKolejka'],
                    'numerKolejki' => $row['numerKolejki'],
                    'status' => $row['status'],
                    'ile' => $result['ile']
                );




            }
            $stmt->closeCursor();
            return $data;
        }
        catch(\PDOException $e){
            $error =$this->pdo->errorInfo();
            echo "błąd: ".$error[2];
            echo 'Database connection error';
            exit(1);
        }

    }


    //model zwraca wybrana kolejke
    public function getOne($id)
    {
        try{
            $stmt = $this->pdo->prepare('SELECT * FROM `kolejka` WHERE `idKolejka`=:idKolejka');
            $stmt->bindValue(':idKolejka', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $stmt->closeCursor();
            if($result!==false && !empty($result)){
                return $result[0];
            }
            else return null;
        }
        catch(\PDOException $e) {
            echo 'Database connection error!';
            exit(1);
        }
    }

//model usuwa wybrana kolejke z bazy
    public function delete($id){
        try
        {

            $query = $this->pdo->prepare('DELETE FROM `mecz` WHERE `idKolejka`=:id');
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $query->closeCursor();

            $query = $this->pdo->prepare('DELETE FROM `kolejka` WHERE `idKolejka`=:id');
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            $query->closeCursor();
        }
        catch(\PDOException $e)
        {
            echo 'Polaczenie z baza nie powidolo sie: ' . $e->getMessage();
        }
    }


    //model dodaje nowa  kolejke do bazy
    public function insert()
    {

            try{
                //sprawdzamy czy w tabeli jest jakis sezon
                $stmt = $this->pdo->prepare('SELECT COUNT(idSezon) FROM sezon');
                $stmt->execute();
                $result = $stmt->fetchColumn();
                $stmt->closeCursor();

                //jesli nie ma zwracamy odpowiedni komunikat ze nie ma utworzronego sezonu  trzeba utworzyc sezon przed dodawaniem kolejek
                if($result == 0)
                {
                    return 'ERROR';
                }
                else{
                    //ustalamy numer kolejki
                    $stmt = $this->pdo->prepare('SELECT COUNT(idKolejka) FROM kolejka');
                    $stmt->execute();
                    $numerKolejki = $stmt->fetchColumn();
                    $stmt->closeCursor();


                    if($numerKolejki == 0)
                    {
                        $numerKolejki = 1;
                    }
                    else{
                        $numerKolejki++;
                    }

                    //pobieramy id aktynego sezonu
                    $stmt = $this->pdo->prepare('SELECT idSezon FROM sezon WHERE status=:status');
                    $stmt -> bindValue(':status', 1, PDO::PARAM_INT);
                    $stmt->execute();
                    $idSezon =  $stmt->fetch();
                    $stmt->closeCursor();

                    //wstawiamy do tabeli dane nowej kolejki
                    $stmt= $this-> pdo -> prepare('INSERT INTO `kolejka` (`numerKolejki`, `status`, `idSezon`)
                               VALUES(:numerKolejki, :status, :idSezon)');
                    $stmt -> bindValue(':numerKolejki', $numerKolejki, PDO::PARAM_INT);
                    $stmt -> bindValue(':status', 0, PDO::PARAM_INT);
                    $stmt -> bindValue(':idSezon', $idSezon[0], PDO::PARAM_INT);
                    $stmt->execute();
                    $stmt->closeCursor();

                    return 0;

                }

            }
            catch(\PDOException $e) {
                $error =$this->pdo->errorInfo();
                echo "błąd: ".$error[2];
                echo 'Database connection error ze tu ten blad!';

            }


    }
    // zmiana statusu kolejki
    public function changeStatus($id ,$status)
    {

        $stmt = $this->pdo->prepare('UPDATE kolejka SET status=:status  WHERE idKolejka=:id');
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();


    }
    //sprawdzenei statusu kolejki
    public function checkStatus($id)
    {
        try
        {
            $stmt = $this->pdo->prepare('SELECT * FROM kolejka WHERE idKolejka=:id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
            $stmt->closeCursor();
            return $result['status'];

        }
        catch(\PDOException $e)
        {
            echo 'Polaczenie z baza nie powidolo sie: ' . $e->getMessage();
        }

    }

}
