CREATE DATABASE org_structure;

CREATE USER 'newuser'@'127.0.0.1' IDENTIFIED BY 'M4yP@ssw0rd!';

GRANT ALL PRIVILEGES ON org_structure.* TO 'newuser'@'127.0.0.1';