CREATE DATABASE Formulargenerator;


CREATE TABLE Formulargenerator.test_form
(
  id                INT                             NOT NULL AUTO_INCREMENT,
  checkbox_check1   TINYINT(1) COMMENT "Checkbox",
  radio_prefix      ENUM('Herr', 'Frau', 'Anderes') NOT NULL COMMENT "Anrede",
  text_name         VARCHAR(80)         DEFAULT "Bob"            NOT NULL COMMENT "Name",
  text_message      TEXT COMMENT "Message",
  select_option     ENUM('MySQL', 'MariaDB', 'CouchDB', 'Redis')        NOT NULL COMMENT "Database",
  password_pw       VARCHAR(150)                    NOT NULL COMMENT "Password",
  date_date         DATE                            NOT NULL COMMENT "Date",
  time_time         TIME COMMENT "Time",
  datetime_datetime DATETIME COMMENT "Datetime",
  number_number1    INT COMMENT "Number",
  number_price      DOUBLE                          NOT NULL COMMENT "Price"
  PRIMARY KEY (id)
);
