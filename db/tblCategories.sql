/*
Entidade: Categorias
id
category
image
id_status
created_at
updated_at
*/
CREATE TABLE tblCategories(
    id_category INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(20) NOT NULL,
    image VARCHAR(50),
    id_status INT NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (id_status) REFERENCES tblStatus(id_status)
);