CREATE DATABASE IF NOT EXISTS kilimo_high_school;

USE kilimo_high_school;

CREATE TABLE IF NOT EXISTS class_streams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    class_stream_id INT,
    FOREIGN KEY (class_stream_id) REFERENCES class_streams(id)
);
