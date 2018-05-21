CREATE TABLE log
(
  id bigint PRIMARY KEY NOT NULL AUTO_INCREMENT,
  correlation_id int NOT NULL,
  log_level varchar(255),
  message varchar(255)
);
CREATE UNIQUE INDEX log_id_uindex ON log (id);