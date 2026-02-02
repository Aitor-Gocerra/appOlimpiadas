CREATE DATABASE olimpiadas;
USE  olimpiadas;

CREATE TABLE IF NOT EXISTS Deportes (
  idDeporte tinyint unsigned AUTO_INCREMENT PRIMARY KEY,
  nombreDep varchar(15) NOT NULL,
  imagen varchar(255) NULL
  ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
  
CREATE TABLE IF NOT EXISTS Usuarios (
  idUsuario smallint unsigned AUTO_INCREMENT PRIMARY KEY,
  nombreUsuario varchar(30) NOT NULL UNIQUE,
  apeNombre varchar(60) NOT NULL,
  password varchar(100) NOT NULL,
  correo varchar(60) NOT NULL,
  telefono char(9) NULL,
  perfil ENUM('c', 'u') NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
CREATE TABLE IF NOT EXISTS Usuarios_deportes (
	idDeporte tinyint unsigned NOT NULL,
	idUsuario smallint unsigned NOT NULL,
	PRIMARY KEY (idDeporte, idUsuario),
    FOREIGN KEY (idDeporte) REFERENCES Deportes(idDeporte) ON DELETE CASCADE,
    FOREIGN KEY (idUsuario) REFERENCES Usuarios(idUsuario) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Deportes(nombreDep, imagen) VALUES
			('fútbol', NULL),
			('baloncesto', NULL),
			('padel', NULL),
			('tenis de mesa', NULL);
	
		
INSERT INTO Usuarios (nombreUsuario, apeNombre, password, correo, telefono, perfil) VALUES
('coordinador', 'Coordinador Escuelas Deportivas', '123456', 'CoordED@evg.es',  '654321123','c'),
('usuario1', 'usuario 1 Escuelas Deportivas', '1234', 'usuario1@evg.es',  '667788991','u'),
('usuario2', 'usuario 2 Escuelas Deportivas', '1234', 'usuario2@evg.es',  NULL,'u'),
('usuario3', 'usuario 3 Escuelas Deportivas', '1234', 'usuario3@evg.es',  NULL,'u'),
('usuario4', 'usuario 4 Escuelas Deportivas', '1234', 'usuario4@evg.es',  NULL,'u');


INSERT INTO Usuarios_deportes (idDeporte,idUsuario) VALUES
(1,2),
(3,2),
(3,4),
(1,5),
(2,5),
(3,5);
