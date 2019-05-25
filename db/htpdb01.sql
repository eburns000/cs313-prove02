-- SQL Statements
-- Home Therapy Program Database 01
-- Eric Burns (eburns000)
-- CS 313, Spring 19, Section 3

CREATE DATABASE htpdb01;

CREATE TABLE clinic (
	id              SERIAL         PRIMARY KEY,
	active          BOOLEAN        NOT NULL DEFAULT TRUE,
	clinic_name     VARCHAR(80)    NOT NULL UNIQUE
	);

CREATE TABLE account_type (
	id					 SERIAL			 PRIMARY KEY,
	active					 BOOLEAN	 		NOT NULL DEFAULT TRUE,
	account_type_name			 VARCHAR(80) 		NOT NULL UNIQUE
	);

CREATE TABLE discipline (
	id					 SERIAL	 		PRIMARY KEY,
	active					 BOOLEAN	 		NOT NULL DEFAULT TRUE,
	discipline_name				 VARCHAR(80)	 	NOT NULL UNIQUE
	);

CREATE TABLE modality (
	id					 SERIAL		 	PRIMARY KEY,
	active					 BOOLEAN	 		NOT NULL DEFAULT TRUE,
	modality_name				 VARCHAR(80) 		NOT NULL UNIQUE
	);

CREATE TABLE account (
	id					 SERIAL	 		PRIMARY KEY,
	assigned_clinic_id			 INT,
	account_type_id				 INT,
	assigned_therapist_id		 	INT,
	username				 VARCHAR(80)	 	NOT NULL UNIQUE,
	password				 VARCHAR(80)	 	NOT NULL,
	email					 VARCHAR(80)	 	NOT NULL UNIQUE,
	first_name				 VARCHAR(80),
	last_name				 VARCHAR(80),
	phone					 VARCHAR(80),
	my_points				 INT			 NOT NULL DEFAULT 0 CHECK (my_points >= 0), -- can't be negative
	active					 BOOLEAN		 	NOT NULL DEFAULT TRUE,
	new_account				 BOOLEAN		 	NOT NULL DEFAULT TRUE,	
	locked					 BOOLEAN		 	NOT NULL DEFAULT FALSE,
	created_on				 TIMESTAMP	 	WITH TIME ZONE NOT NULL DEFAULT NOW(),	
	last_login				 TIMESTAMP	 	WITH TIME ZONE,
	FOREIGN KEY (assigned_clinic_id) 	 REFERENCES clinic (id) 			 ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (account_type_id) 		 REFERENCES account_type (id) 		 ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (assigned_therapist_id)  	REFERENCES account (id) 		 ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE exercise (
	id					 SERIAL		 	PRIMARY KEY,
	discipline_id		 		INT	 		NOT NULL,
	modality_id			 	INT		 	NOT NULL,
	active				 	BOOLEAN	 		NOT NULL DEFAULT TRUE,
	exercise_name		 		VARCHAR(80) 		NOT NULL,
	assignment			 	TEXT,
	video_link			 	VARCHAR(255),
	FOREIGN KEY (discipline_id) 		 REFERENCES discipline (id) 		 ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (modality_id) 		 REFERENCES modality (id) 		 ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE assigned_exercise (
	account_id			 	INT	 		NOT NULL,
	exercise_id			 	INT	 		NOT NULL,
	assigned_date			 	DATE 			NOT NULL DEFAULT CURRENT_DATE,
	active					 BOOLEAN 			NOT NULL DEFAULT TRUE,
	point_value				 INT	 		NOT NULL DEFAULT 0 CHECK (point_value >= 0),
	completed				 BOOLEAN 			NOT NULL DEFAULT FALSE,
	PRIMARY KEY (account_id, exercise_id),	-- each exercise id can only be assigned to a client once
	FOREIGN KEY (account_id) 	 	REFERENCES account (id) 	 	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (exercise_id) 	 	REFERENCES exercise (id)	 	ON DELETE RESTRICT ON UPDATE CASCADE
	);
