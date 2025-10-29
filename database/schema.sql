CREATE DATABASE IF NOT EXISTS contact_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE contact_app;

CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone VARCHAR(50) NOT NULL,
  message TEXT NOT NULL,
  user_agent VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Example entry
INSERT INTO contacts (name, email, phone, message)
VALUES
('Test User', 'test@example.com', '0821234567', 'This is a test message.');