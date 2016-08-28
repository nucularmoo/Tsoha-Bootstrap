CREATE TABLE team(
	id INTEGER NOT NULL UNIQUE,
	name varchar(10) NOT NULL
);

CREATE TABLE trainer(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	password varchar(50) NOT NULL,
	team_id INTEGER REFERENCES team(id)
);

CREATE TABLE base_pokemon(
	dexnumber INTEGER NOT NULL UNIQUE,
	name varchar(50) NOT NULL
); 

CREATE TABLE pokemon(
	id SERIAL PRIMARY KEY,
	basemon_id INTEGER REFERENCES base_pokemon(dexnumber),
	overall_appraisal INTEGER,
	stats_appraisal INTEGER,
	caught_location varchar(400),
	cp INTEGER
);

CREATE TABLE pokedex(
	trainer_id INTEGER REFERENCES trainer(id),
	pokemon_id INTEGER REFERENCES pokemon(id)
);	
