CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(100) NOT NULL,
  name VARCHAR(50) NOT NULL,
  role ENUM('user', 'admin', 'productor') DEFAULT 'user' NOT NULL
);


INSERT INTO `usuarios` (`email`, `password`, `name`, `role`) VALUES
('admin@email.com', '$2y$10$d6POOPxvzXHrTHBT./UyAe.bZFH90l1ZWDpfZZ7i7mCZEY5DejzNq', 'Admin', 'admin');