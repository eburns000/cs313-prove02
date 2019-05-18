-- SQL Statements
-- Home Therapy Program Database 01
-- Eric Burns (eburns000)
-- CS 313, Spring 19, Section 3

CREATE DATABASE htpdb01;

CREATE TABLE clinic (
	id						serial			PRIMARY KEY,
	active					boolean			NOT NULL DEFAULT TRUE,
	clinic_name				varchar(80)		NOT NULL UNIQUE
	);

CREATE TABLE account_type (
	id						serial			PRIMARY KEY,
	active					boolean			NOT NULL DEFAULT TRUE,
	account_type_name		varchar(80)		NOT NULL UNIQUE
	);

CREATE TABLE discipline (
	id						serial			PRIMARY KEY,
	active					boolean			NOT NULL DEFAULT TRUE,
	discipline_name			varchar(80)		NOT NULL UNIQUE
	);

CREATE TABLE modality (
	id						serial			PRIMARY KEY,
	active					boolean			NOT NULL DEFAULT TRUE,
	modality_name			varchar(80)		NOT NULL UNIQUE
	);

CREATE TABLE account (
	id						serial			PRIMARY KEY,
	assigned_clinic_id		int,
	account_type_id			int,
	assigned_therapist_id	int,
	username				varchar(80)		NOT NULL UNIQUE,
	password				varchar(80)		NOT NULL,
	email					varchar(80)		NOT NULL UNIQUE,
	first_name				varchar(80),
	last_name				varchar(80),
	phone					varchar(80),
	my_points				int				NOT NULL DEFAULT 0 CHECK (my_points >= 0), -- can't be negative
	active					boolean			NOT NULL DEFAULT TRUE,
	new_account				boolean			NOT NULL DEFAULT TRUE,	
	locked					boolean			NOT NULL DEFAULT FALSE,
	created_on				timestamp		WITH TIME ZONE NOT NULL DEFAULT NOW(),	
	last_login				timestamp		WITH TIME ZONE,
	FOREIGN KEY (assigned_clinic_id) 		REFERENCES clinic (id) 			ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (account_type_id) 			REFERENCES account_type (id) 	ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (assigned_therapist_id) 	REFERENCES account (id) 		ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE exercise (
	id						serial			PRIMARY KEY,
	discipline_id			int				NOT NULL,
	modality_id				int				NOT NULL,
	active					boolean			NOT NULL DEFAULT TRUE,
	exercise_name			varchar(80)		NOT NULL,
	assignment				text,
	video_link				varchar(255),
	FOREIGN KEY (discipline_id) 			REFERENCES discipline (id) 		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (modality_id) 				REFERENCES modality (id) 		ON DELETE RESTRICT ON UPDATE CASCADE
	);

CREATE TABLE assigned_exercises (
	account_id				int				NOT NULL,
	exercise_id				int				NOT NULL,
	assigned_date			date			NOT NULL DEFAULT CURRENT_DATE,
	active					boolean			NOT NULL DEFAULT TRUE,
	point_value				int				NOT NULL DEFAULT 0 CHECK (point_value >= 0),
	completed				boolean			NOT NULL DEFAULT FALSE,
	PRIMARY KEY (account_id, exercise_id),	-- each exercise id can only be assigned to a client once
	FOREIGN KEY (account_id) 				REFERENCES account (id) 		ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (exercise_id) 				REFERENCES exercise (id)		ON DELETE RESTRICT ON UPDATE CASCADE
	);






	

