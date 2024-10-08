<?php

class controllerUsers
{
    public function listAll()
    {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->listAll();
        } catch (PDOException) {
            return false;
        }
    }

    public function save($data)
    {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->save($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getById($id)
    {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->getById($id);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id_user, $data)
    {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->update($id_user, $data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->delete($id);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function auth($data)
    {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->auth($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function recoveryPassword($data) {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->recoveryPassword($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function validationToken($data) {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->validationToken($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function validationEmail($data) {
        try {
            $modelUsers = new modelUsers();
            return $modelUsers->validationEmail($data);
        } catch (PDOException $e) {
            return false;
        }
    }

}
