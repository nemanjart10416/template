-- Drop the database if it exists and create a new one
DROP DATABASE IF EXISTS db_name;
CREATE DATABASE db_name;

-- Switch to the new database
USE db_name;

-- Create the 'users_u' table
CREATE TABLE users_u
(
    u_id         INT PRIMARY KEY AUTO_INCREMENT,
    u_uuid       VARCHAR(255) NOT NULL UNIQUE,
    u_email      VARCHAR(255) NOT NULL UNIQUE,
    u_username   VARCHAR(255) NOT NULL UNIQUE,
    u_password   VARCHAR(255) NOT NULL,
    u_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);