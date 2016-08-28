CREATE TABLE trainer(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	password varchar(50) NOT NULL
);

CREATE TABLE base_pokemon(
	id INT NOT NULL,
	name varchar(50) NOT NULL
); 

CREATE TABLE pokemon(
	id SERIAL PRIMARY KEY,
	dexnumber INT NOT NULL,
	name varchar(50) NOT NULL,
	overall_appraisal INT,
	stats_appraisal INT,
	caught_location varchar(400),
	cp INT
);

CREATE TABLE pokedex(
	trainer_id INTEGER REFERENCES trainer(id),
	pokemon_id INTEGER REFERENCES pokemon(id)
);	
