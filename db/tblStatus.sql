/*
Entidade: Status
id
status
created_at
updated_at
*/
CREATE TABLE tblStatus(
    id_status INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(20) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME 
);