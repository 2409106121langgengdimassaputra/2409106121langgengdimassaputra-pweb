CREATE DATABASE db_topup_uc;
USE db_topup_uc;

CREATE TABLE topup_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(50) NOT NULL,
    paket_uc INT NOT NULL,
    metode_bayar VARCHAR(50) NOT NULL,
    tanggal_topup TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    username_admin VARCHAR(50)
);

INSERT INTO topup_data (user_id, paket_uc, metode_bayar, username_admin) VALUES
('5123456789', 600, 'Dana', 'admin'),
('5987654321', 300, 'Gopay', 'admin');