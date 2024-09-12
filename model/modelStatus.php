<?php

require_once("../services/connectionDB.php");

class modelStatus {

    //Listar todos os status
    public function getAll() {
        try {

            $conn = connectionDB::connect();
            $list = $conn->query("SELECT * FROM tbl_status");
            $result = $list->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch(PDOException $e) {
            return false;
        }
    }

    //Listar um status por ID
    public function getById($idStatus) {
        try {

            $id = filter_var($idStatus, FILTER_SANITIZE_NUMBER_INT);
            $conn = connectionDB::connect();
            $stmt = $conn->prepare("SELECT * FROM tbl_status WHERE id_status = :id_status");
            $stmt->bindParam(':id_status', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch(PDOException $e) {
            return false;
        }
    }

    //Inserir um novo status
    public function save($data) {
        try {

            $status_name = htmlspecialchars($data["status"], ENT_NOQUOTES);
            $conn = connectionDB::connect();
            $stmt = $conn->prepare("INSERT INTO tbl_status (status, created_at) VALUES (:status, NOW())");
            $stmt->bindParam(":status", $status_name);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            return false;
        }
    }

    //Atualizar um status por ID
    public function update($idStatus, $data) {
        try {

            $id = filter_var($idStatus, FILTER_SANITIZE_NUMBER_INT);
            $status = htmlspecialchars($data["status"], ENT_NOQUOTES);

            $conn = connectionDB::connect();
            $stmt = $conn->prepare("UPDATE tbl_status SET status = :status, updated_at = NOW()
                             WHERE id_status = :id_status ");
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":id_status", $id);
            $stmt->execute();

            return true;

        } catch(PDOException $e) {
            return false;
        }
    }

    //Deletar um status por ID
    public function delete($idStatus) {
        try {

            $conn = connectionDB::connect();
            $stmt = $conn->prepare("DELETE FROM tblStatus WHERE id_status = :id_status");
            $stmt->bindParam(":id_status", filter_var($idStatus, FILTER_SANITIZE_NUMBER_INT));
            $stmt->execute();

            return true;

        } catch(PDOException $e) {
            return false;
        }
    }
}