/*
Entidade: Usuarios
id
username
pass_user
firstname
lastname
birthday
cpf
mail
id_status
created_at
updated_at
*/
CREATE TABLE tblUsers (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(15) NOT NULL,
    lastname VARCHAR(10)  NOT NULL,
    username VARCHAR(15) NOT NULL,
    pass_user VARCHAR(120) NOT NULL,
    birthday DATE NOT NULL,
    cpf INT NOT NULL,
    mail VARCHAR(30) NOT NULL,
    id_status INT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (id_status) REFERENCES tblStatus(id_status)
);