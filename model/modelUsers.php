<?php

include_once("../services/connectionDB.php");

class modelUsers {

    protected $salt = "Tit0s@2024";

    public function save($data) {
        try {
            $firstname = htmlspecialchars($data["firstname"], ENT_NOQUOTES);
            $lastname  = htmlspecialchars($data["lastname"], ENT_NOQUOTES);
            //Usuário e E-mail = username
            $username  = htmlspecialchars($data["username"], ENT_NOQUOTES);
            $mail  = htmlspecialchars($data["username"], ENT_NOQUOTES);
            $password  = htmlspecialchars($data["password"], ENT_NOQUOTES);
            $birthday  = htmlspecialchars($data["birthday"], ENT_NOQUOTES);
            $cpf       = filter_var($data["cpf"], FILTER_SANITIZE_NUMBER_INT);
            //Permissao
            $permission = htmlspecialchars($data["permission"], ENT_NOQUOTES);

            //Irá chamar a função de criptografia de senha
            $password_secure = $this->tokenize($password);

            $conn = connectionDB::connect();
            $save = $conn->prepare("INSERT INTO tbl_users (firstname, lastname, username, pass_user, birthday, cpf, mail, id_status, created_at) VALUES (:firstname, :lastname, :username, :password_secure, :birthday, :cpf, :mail, 1, NOW())");
            $save->bindParam(":firstname", $firstname);
            $save->bindParam(":lastname", $lastname);
            $save->bindParam(":username", $username);
            $save->bindParam(":password_secure", $password_secure);
            $save->bindParam(":birthday", $birthday);
            $save->bindParam(":cpf", $cpf);
            $save->bindParam(":mail", $mail);
            $save->execute();

            $data_user = $this->searchUserByEmail($username);

            $this->saveGroup($data_user['id_user'], $permission);

            return true;

        } catch (PDOException $e) {   
            echo $e;         
            return false;
        }
    }

    protected function tokenize($value){
        try {

            $combinedPassword = $value . $this->salt;
         
            return password_hash($combinedPassword, PASSWORD_BCRYPT);

        } catch (\Throwable $th) {
            return false;
        }
    }

    private function searchUserByEmail($username) {
        try {
            
            $conn = connectionDB::connect();
            $search = $conn->prepare("SELECT id_user FROM tblUsers WHERE username = :username");
            $search->bindParam(':username', $username);
            $search->execute();
            $result = $search->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function saveGroup($id_user, $group) {
        try {
            
            $conn = connectionDB::connect();
            $saveGroup = $conn->prepare("INSERT INTO tbl_users_roles (`id_user`, `group`, `created_at`) VALUES (:id_user, :group, NOW()) ");
            $saveGroup->bindParam(':id_user', $id_user);
            $saveGroup->bindParam(':group', $group);
            $saveGroup->execute();

            return true;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function auth($data) {
        try {

            $username = htmlspecialchars($data["username"], ENT_NOQUOTES);
            
            $conn = connectionDB::connect();
            $auth = $conn->prepare("SELECT * FROM tbl_users WHERE username = :username ");
            $auth->bindParam(':username', $username);
            $auth->execute();
            $result = $auth->fetch(PDO::FETCH_ASSOC);

            if($result) {
                $passwordDB = $result->pass_user;

                $validatePassword = password_verify($data->password . $this->salt, $passwordDB);

                if($validatePassword) {
                    return $result;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } catch (PDOException $e) {
            return false;
        }
    }

    public function generateTwoFactor($data) {
        try {

            //Dados recebidos da requisição
            $username = htmlspecialchars($data["username"], ENT_NOQUOTES);

            //Expiração do token em 15 minutos
            $expired_at = date('d/m/Y H:i:s', time() + (15 * 60));
            
            //Gerar token com a data e hora atual com nome do usuário
            $token = md5(date('d/m/Y H:i:s') . $data->username );
            $finalToken = substr($token, 6);

            //Gravar os dados do token
            $conn = connectionDB::connect();
            $saveToken = $conn->prepare("INSERT INTO tbl_tokens VALUES (:token, :username, :expired) ");
            $saveToken->bindParam(':token', $finalToken);
            $saveToken->bindParam(':username', $username);
            $saveToken->bindParam(':expired', $expired_at);
            $saveToken->execute();

            if($saveToken) {
                //Texto do corpo do e-mail
                $message = "Utilize o token: $finalToken";

                $sendMail = mail($username, 'Token', $message);

                if($sendMail) {
                    return true;
                } else {
                    return false;
                }
            }


        } catch (PDOException $e) {
            return false;
        }
    }

    public function validateTwoFactor($data) {
        try {
        
            $token = htmlspecialchars($data["token"], ENT_NOQUOTES);
            $username = htmlspecialchars($data["username"], ENT_NOQUOTES);
            
            $conn = connectionDB::connect();
            $validate = $conn->prepare("SELECT * FROM tbl_tokens WHERE username = :username AND token = :token");
            $validate->bindParam(':username', $username);
            $validate->bindParam(':token', $token);
            $validate->execute();
            $result = $validate->fetch(PDO::FETCH_ASSOC);

            //Obter data e hora atual
            $now = date('d/m/Y H:i:s');
            //Converter data atual para validar a expiração
            $date = strtotime($now); //121354545
            //Converter data expiração para validar
            $expired_at = strtotime($result["expired_at"]); //112545454           

            //Deletar o token após uso
            $deleteToken = $conn->prepare("DELETE FROM tbl_tokens WHERE username = :username AND token = :token");
            $deleteToken->bindParam(":username", $username);
            $deleteToken->bindParam(":token", $token);
            $deleteToken->execute();

            //Validar se a date e hora atual é superior a data expiração
            if($date > $expired_at) {
                return false;
            } else {
                return true;
            }

        } catch (PDOException $e) {
            return false;
        }
    }

    public function listAll() {
        try {
            
            $conn = connectionDB::connect();
            $list = $conn->query("SELECT * FROM tbl_users");
            $result = $list->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function searchById($id) {
        try {
            
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            $conn = connectionDB::connect();
            $search = $conn->prepare("SELECT * FROM tbl_users WHERE id_user = :id_user");
            $search->bindParam(":id_user", $id);
            $search->execute();
            $result = $search->fetch(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
         
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

            $conn = connectionDB::connect();
            $delete = $conn->prepare("DELETE FROM tbl_users WHERE id_user = :id_user");
            $delete->bindParam(":id_user", $id);
            $delete->execute();

            return true;
            
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {
            
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            $firstname = htmlspecialchars($data["firstname"], ENT_NOQUOTES);
            $lastname = htmlspecialchars($data["lastname"], ENT_NOQUOTES);
            $mail = htmlspecialchars($data["mail"], ENT_NOQUOTES);
            $password = htmlspecialchars($data["password"], ENT_NOQUOTES);
            $status = filter_var($data["status"], FILTER_SANITIZE_NUMBER_INT);

            $conn = connectionDB::connect();
            $update = $conn->prepare("UPDATE tbl_users SET firstname = :firstname, lastname = :lastname, mail = :mail, pass_user = :password, id_status = :status, updated_at = NOW() WHERE id_user = :id_user ");
            $update->bindParam(':firstname', $firstname);
            $update->bindParam(':lastname', $lastname);
            $update->bindParam(':mail', $mail);
            $update->bindParam(':password', $password);
            $update->bindParam(':status', $status);
            $update->execute();

            return true;

        } catch (PDOException $e) {
            return false;
        }
    }

}