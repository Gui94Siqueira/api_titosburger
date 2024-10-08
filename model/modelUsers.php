<?php

    class modelUsers {

        protected $salt = "Tit0s@2024";

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

        public function save($data) {
            try {
                $firstname = htmlspecialchars($data['firstname'], ENT_NOQUOTES);
                $lastname = htmlspecialchars($data['lastname'], ENT_NOQUOTES);
                // usuário e E-mail = username
                $username = htmlspecialchars($data['username'], ENT_NOQUOTES);
                $password = htmlspecialchars($data['password'], ENT_NOQUOTES);
                $birthday = htmlspecialchars($data['birthday'], ENT_NOQUOTES);
                $cpf = filter_var($data['cpf'], FILTER_SANITIZE_NUMBER_INT);

                // Permissão
                $permission = htmlspecialchars($data['permission'], ENT_NOQUOTES);

                //Irá chamar a função de criptografia de senha
                $password_secure = $this->tokenize($password);

                $conn = connectionDB::connect();
                $save = $conn->prepare("INSERT INTO tbl_users VALUES (':firstname', ':lastname', ':username', ':password_secure', ':birthday', ':cpf', ':mail', 1, NOW() )");
                $save->bindParam(":firstname", $firstname);
                $save->bindParam(":lastname", $lastname);
                $save->bindParam(":username", $username);
                $save->bindParam(":password_secure", $password_secure);
                $save->bindParam(":birthday", $birthday);
                $save->bindParam(":cpf", $cpf);
                $save->bindParam(":mail", $mail);
                $save->execute();



            }catch(PDOException $e) {
                return false;
            }
        }

        protected function tokenize($value) {
            try {

                $combinedPassoword = $value . $this->salt;
                return password_hash($combinedPassoword, PASSWORD_BCRYPT);

            } catch (\Throwable $th) {
                return false;
            }
        }

        public function searchUserByEmail($username) {
            try{
                $conn = connectionDB::connect();
                $search = $conn->prepare("SELECT id_user FROM tbl_users WHERE username = ':username' ");
                $search->bindParam(":username", $username);
                $search->execute();
                $result = $search->fetch(PDO::FETCH_ASSOC);

                return $result;

            } catch(PDOException $e) {
                return false;
            }
        }

        public function saveGroup($id_user,  $group) {
            try {
                $conn = connectionDB::connect();
                $saveGroup = $conn->query("INSERT INTO tbl_usersRoles VALUES (:id_user, :group) ");
                $saveGroup->bindParam(':id_user', $id_user);
                $saveGroup->bindParam(':group', $group);
                $saveGroup->execute();

                return true;
            } catch(PDOException $e) {
                return false;
            }
        }

        public function authentication($data) {
            try {

                $username = htmlspecialchars($data['username'], ENT_NOQUOTES);

                $conn = connectionDB::connect();
                $auth = $conn ->prepare("SELECT * FROM tbl_users WHERE username = ':username'");
                $auth->bindParam(':username', $username);
                $auth->execute();
                $result = $auth->fetch(PDO::FETCH_ASSOC);

                if($result) {
                    $passwordDB = $result->pass_user;

                    $validatePassword = password_verify($data->passord . $this->salt, $passwordDB);

                    if($validatePassword) {
                        return $result;
                    } else {
                        return false;
                    }
                }
            } catch (PDOException $e) {
                return false;
            }
        }

        public function generateTwoFactor($data) {
            try {
                //Dados recebidos da requisição
                $username = htmlspecialchars($data['username'], ENT_NOQUOTES);
                
                //Expiração do token em 15minutos
                $expired_at = date('d/m/Y H:i:s', time() + (15 * 60));

                // Gerar token com a data e hora atual com nome do usuario
                $token = md5(date('d/m/Y H:i:s') . $data->username );
                $finalToken = substr($token, 6);

                // Gravar os dados do Token
                $conn = connectionDB::connect();
                
                $saveToken = $conn->prepare("INSERT INTO tbl_tokens VALUES (':token', ':username', ':expired_at') ");
                $saveToken->bindParam(':token', $finalToken);
                $saveToken->bindParam(':username', $username);
                $saveToken->bindParam(':expired_at', $exprired_at);

                if($saveToken) {
                    // Texto do corpo do email
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
                $username = htmlspecialchars($data['username'], ENT_NOQUOTES);

                $conn = connectionDB::connect();
                $validate = $conn->prepare("SELECT * FROM tbl_tokens WHERE username = ':username' AND token = ':token'");
                $validate->bindParam(':username', $username);
                $validate->bindParam(':token', $token);
                $validate->execute();

                $result = $validate->fetch(PDO::FETCH_ASSOC);

                // Obter data e hora atual
                $now = date('d/m/Y H:i:s');

                // Converter data atula para validar a expiração
                $date = strtotime($now);

                //converter data expiração para validar
                $expired_at = strtotime($result['expired_at']);

                $deleteToken = $conn->prepare("DELETE FROM tbl_tokens WHERE username = ':username', AND token = ':token'");
                $deleteToken->bindParam(':username', $username);
                $deleteToken->bindParam(':token', $token);
                $deleteToken->execute();

                // validar se a data e hora atula é superior a data de expiração
                if($date > $expired_at) {
                    return false;
                } else {
                    return true;
                }

            } catch(PDOException $e) {
                return false;
            }
        }   

        public function getById($id) {
            try {
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

                $conn = connectionDB::connect();
                $search = $conn->prepare("SELECT * FROM tbl_users WHERE id = :id");
                $search->bindParam(':id', $id);
                $search->execute();

                $user = $search->fetch(PDO::FETCH_ASSOC);

                return $user;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function update($id, $data) {
            try {
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
                $firstname = htmlspecialchars($data("firstname", ENT_NOQUOTES));
                $lastname = htmlspecialchars($data['lastname'], ENT_NOQUOTES);
                $mail = htmlspecialchars($data['mail'], ENT_NOQUOTES);
                $password = htmlspecialchars($data['password'], ENT_NOQUOTES);
                $status = filter_var($data['status'], FILTER_SANITIZE_NUMBER_INT);

            } catch(PDOException $e) {
                return false;
            }
        }

        public function delete($id) {
            try {
                $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

                $conn = connectionDB::connect();
                $delete = $conn->prepare("DELETE FROM tbl_users WHERE id = :id");
                $delete->bindParam(':id', $id);
                $delete->execute();

                return true;

            } catch(PDOException $e) {
                return false;
            }
        }
    }

?>