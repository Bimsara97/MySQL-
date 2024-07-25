-- Create the database
CREATE DATABASE user_management;

-- Use the database
USE user_management;

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL
);

-- Insert some sample data
INSERT INTO users (username, password, email) VALUES ('admin', 'adminpass', 'admin@example.com');
INSERT INTO users (username, password, email) VALUES ('user', 'userpass', 'user@example.com');
