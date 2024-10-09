<?php

class controllerUsers {

    public function save($data) {
        try {         
           
            $modelUsers = new modelUsers();
            return $modelUsers->save($data);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function saveGroup($id_user, $group) {
        try {
            
            $modelUsers = new modelUsers();
            return $modelUsers->saveGroup($id_user, $group);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function auth($data) {
        try {

            $modelUsers = new modelUsers();
            return $modelUsers->auth($data);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function generateTwoFactor($data) {
        try {

            $modelUsers = new modelUsers();
            return $modelUsers->generateTwoFactor($data);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function validateTwoFactor($data) {
        try {
        
            $modelUsers = new modelUsers();
            return $modelUsers->validateTwoFactor($data);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function listAll() {
        try {
            
            $modelUsers = new modelUsers();
            return $modelUsers->listAll();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function searchById($id) {
        try {
            
            $modelUsers = new modelUsers();
            return $modelUsers->searchById($id);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
         
            $modelUsers = new modelUsers();
            return $modelUsers->delete($id);
            
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {
            
            $modelUsers = new modelUsers();
            return $modelUsers->update($id, $data);

        } catch (PDOException $e) {
            return false;
        }
    }

}