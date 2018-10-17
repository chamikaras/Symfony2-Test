<?php

namespace StudentInfoBundle\Service;


use StudentInfoBundle\Entity\Info\StudentInfo;

class DataOrganizer
{
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function addStudent($name, $phonenumber, $stream)
    {
        $connection = $this->entityManager->getConnection();
        $id = rand(100000, 999999);
        $statement = $connection->prepare("INSERT INTO `student_info`(`id`, `name`, `phonenumber`, `stream`) VALUES (:id,:username,:phonenumber,:stream)");
        $statement->bindValue('id',$id);
        $statement->bindValue('username',$name);
        $statement->bindValue('phonenumber',$phonenumber);
        $statement->bindValue('stream',$stream);
        $statement->execute();
        return $id;
    }


    public function viewStudent($id) {
            $connection = $this->entityManager->getConnection();
            $statement = $connection->prepare("SELECT * FROM `student_info` WHERE id = :id");
            $statement->bindValue('id', $id);
            $statement->execute();
            $results = $statement->fetchAll();
            return $results;
    }


}

?>