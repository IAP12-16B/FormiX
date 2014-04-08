CREATE DATABASE Formulargenerator;



CREATE TABLE Formulargenerator.test_form
(
  id                INT                             NOT NULL AUTO_INCREMENT,

  checkbox_check1   TINYINT(1) DEFAULT 1 COMMENT "Checkbox",
  checkbox_check2_req TINYINT(1) NOT NULL COMMENT "Checkbox (Required)",
  radio_country      ENUM('CH', 'DE', 'FR', 'AU', 'US', 'GB') COMMENT "Land (not required)",
  radio_prefix      ENUM('Herr', 'Frau', 'Anderes') NOT NULL COMMENT "Anrede",
  text_firstname         VARCHAR(80)     COMMENT "Vorname",
  text_name         VARCHAR(80)         DEFAULT "Bob"            NOT NULL COMMENT "Name (required)",
  text_message      TEXT COMMENT "Message",
  text_blub      TEXT NOT NULL COMMENT "Message2",
  select_option     ENUM('MySQL', 'MariaDB', 'CouchDB', 'Redis')        NOT NULL COMMENT "Database",
  select_option2     ENUM('Linux', 'Solaris', 'Mac OS X', 'OpenBSD/FreeBSD', 'M$\ Windoof') DEFAULT "Linux" COMMENT "OS",
  password_pw       VARCHAR(150)                    NOT NULL COMMENT "Password",
  date_date         DATE                            NOT NULL COMMENT "Date",
  time_time         TIME COMMENT "Time" NOT NULL,
  datetime_datetime DATETIME COMMENT "Datetime",
  number_number1    INT COMMENT "Number",
  number_price      DOUBLE                          NOT NULL COMMENT "Price",
  number_price2      FLOAT                           COMMENT "Price" DEFAULT 5.20,
  undefined_test      NUMERIC NOT NULL,

  PRIMARY KEY (id)
);

CREATE TABLE Formulargenerator.real_form (
  id INT AUTO_INCREMENT,
  radio_prefix ENUM('Herr', 'Frau', 'Anderes') NOT NULL COMMENT "Anrede*",
  text_firstname VARCHAR(50) NOT NULL COMMENT "Vorname*",
  text_lastname VARCHAR(50) NOT NULL COMMENT "Nachname*",
  text_street VARCHAR(190) COMMENT "Strasse",
  text_plz VARCHAR(5) COMMENT "PLZ",
  text_ort VARCHAR(100) COMMENT "Ort",
  select_country ENUM('Schweiz', 'Östereich', 'Deutschland', 'Frankreich', 'Italien', 'Lichtenstein') NOT NULL DEFAULT "Schweiz" COMMENT "Land*",
  date_birthdate DATE NOT NULL COMMENT "Geburtstag*",
  datetime_appointment DATETIME NOT NULL COMMENT "Termin*",
  number_persons TINYINT NOT NULL COMMENT "Anzahl Personen*",
  text_message TEXT COMMENT "Mitteilung",
  checkbox_tos TINYINT(1) NOT NULL  COMMENT "Ich akzeptiere die AGBs!",

  PRIMARY KEY (id)

);

CREATE TABLE Formulargenerator.test_form2 (
    id INT AUTO_INCREMENT,
    text_normaltextinput VARCHAR(100) COMMENT "Normal Text",
    text_requiredtextinput VARCHAR(100) NOT NULL COMMENT "Required Text",
    text_defaultvaluetextinput VARCHAR(100) DEFAULT "Test" COMMENT "Default value Text",
    text_shorttextinput VARCHAR(5) COMMENT "Short Text",
    text_fulltext TEXT COMMENT "Text",
    text_requiredfulltext TEXT NOT NULL COMMENT "Required Text",
    checkbox_checkbox TINYINT(1) COMMENT "Checkbox",
    checkbox_requiredcheckbox TINYINT(1) NOT NULL COMMENT "Required Checkbox",
    checkbox_checked_checkbox TINYINT(1) DEFAULT 1 COMMENT "Checked Checkbox",
    password_password VARCHAR(100) COMMENT "Password",
    password_requiredpassword VARCHAR(100) NOT NULL COMMENT "Required Password",
    date_date DATE COMMENT "Date",
    date_requireddate DATE NOT NULL COMMENT "Required Date",
    date_defaultvaluedate DATE DEFAULT "2014-04-9" COMMENT "Default value Date",
    time_time TIME COMMENT "Time",
    time_requiredtime TIME NOT NULL COMMENT "Required Time",
    time_defaultvaluetime TIME DEFAULT "12:00:00" COMMENT "Default value Time",
    datetime_datetime DATETIME COMMENT "Datetime",
    datetime_requireddatetime DATETIME NOT NULL COMMENT "Required Datetime",
    datetime_defaultvaluedatetime DATETIME DEFAULT "2014-04-9 12:00:00" COMMENT "Default value Datetime",
    number_number INT COMMENT "Number",
    number_requirednumber INT NOT NULL COMMENT "Required Number",
    number_defaultvaluenumber INT DEFAULT 66 COMMENT "Default value Number",
    number_floatnumber DOUBLE COMMENT "Float Number",
    number_requiredfloatnumber DOUBLE  NOT NULL COMMENT "Required Float Number",
    number_defaultvaluefloatnumber DOUBLE DEFAULT 3.1415 COMMENT "Default value Float Number",
    radio_radio ENUM('R', 'A', 'D', 'I', 'O') COMMENT "Radio",
    radio_requiredradio ENUM('Test', 'Example', 'Table', 'DB') NOT NULL COMMENT "Required Radio",
    radio_defaultvalueradio ENUM('Test', 'Example', 'Table', 'DB') DEFAULT "Table" COMMENT "Default value Radio",
    select_select ENUM('R', 'A', 'D', 'I', 'O') COMMENT "Select",
    select_requiredselect ENUM('Test', 'Example', 'Table', 'DB') NOT NULL COMMENT "Required Select",
    select_defaultvalueselect ENUM('Test', 'Example', 'Table', 'DB') DEFAULT "Table" COMMENT "Default value Select",

    undefined_undefined INT COMMENT "This should not be shown!",

    PRIMARY KEY (id)
);