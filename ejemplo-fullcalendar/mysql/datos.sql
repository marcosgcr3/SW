/*
  Recuerda que deshabilitar la opción "Enable foreign key checks" para evitar problemas a la hora de importar el script.
*/
TRUNCATE TABLE `Usuarios`;

/*
  La contraseña para ambos usuarios es '12345' 
  pasword_hash('$2y$10$0eR.KhfTH5ybn/jlB86hwe/1nQeCKXk2RcLEjBscJbpUaF504kSOi', PASSWORD_DEFAULT) == '12345'
*/
INSERT INTO `Usuarios` (`id`, `username`, `password`) VALUES
(1, 'user@example.org', '$2y$10$0eR.KhfTH5ybn/jlB86hwe/1nQeCKXk2RcLEjBscJbpUaF504kSOi'),
(2, 'admin@example.org', '$2y$10$0eR.KhfTH5ybn/jlB86hwe/1nQeCKXk2RcLEjBscJbpUaF504kSOi');


TRUNCATE TABLE `Eventos`;

SET @INICIO := NOW();
SET @CURRENT_DATE := DATE(@INICIO);
INSERT INTO `Eventos`(`userId`, `title`, `startDate`, `endDate`) VALUES
(1, 'Evento 1', ADDTIME(CONVERT(@CURRENT_DATE, DATETIME), '9:0:0'), ADDTIME(CONVERT(@CURRENT_DATE, DATETIME), '10:0:0')),
(1, 'Evento 2', ADDTIME(CONVERT(@CURRENT_DATE, DATETIME), '11:0:0'), ADDTIME(CONVERT(@CURRENT_DATE, DATETIME), '12:0:0')),
(1, 'Evento 3', ADDTIME(CONVERT(@CURRENT_DATE, DATETIME), '14:0:0'), ADDTIME(CONVERT(@CURRENT_DATE, DATETIME), '15:30:0')),
(1, 'Evento 4', ADDTIME(CONVERT(DATE_ADD(@CURRENT_DATE, INTERVAL 1 DAY), DATETIME), '13:0:0'), ADDTIME(CONVERT(DATE_ADD(@CURRENT_DATE, INTERVAL 1 DAY), DATETIME), '15:30:0'))
;
