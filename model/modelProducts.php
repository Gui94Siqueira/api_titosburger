<?php


class modelProducts
{
    public function save($data)
    {
        try {

            $name = htmlspecialchars($data["product_name"], ENT_NOQUOTES);
            $image = htmlspecialchars($data["image"], ENT_NOQUOTES);
            $price = filter_var($data["price"], FILTER_SANITIZE_NUMBER_FLOAT);
            $description = htmlspecialchars($data["description"], ENT_NOQUOTES);
            $id_category = filter_var($data['id_category'], FILTER_SANITIZE_NUMBER_INT);
            $id_status = filter_var($data["id_status"], FILTER_SANITIZE_NUMBER_INT);

            $sql = "INSERT INTO tbl_product (product_name, image, price, description, id_category, id_status, creted_at) VALUES
            (':product_name, :image, :price, :description, :id_category, :id_status', now())";
            $conn = ConnectionDB::connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_name', $name);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':id_category', $id_category);
            $stmt->bindParam(':id_status', $id_status);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function listAll() {
        try {

            $conn = connectionDB::connect();
            $list = $conn->query("SELECT * FROM tbl_product");
            $result = $list->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function searchById($id) {
        try {

            $conn = connectionDB::connect();
            $product = $conn->prepare("SELECT * FROM tbl_product WHERE id = :id");
            $product->bindParam(':id', $id);
            $product->execute();

            $result = $product->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function listByCategory($id_category) {
        try {

            $conn = connectionDB::connect();
            $product = $conn->prepare("SELECT * FROM tbl_product WHERE id_category = :id_category");
            $product->bindParam(':id_category', $id_category);
            $product->execute();

            $result = $product->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {}

    public function delete($id) {}
}
