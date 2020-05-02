
DROP DATABASE IF EXISTS project;
CREATE DATABASE project;
USE project;

SET NAMES utf8;

CREATE TABLE building(
buildingName VARCHAR(100),
latitude DOUBLE,
longitude DOUBLE
);

CREATE TABLE room(
buildingName VARCHAR(100),
roomNumber VARCHAR(10),
type VARCHAR(50),
seats INTEGER,
responsiblePerson VARCHAR(100)
);

CREATE TABLE feature(
featureName VARCHAR(50),
iconCode CHAR(8)
);

CREATE TABLE reservation(
buildingName VARCHAR(100),
roomNumber VARCHAR(10),
reservedFrom DATETIME,
reservedTo DATETIME,
personWhoReserved VARCHAR(50),
subject VARCHAR(100)
);

CREATE TABLE roomfeature(
buildingName VARCHAR(100),
roomNumber VARCHAR(10),
featureName VARCHAR(30)
);

CREATE TABLE message(
buildingName VARCHAR(100),
roomNumber VARCHAR(10),
message VARCHAR(100)
);

----- Constraints -----
ALTER TABLE building ADD CONSTRAINT pk_building PRIMARY KEY(buildingName);

ALTER TABLE room ADD CONSTRAINT pk_room PRIMARY KEY(buildingName, roomNumber);

ALTER TABLE reservation ADD CONSTRAINT pk_reservation PRIMARY KEY(buildingName, roomNumber, reservedFrom, reservedTo);

ALTER TABLE feature ADD CONSTRAINT pk_feature PRIMARY KEY(featureName);

ALTER TABLE roomfeature ADD CONSTRAINT pk_roomfeature PRIMARY KEY (buildingName, roomNumber, featureName);

ALTER TABLE message ADD CONSTRAINT pk_message PRIMARY KEY(buildingName, roomNumber, message);

ALTER TABLE room ADD CONSTRAINT fk_room_building FOREIGN KEY(buildingName) REFERENCES building(buildingName);

ALTER TABLE reservation ADD CONSTRAINT fk_reservation_room FOREIGN KEY(buildingName, roomNumber) REFERENCES room(buildingName, roomNumber);

ALTER TABLE roomfeature ADD CONSTRAINT fk_roomfeature_feature FOREIGN KEY(featureName) REFERENCES feature(featureName);

ALTER TABLE roomfeature ADD CONSTRAINT fk_roomfeature_room FOREIGN KEY(buildingName, roomNumber) REFERENCES room(buildingName, roomNumber);

ALTER TABLE message ADD CONSTRAINT fk_message_room FOREIGN KEY(buildingName, roomNumber) REFERENCES room(buildingName, roomNumber);

----- Building Data ----
INSERT INTO building 
	VALUES('ФМИ', 42.674735, 23.330535);
    
INSERT INTO building 
	VALUES('ФХФ', 42.674929, 23.332668);    

INSERT INTO building 
	VALUES('ФЗФ', 42.674038, 23.329663);
    
INSERT INTO building 
	VALUES('Ректорат', 42.674735, 23.334752);
  
---- Features Data ----
INSERT INTO feature
	VALUES('Проектор', '&#xf03d;');
    
INSERT INTO feature 
	VALUES('Компютър', '&#xf108;');

INSERT INTO room
    VALUES('ФМИ', '200', 'Семинарна зала', 150, 'Трифон Трифонов');

INSERT INTO room
    VALUES('ФХФ', '210', 'Семинарна зала', 200, 'Милен Петров');

INSERT INTO room
    VALUES('ФМИ', '325', 'Семинарна зала', 100, 'Тинко Тинчев');

INSERT INTO roomfeature
    VALUES('ФМИ', 325, 'Проектор');

INSERT INTO roomfeature
VALUES('ФМИ', 325, 'Компютър');

INSERT INTO roomfeature
VALUES('ФХФ', '210', 'Проектор');

INSERT INTO reservation
	VALUES('ФМИ', '200', '2020-01-01 10:10:10','2020-01-01 11:10:10','Милен Петров','Уеб');

INSERT INTO reservation
	VALUES('ФМИ', '325', '2020-01-01 10:10:10','2020-01-01 11:10:10','Тинко Тинчев','ЛП');

INSERT INTO message
    VALUES('ФМИ', '200', 'Залата е в ремонт');

INSERT INTO message
    VALUES('ФМИ', '325', 'В залата няма ток');
