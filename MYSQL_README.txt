Pro nastavení databáze vložte v MYSQL do konzole tyto pøíkazy:

CREATE DATABASE poodle CHARACTER SET utf8 COLLATE utf8_czech_c;

CREATE TABLE poodle.userLoginInformation(id INT PRIMARY KEY AUTO_INCREMENT NOT NULL , username VARCHAR(55) NOT NULL , passwordHash VARCHAR(100) NOT NULL , firstLastName VARCHAR(55) NOT NULL , email VARCHAR(55) NOT NULL , accountBalance INT NOT NULL, isAdmin BOOLEAN NOT NULL DEFAULT 0, isBanned BOOLEAN NOT NULL DEFAULT 0);

CREATE TABLE poodle.uploaded(id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(100), authorid INT NOT NULL, PRIMARY KEY (id), FOREIGN KEY(authorid) REFERENCES userlogininformation(id));

CREATE TABLE poodle.burza(id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(500) NOT NULL, contact VARCHAR(100) NOT NULL, authorid INT NOT NULL, PRIMARY KEY (id), FOREIGN KEY(authorid) REFERENCES userlogininformation(id));
