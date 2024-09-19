<?php

class controllerProducts
{
    public function save($data)
    {
        try {

            $modelProducts = new modelProducts();
            return $modelProducts->save($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listAll()
    {
        try {

            $modelProducts = new modelProducts();
            return $modelProducts->listAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function searchById($id)
    {
        try {

            $modelProducts = new modelProducts();
            return $modelProducts->searchById($id);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function listByCategory($id_category) {
        try {
            
            $modelProducts = new modelProducts();
            return $modelProducts->listByCategory($id_category);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {

            $modelProducts = new modelProducts();
            return $modelProducts->update($id, $data);
        } catch(PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {

            $modelProducts = new modelProducts();
            return $modelProducts->delete($id);
        } catch(PDOException $e) {
            return false;
        }
    }
}
