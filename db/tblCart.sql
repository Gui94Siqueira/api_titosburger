/*
Entidade: Carrinho
id
id_user
expired_at
created_at
updated_at
*/
CREATE TABLE tblCart(
    id_cart INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    expired_at DATETIME NOT NULL,
    created_at DATETIME,
    updated_at DATETIME
);