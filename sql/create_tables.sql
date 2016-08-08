CREATE TABLE trainer(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	password varchar(50) NOT NULL
);

CREATE TABLE typedesc(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL
);

CREATE TABLE attack(
	id SERIAL PRIMARY KEY,
	name varchar(50) NOT NULL,
	damage DECIMAL NOT NULL,
	dps DECIMAL NOT NULL,
	typedesc_id INTEGER REFERENCES typedesc(id)
); 

CREATE TABLE pokemon(
	id SERIAL PRIMARY KEY,
	dexnumber INT NOT NULL,
	name varchar(50) NOT NULL,
	typedesc_a_id INTEGER REFERENCES typedesc(id),
	typedesc_b_id INTEGER REFERENCES typedesc(id),
	attack INT,
	defense INT,
	stamina INT,
	evolution_id INTEGER REFERENCES pokemon(id),
	jauheliha INT
);

CREATE TABLE pokemonmoves(
	pokemon_id INTEGER REFERENCES pokemon(id),
	attack_id INTEGER REFERENCES attack(id)
);

CREATE TABLE pokedex(
	trainer_id INTEGER REFERENCES trainer(id),
	pokemon_id INTEGER REFERENCES pokemon(id)
);

CREATE TABLE super_effective(
	strong_type_id INTEGER REFERENCES typedesc(id),
	weak_type_id INTEGER REFERENCES typedesc(id)
);
	
