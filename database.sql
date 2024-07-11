DROP DATABASE IF EXISTS db_name;
CREATE DATABASE db_name;

USE db_name;

-- Table user
CREATE TABLE users_u
(
    u_id        INT PRIMARY KEY AUTO_INCREMENT,
    u_uuid      VARCHAR(255) NOT NULL UNIQUE,
    u_email     VARCHAR(255) NOT NULL UNIQUE,
    u_name      VARCHAR(255) NOT NULL,
    u_last_name VARCHAR(255) NOT NULL,
    u_password  VARCHAR(255) NOT NULL CHECK (LENGTH(korisnik_sifra) >= 8),
    u_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
