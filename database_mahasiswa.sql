CREATE DATABASE IF NOT EXISTS mahasiswa

USE mahasiswa;

DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS prodi;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE prodi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
);

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(120) NOT NULL,
    nim VARCHAR(30) NOT NULL UNIQUE,
    prodi_id INT NOT NULL,
    avatar VARCHAR(255) DEFAULT null,
    FOREIGN KEY (prodi_id) REFERENCES prodi(id) ON DELETE CASCADE
);

INSERT INTO users (username, password)
VALUES ('Kapa', 'kapa');

INSERT INTO prodi (nama)
VALUES
    ('Teknik Informatika'),
    ('Teknik Multimedia Digital'),
	('Teknik Multimedia dan Jaringan');

INSERT INTO mahasiswa (nama, nim, prodi_id, avatar)
VALUES
    ('Muhammad Islami Kaffah', '2507411004', 1, 'Muhammad Kaffah'),
    ('Muhammad Desra Zaidan', '1111111111', 2, 'Desra Zaidan'),;
    ('Muhammad Ikhwan', '2222222222', 3, 'Muhammad Ikhwan');
