/*
Entidade: Endereços usuários
id
id_user
address
address1
city
state
created_at
updated_at
*/
CREATE TABLE tblAddressUser(
    id_address INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    address VARCHAR(20) NOT NULL,
    address1 VARCHAR(20) NOT NULL,
    city VARCHAR(20) NOT NULL,
    state VARCHAR(20) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME
);