## Johdanto

Työn aihe on tietokanta Pokemon GO pelille.

Tarkoituksena on luoda tietokanta pelin pelaajien pyydystämille Pokémoneille ja näiden kiinnostaville attribuuteille kuten esimerkiksi sille, mistä pelaajat ovat löytäneet tiettyjä Pokémoneja.

Loppuvaiheessa toivottavaa olisi, että tietokannassa olisi kirjautumismahdollisuus jotta käyttäjät voisivat tietokantaa käyttäen
tallentaa sekä muokata omia pokemonkokoelmiaan.

Työ toteutetaan laitoksen users-palvelimella. Web-sovelluksen alustajärjestelmässä käytetään joko Javaa tai PHP:ta.

## Käyttötapaukset

### Pokemonin lisääminen
  Kirjautunut käyttäjä voi lisätä Pokémonin tietokantaan

### Pokemonin tietojen muuttaminen
  Kirjautunut käyttäjä voi muokata lisäämiensä Pokémonien tietoja

### Pokemonien selaaminen
  Kaikki käyttäjät voivat selata tietokannan pokemoneja, kirjautuneet käyttäjät voivat myös selata erikseen itse lisäämiään Pokémoneja

### Muita käyttötapauksia
  Rekisteröityminen, kirjautuminen

### Käyttötapauskaavio:

![Kayttotapauskaavio](kayttotapauskaavio.png)

## Tietokannan tietosisältö

### Tietokannan käsitekaavio:

![Kasitekaavio](kasitekaavio_v2.png)

### Tietokohde: Trainer
Attribuutti | Arvojoukko | Kuvaus
-------- | ------ | ------
Id | Kokonaisluku, PK | Trainerin tunniste
Name | Merkkijono, max 50 merkkiä | Trainerin käyttäjätunnus
Password | Merkkijono, max 50 merkkiä | Trainerin salasana
Team | Kokonaisluku, FK | Trainerin joukkue

### Tietokohde: Team
Attribuutti | Arvojoukko | Kuvaus
-------- | ----------| ---------
Id | Kokonaisluku, PK | Joukkueen tunniste
Name | Merkkijono, max 10 merkkiä | Joukkueen nimi

### Tietokohde: Base Pokemon
Attribuutti | Arvojoukko | Kuvaus
------- | -------- | -------
Dexnumber | Kokonaisluku, PK | Pokémonin dexnumero
Name | Merkkijono, max 50 merkkiä | Pokémonin nimi

### Tietokohde: Pokemon
Attribuutti | Arvojoukko | Kuvaus
------| ---------| -------
Id | Kokonaisluku, PK | Kerätyn Pokémonin tunniste
Basemon_id | Kokonaisluku, FK | Kyseisen Pokémonin basetyyppi
Overall appraisal | Kokonaisluku | Pokémonin täydellisyysprosentin arvoluvun arviointi
Stats appraisal | Kokonaisluku | Pokémonin bonus Individual Value (IV) arvoluvun arviointi
Caught location | Merkkijono, max 400 merkkiä | Paikka josta Pokémon pyydystettiin
CP | Kokonaisluku | Pokémonin Combat Power 

### Tietokohde: Pokedex
Attribuutti | Arvojoukko | Kuvaus
------ | ------ | ------
Trainer | Kokonaisluku, FK | Kyseinen trainer
Pokemon | Kokonaisluku, FK | Kyseisen trainerin keräämä Pokémon

### Tietokannan relaatiotietokantakaavio:

![Relaatiotietokantakaavio](relaatiotietokantakaavio.png)

## Tietokannan (alustava) käyttöohje

Kirjautumaton käyttäjä voi sivun yläreunasta valitsemalla linkin Pokédex selata tietokantaan lisättyjä Pokémoneja ja niiden tietoja.

Kirjautunut käyttäjä eli trainer voi tämän lisäksi lisätä pyydystämiensä Pokémonien tietoja sekä muokata tai poistaa omia Pokémonejaan.

Lisätessään Pokémonin, trainerin on lisättävä joitakin perustietoja Pokémonistaan kuten nimi ja pokedexnumero.

Appraisal-tietueisiin tietoa lisätessään on trainerin konsultoitava Pokémon GO applikaatiostaan joukkueensa johtajaa saadakseen overall sekä stats appraisal arvot.

Koska kullakin appraisal-arvolla on neljä eri jakaumaa, on tietokantaan lisättävä tieto mukautettu lisättäväksi asteikolla 1-4.

Appraisal | 1 | 2 | 3 | 4 
------|-----|-----|-----|-----
Overall | 0%-50% | 51%-66% | 67%-79% | 80%-100%
Stats | max 0-7 bonus IV | max 8-12 bonus IV | max 13-14 bonus IV | max 15 bonus IV

Tarkemmat ohjeet joukkuekohtaisten johtajien antamien arvioiden tulkitsemiseksi ovat tulossa piakkoin.

Trainerien toivotaan lisäävän mahdollisimman tarkka Pokémonin pyydyspaikka tietokantaan, jotta samankaltaisia Pokémoneja metsästävät trainerit voisivat käyttää tietokannan antamia tietoja metsästysapajista hyväkseen.




