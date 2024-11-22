CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'empleado', 'cliente') NOT NULL
);

CREATE TABLE donas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sabor VARCHAR(50) NOT NULL,
    stock INT NOT NULL
);

CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_dona INT,
    cantidad INT,
    fecha DATETIME,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id),
    FOREIGN KEY (id_dona) REFERENCES donas(id)
);

CREATE TABLE devoluciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT,
    motivo VARCHAR(255),
    fecha DATETIME,
    FOREIGN KEY (id_venta) REFERENCES ventas(id)
);


INSERT INTO usuarios (username, password, role) VALUES
('admin', '$2y$10$4F9Z1Qz2A/XpY6g02DU0ze.6Yc3V7ohVBlYXIf1a7NeTRi.l1fKQe', 'admin'); -- Contraseña: admin123
