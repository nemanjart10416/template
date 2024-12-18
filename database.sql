-- Drop the database if it exists and create a new one
DROP DATABASE IF EXISTS db_name;
CREATE DATABASE db_name;

-- Switch to the new database
USE db_name;

-- Create the 'users_u' table
CREATE TABLE users_u
(
    u_id          INT PRIMARY KEY AUTO_INCREMENT,
    u_uuid        VARCHAR(255) NOT NULL UNIQUE,
    u_email       VARCHAR(255) NOT NULL UNIQUE,
    u_username    VARCHAR(255) NOT NULL UNIQUE,
    u_password    VARCHAR(255) NOT NULL,
    u_lastLogin  datetime              DEFAULT NULL,
    u_updatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    u_createdAt  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rate_limits_rl
(
    rl_ip           VARCHAR(45) NOT NULL,
    rl_attempts     INT         NOT NULL DEFAULT 0,
    rl_lastAttempt TIMESTAMP            DEFAULT CURRENT_TIMESTAMP,
    oi_updatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    oi_createdAt  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (rl_ip)
);
