
select * from track_your_money.coins;
select * from track_your_money.accounts;
select * from track_your_money.users;
select * from track_your_money.categories;
select * from track_your_money.transacctions;



use track_your_money;

# USER
INSERT INTO `users` (`name`,`lastname`,`telephone`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) VALUES ('Marcos','Avila',84452340,'marcosab2794@gmail.com','$2y$10$ryDF3FoVmlppoKdn4pmEDeELv69E462gP89yaBQ/sjMav/XDeRXYi',NULL,'2019-08-12 02:52:30','2019-08-12 02:52:30');

# COINS
INSERT INTO `coins` (`user_id`,`small_name`,`symbol`,`description`,`rate`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'CRC','₡','Colon Costa Rica',1,1,NULL,'2019-08-12 03:25:16','2019-08-12 05:29:03');
INSERT INTO `coins` (`user_id`,`small_name`,`symbol`,`description`,`rate`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'USD','$','Dolar Estados Unidos',545,1,NULL,'2019-08-12 03:25:36','2019-08-12 03:25:36');
INSERT INTO `coins` (`user_id`,`small_name`,`symbol`,`description`,`rate`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,'EUR','€','Euro',750,1,NULL,'2019-08-13 04:36:38','2019-08-13 04:36:38');

# CATEGORY
INSERT INTO `categories` (`user_id`,`father_cat`,`category`,`type`,`description`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,null,'Vivienda','Expense','Articulas para el hogar',1,NULL,'2019-08-12 03:24:42','2019-08-12 05:29:15');
INSERT INTO `categories` (`user_id`,`father_cat`,`category`,`type`,`description`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,1,'Construccion','Expense','Materiales de construccion',1,NULL,'2019-08-12 03:28:20','2019-08-13 04:40:12');
INSERT INTO `categories` (`user_id`,`father_cat`,`category`,`type`,`description`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,null,'Salario','Income','Pago mensual del salario',1,NULL,'2019-08-13 04:39:25','2019-08-13 04:39:25');

# ACCOUNT
INSERT INTO `accounts` (`user_id`,`coin`,`small_name`,`description`,`initial_amount`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,1,'Coocique RL','Cuenta en colones Coocique',50191,1,NULL,'2019-08-12 03:27:00','2019-08-12 04:59:55');
INSERT INTO `accounts` (`user_id`,`coin`,`small_name`,`description`,`initial_amount`,`available`,`remember_token`,`created_at`,`updated_at`) VALUES (1,2,'Banco Nacional','Cuenta en dolares',100,1,NULL,'2019-08-12 03:26:14','2019-08-13 04:37:38');

# Transacctions

INSERT INTO `transacctions` (`user_id`,`type`,`acount`,`id_account`,`category`,`detail`,`amount`,`remember_token`,`created_at`) VALUES (1,'Expense','Coocique RL',1,'Vivienda','Compra de cortinas',-5000,NULL,'2019-08-11');
INSERT INTO `transacctions` (`user_id`,`type`,`acount`,`id_account`,`category`,`detail`,`amount`,`remember_token`,`created_at`) VALUES (1,'Expense','Coocique RL',1,'Vivienda','Compra de bombillos',-10000,NULL,'2019-08-12');
INSERT INTO `transacctions` (`user_id`,`type`,`acount`,`id_account`,`category`,`detail`,`amount`,`remember_token`,`created_at`) VALUES (1,'Income','Coocique RL',1,'Transfer','Dinero para universidad',10000,NULL,'2019-08-12');
INSERT INTO `transacctions` (`user_id`,`type`,`acount`,`id_account`,`category`,`detail`,`amount`,`remember_token`,`created_at`) VALUES (1,'Expense','Coocique RL',1,'Transfer','Dinero para universidad',-10000,NULL,'2019-08-12');
INSERT INTO `transacctions` (`user_id`,`type`,`acount`,`id_account`,`category`,`detail`,`amount`,`remember_token`,`created_at`) VALUES (1,'Income','Coocique RL',1,'Transfer','Transferencia para pago de luz.',2000,NULL,'2019-08-12');
INSERT INTO `transacctions` (`user_id`,`type`,`acount`,`id_account`,`category`,`detail`,`amount`,`remember_token`,`created_at`) VALUES (1,'Expense','Coocique RL',1,'Transfer','Transferencia para pago de luz.',-2000,NULL,'2019-08-12');


