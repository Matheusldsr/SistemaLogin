Create database sistemalogin;
CREATE TABLE corretores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cpf VARCHAR(11) UNIQUE NOT NULL,
    creci VARCHAR(8) NOT NULL
);
