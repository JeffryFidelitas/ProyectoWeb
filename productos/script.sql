CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT NOT NULL,
  precio DECIMAL(10, 2) NOT NULL,
  cantidad_disponible DECIMAL(10, 2) NOT NULL,
  foto VARCHAR(255) NOT NULL,
  id_productor INT NOT NULL,
  FOREIGN KEY (id_productor) REFERENCES usuarios(id) ON DELETE CASCADE
);

ALTER TABLE productos
ADD COLUMN activo BOOLEAN DEFAULT TRUE;

INSERT INTO `productos` (`nombre`, `descripcion`, `precio`, `cantidad_disponible`, `foto`, `id_productor`) VALUES
('Tomate Orgánico', 'Tomate fresco cultivado sin pesticidas.', 2.50, 100, 'https://cdn.pixabay.com/photo/2016/03/26/16/44/tomatoes-1280859_640.jpg', 2),
('Lechuga Orgánica', 'Lechuga crujiente y fresca.', 1.20, 50, 'https://elpoderdelconsumidor.org/wp-content/uploads/2022/08/lechuga-b.jpg', 2),
('Zanahoria Orgánica', 'Zanahorias dulces y frescas, perfectas para ensaladas.', 1.80, 75, 'https://www.gastronomiavasca.net/uploads/image/file/3440/w700_zanahoria.jpg', 2);
