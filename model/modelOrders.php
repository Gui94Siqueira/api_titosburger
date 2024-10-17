<?php

include_once ("../services/connectionDB.php");

class modelOrders {

        public function listOrderByClient($id_user) {
            try{

                $id = filter_var($id_user, FILTER_SANITIZE_NUMBER_INT);

                $conn = connectionDB::connect();
                $list = $conn->prepare("SELECT * FROM tbl_orders WHERE id_user = :id_user");
                $list->bindParam(':id_user', $id);
                $list->execute();

                $result = $list->fetchAll(PDO::FETCH_ASSOC);

                return $result;

            } catch (PDOException $e) {
                return false;
            }
        }

        public function listAllOrders() {
            try {

                $conn = connectionDB::connect();
                $listAll = $conn->query("SELECT * FROM tbl_orders");
                $result = $listAll->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function listOrdersByStatus($id_status) {
            try{

                $conn = connectionDB::connect();
                $list = $conn->prepare("SELECT * FROM tbl_orders WHERE id_status = :id_status");
                $list->bindParam(":id_status", $id_status);
                $list->execute();

                $result = $list->fetchAll(PDO::FETCH_ASSOC);

                return $result;

            }catch(PDOException $e) {
                return false;
            }
        }

        public function listOrdersByClient() {

        }

        public function createOrder($data) {

        }

        public function detailOrderById($id) {

        }

        public function createCard($data) {
            try{

                $id_user = filter_var($data['id_user'], FILTER_SANITIZE_NUMBER_INT);
                
                $fuso = new DateTimeZone('America/Sao_Paulo');
                $dataHoraAtual = new DateTime();
                $dataHoraAtual->setTimezone($fuso);

                $dataHoraAtual->modify('+1 days');
                $expired_at = $dataHoraAtual->format('Y-m-d H:i:s');


                $conn = connectionDB::connect();
                $create = $conn->prepare("INSERT INTO tbl_cart (id_user, expired_at, created_at VALUES(:id_user, :expired_at, NOW())");
                $create->bindParam(':id_user', $id_user);
                $create->bindParam('expired_at', $expired_at);
                $create->execute();

                return true;

            } catch(PDOException $e){
                return false;
            }
        }

        public function deleteCart($id_cart) {
            try{

                $id = filter_var($id_cart, FILTER_SANITIZE_NUMBER_INT);
                
                $conn = connectionDB::connect();
                $delete = $conn->prepare('DELETE FROM tbl_itensCart WHERE id_cart = :id_cart');
                $delete->bindParam(':id_cart', $id);
                $delete->execute();

                if($delete){

                    $deleteCart = $conn->prepare("DELETE FROM tbl_cart WHERE id_cart = :id_Cart");
                    $deleteCart->bindParam('id_cart', $id_cart);
                    $deleteCart->execute();

                    return true;

                } else {
                    return true;
                }                

            } catch(PDOException $e){
                return false;
            }
        }

        public function insertItenCard($data) {
            try{

                $id_cart = filter_var($data['id_cart'], FILTER_SANITIZE_NUMBER_INT);
                $id_product = filter_var($data['id_product'], FILTER_SANITIZE_NUMBER_INT);
                $price_product = filter_var($data['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                $qtd = filter_var($data['qtd'], FILTER_SANITIZE_NUMBER_INT);

                $conn = connectionDB::connect();
                $cart = $conn->prepare("INSERT INTO tbl_itensCart (id_cart, id_product, price_product, qtd, created_at) VALUES 
                                        (:id_card, :id_product, :price_product, :qtd, NOW())");
                $cart->bindParam(":id_cart", $id_cart);
                $cart->bindParam(":id_product", $id_product);
                $cart->bindParam(":price_product", $price_product);
                $cart->bindParam(":qtd", $qtd);
                $cart->execute();

                return true;

            } catch(PDOException $e) {
                return false;
            }
        }

        public function updateOrder($id, $data) {

        }
}

?>