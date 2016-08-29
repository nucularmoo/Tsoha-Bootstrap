## Johdanto

Työn aihe on tietokanta Pokemon GO pelille.

Tarkoituksena on luoda tietokanta sivulle rekisteröityneiden pelin pelaajien eli trainerien pyydystämille Pokémoneille.

Tietokanta tarjoaa rekisteröitymättömille sekä rekisteröityneille käyttäjille mahdollisuuden tarkastella mistä tietokantaan lisätyt Pokémonit on pyydystetty ja näin ollen tarjota
vihjeenomaista tietoa siitä, missä tiettyjen Pokémonien pyydystämistä voisi kannattaa yrittää.

Tietokanta tarjoaa rekisteröityneille, kirjautuneille käyttäjille myös mahdollisuuden tarkastella itse pyydystämiensä tietokantaan lisättyjen Pokémonien kiinnostavia tietoja kuten niiden
täydellisyysprosentteja. Kirjautuneet käyttäjät voivat myös halutessaan siistiä henkilökohtaista Pokédexiään poistamalla tarpeettomaksi näkemänsä Pokémonit tai muokata niiden tietoja.

Työ toteutetaan laitoksen users-palvelimella. Web-sovelluksen alustajärjestelmässä käytetään PHP:ta.

## Käyttötapaukset

### Pokemonin lisääminen
  Kirjautunut käyttäjä voi lisätä Pokémonin tietokantaan

### Pokemonin tietojen muuttaminen
  Kirjautunut käyttäjä voi muokata lisäämiensä Pokémonien tietoja

### Pokemonin poistaminen
  Kirjautunut käyttäjät voi poista lisäämänsä Pokémonin tietokannasta

### Pokemonien selaaminen
  Kaikki käyttäjät voivat selata tietokannan pokemoneja, kirjautuneet käyttäjät voivat myös selata erikseen itse lisäämiään Pokémoneja

### Muita käyttötapauksia
  Rekisteröityminen, kirjautuminen, tunnuksien muokkaus, tunnuksien poisto

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

## Tietokannan käyttöohje

Kirjautumaton käyttäjä voi selata etusivun julkista Pokémonien ja niiden pyyntipaikkojen listausta.

Kirjautumaton käyttäjä voi myös luoda itselleen käyttäjätilin sivustolle painamalla navigaatiopalkin Sign up-painiketta.
Luodessa käyttäjätilin, käyttäjän on annettava nimimerkki, salasana, sekä valita edustamansa joukkue.
Edustamansa joukkueen oikeellisuus on tärkeää, sillä tämä tieto auttaa trainereita arvioimaan Pokémoniensa vahvuuden itse peliapplikaation joukkuekohtaisten johtajien vihjeiden perusteella Pokémonien tietokantaan lisäämis- ja muokkaamisvaiheessa.
Jos kuitenkin tiliä luodessa trainer on vahingossa valinnut väärän joukkueen, voi trainer muokata tilinsä tietoja ja näin korjata edustamansa joukkueen oikeaksi.

Kirjautunut käyttäjä eli trainer voi tämän lisäksi lisätä pyydystämiensä Pokémonien tietoja sekä muokata tai poistaa omia Pokémonejaan.

Lisätessään Pokémonin, trainer valitsee pyydystämänsä Pokémonin tyypin valikosta sekä lisää muut Pokémonin lisäykseen vaadittavat tiedot.

Appraisal-valikoista oikeita vaihtoehtoja valitessaan on trainerin konsultoitava Pokémon GO applikaatiostaan joukkueensa johtajaa saadakseen tietää Pokémoninsa ominaisuuksista.

Appraisal-valikot tarjoavat joukkuekohtaiset dialogi-vaihtoehdot trainerin käyttäjätiliin merkityn joukkueen mukaisesti.

Trainerien toivotaan lisäävän mahdollisimman tarkka Pokémonin pyydyspaikka tietokantaan, jotta samanlajisia Pokémoneja metsästävät trainerit voisivat käyttää tietokannan antamia tietoja mahdollisista metsästysapajista hyväkseen.


## Järjestelmän yleisrakenne

Tietokantasovellusta tehdessä on noudatettu MVC-mallia. Kontrollerit, näkymät ja mallit sijaitsevat hakemistoissa controllers, views ja models.
Käytetyt apukirjastot on sijoitettu hakemistoon lib ja asetukset ovat tiedostossa settings.php.

Näkymät on jaettu views-kansiossa mallien perusteella kansioihin.

* Käyttäjä (user)
* Kirjautuneen käyttäjän Pokémonit (mon)
* Kirjautumattoman käyttäjän näkymät (puplik)

Kontrollerit on jaettu mallien perusteella:

* Pokemonkontrolleri (mon_controller.php)
* Käyttäjäkontrolleri (user_controller.php)

#####Istunto

Rekisteröityneellä käyttäjällä eli trainerilla on käyttäjätunnus, joka on liitetty tietokannassa trainer-taulukkoon.

Kirjautuneen käyttäjän lisätessä Pokémon tietokantaan valitaan istunnon perusteella käyttäjän henkilökohtaiseen Pokédexiin oikea käyttäjä (toteuttamatta).
Kirjautuneen käyttäjän katsellessa tai muokatessa käyttäjätilinsä tietoja istuntoa käytetään varmistamaan että kirjautunut käyttäjä voi katsella ja muokata vain omia käyttäjätilinsä tietoja.
Kirjautuneen käyttäjän katsellessa tarkemmin Pokémonin tietoja tai oman Pokédexinsä listausta käytetään istuntoa salliakseen käyttäjän nähdä Pokémonien lisää, muokkaa sekä poista-painikkeet.

#####Asetukset

Tähän pitää vielä lisätä jotain.

##Käyttöliittymä ja järjestelmän komponentit

Tähän pitää vielä lisätä jotain.

