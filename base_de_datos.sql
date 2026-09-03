-- USE sistema_inventario;

CREATE TABLE usuarios (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre_completo VARCHAR(100) NOT NULL,
 usuario VARCHAR(50) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 rol VARCHAR(20) NOT NULL
);

CREATE TABLE categorias (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre_categoria VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE productos (
 id INT AUTO_INCREMENT PRIMARY KEY,
 nombre_producto VARCHAR(100) NOT NULL,
 categoria_id INT NOT NULL,
 stock INT NOT NULL,
 precio DECIMAL(10, 2) NOT NULL,
 FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

INSERT INTO categorias (nombre_categoria) VALUES 
('Computadoras'),
('Accesorios'),
('Oficina');

INSERT INTO productos (nombre_producto, categoria_id, stock, precio) VALUES 
('Laptop Dell Inspiron 15', 1, 15, 720.00),
('Mouse Inalámbrico Logitech', 2, 25, 12.00);


-- REPORTES RELACIONALES AVANZADOS (Guía 11)

-- 1. Vista completa del inventario con categorías legibles

SELECT p.id,
       p.nombre_producto,
       c.nombre_categoria,
       p.stock,
       p.precio
FROM productos p
INNER JOIN categorias c
ON p.categoria_id = c.id;

-- 2. Vista filtrada para Accesorios

SELECT p.id,
       p.nombre_producto,
       c.nombre_categoria,
       p.stock,
       p.precio
FROM productos p
INNER JOIN categorias c
ON p.categoria_id = c.id
WHERE c.nombre_categoria = 'Accesorios';

-- ============================================
-- TABLA PROVEEDORES
-- ============================================

CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(100) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20),
    direccion TEXT
);

-- PROVEEDORES DE PRUEBA

INSERT INTO proveedores (nombre_empresa, contacto, telefono, direccion) VALUES
('Tech Data El Salvador', 'Juan Pérez', '2255-8899', 'San Salvador, Col. Escalón'),
('Distribuidora de Papel', 'María Gómez', '2666-4433', 'San Miguel, Centro');