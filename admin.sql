CREATE DATABASE hotel_booking;

USE hotel_booking;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255)
);
-- Create the database
CREATE DATABASE hotel_booking;
USE hotel_booking;

-- Create the users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Insert sample users
INSERT INTO users (name, email, role)
VALUES
('Admin User', 'admin@example.com', 'admin'),
('John Doe', 'john.doe@example.com', 'user'),
('Jane Smith', 'jane.smith@example.com', 'user');

-- Create the hotels table
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) DEFAULT NULL
);

-- Insert sample hotels
INSERT INTO hotels (name, price, image)
VALUES
('Hotel Sunrise', 120.50, 'uploads/sunrise.jpg'),
('Mountain View Resort', 150.00, 'uploads/mountain.jpg'),
('Ocean Breeze Hotel', 100.00, 'uploads/ocean.jpg');

