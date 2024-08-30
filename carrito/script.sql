CREATE TABLE carrito (
  	id INT AUTO_INCREMENT PRIMARY KEY,
	cantidad INT NOT NULL,
    	id_producto INT NOT NULL,
    	id_usuario INT NOT NULL,
    	FOREIGN KEY (id_producto) REFERENCES productos(id) ON DELETE CASCADE,
    	FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE facturas (
  	id INT AUTO_INCREMENT PRIMARY KEY,
	total INT NOT NULL,
    tarjeta INT NOT NULL,
    direccion VARCHAR(500) NOT NULL,
    detalles VARCHAR(500) NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);