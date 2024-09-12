<?php

class controllerStatus {

    //Listar todos os status
    public function getAll() {
        try {

            $modelStatus = new modelStatus();
            return $modelStatus->getAll();

        } catch(PDOException $e) {
            return false;
        }
    }

    //Listar um status por ID
    public function getById($idStatus) {
        try {

            $modelStatus = new modelStatus();
            return $modelStatus->getById($idStatus);

        } catch(PDOException $e) {
            return false;
        }
    }

    //Inserir novo status
    public function save($data) {
        try {

            $modelStatus = new modelStatus();
            return $modelStatus->save($data);

        } catch(PDOException $e) {
            return false;
        }
    }

    //Atualizar um status existente
    public function update($idStatus, $data) {
        try{

            $modelStatus = new modelStatus();
            return $modelStatus->update($idStatus, $data);

        } catch (PDOException) {

        }
    }

    //Deletar um status existente
    public function delete($idStatus) {
        try {

            $modelStatus = new modelStatus();
            return $modelStatus->delete($idStatus);

        } catch (PDOException $e) {
            return false;
        }
    }
}