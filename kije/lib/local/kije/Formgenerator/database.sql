CREATE DATABASE Formulargenerator;

CREATE TABLE Formulargenerator.test_form
(
  id                INT                             NOT NULL AUTO_INCREMENT,
  checkbox_check1   TINYINT(1),
  radio_prefix      ENUM('Herr', 'Frau', 'Anderes') NOT NULL,
  text_name         VARCHAR(80)                     NOT NULL,
  text_message      TEXT,
  select_option     ENUM('MySQL', 'MariaDB')        NOT NULL,
  password_pw       VARCHAR(150)                    NOT NULL,
  date_date         DATE                            NOT NULL,
  time_time         TIME,
  datetime_datetime DATETIME,
  number_number1    INT,
  number_price      DOUBLE                          NOT NULL,

  PRIMARY KEY (id)
);
