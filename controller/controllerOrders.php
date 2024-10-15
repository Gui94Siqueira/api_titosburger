<?php

    class controllerOrders {
        public function listOrdersByClient($id_user) {
            try{

                $modelOrders = new modelOrders();
                return $modelOrders->listOrderByClient();

            } catch(PDOException $e) {
                return false;
            }
        }

        public function createOrder($data) {
            try{

                $modelOrders = new modelOrders();
                return $modelOrders->createOrder($data);

            } catch(PDOException $e){
                return false;
            }
        }

        public function detailOrderById($id) {
            try{

                $modelOders = new modelOrders();
                return $modelOders->detailOrderById($id);

            } catch(PDOException $e) {
                return false;
            }
        }
        
        public function listOrdersByStatus($id_status) {
            try{

                $modelOders = new modelOrders();
                return $modelOders->listOrdersByStatus($id_status);

            } catch(PDOException $e) {
                return false;
            }
        }

        public function createCard($data) {
            try{

                $modelOrders = new modelOrders();
                return $modelOrders->createCard($data);
            } catch(PDOException $e) {
                return false;
            }
        }
        
        public function listAllOrders() {
            try{

                $modelOrders = new modelOrders();
                return $modelOrders->listAllOrders($data);
            } catch(PDOException $e) {
                return false;
            }
        }

        public function insertItenCard($data) {
            try{

                $modelOrders = new modelOrders();
                return $modelOrders->insertItenCard($data);
            } catch(PDOException $e) {
                return false;
            }
        }

    
        public function updateOrder($id, $data) {
            try{

                $modelOders = new modelOrders();
                return $modelOders->updateOrder($id, $data);

            } catch(PDOException $e) {
                return false;
            }
        }
    }

?>