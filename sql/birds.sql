-- Database: 'birdwatching' and php web application user. 
-- This database represents a birdwatcher's log. In it, the user logs
-- the bird species name(s), the number of observed birds, the date,
-- and an optional picture.

CREATE DATABASE birdwatching;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON birdwatching.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE birdwatching;

-- Defining structure for table 'local_birds'. This table represents
-- the user's observations of local (Ottawa) bird species.

CREATE TABLE IF NOT EXISTS local_birds (
  bird_id         int(11)       NOT NULL AUTO_INCREMENT,
  common_name     varchar(45)   NOT NULL,
  latin_name      varchar(45)   NOT NULL,
  number_of_birds int(11)       NOT NULL,      
  date_observed   date          NOT NULL,
  img             varchar(200)  NULL,
  PRIMARY KEY (bird_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- Inserting data into table 'local_birds'. Information about bird common and latin names taken from [1].

INSERT INTO local_birds (bird_id, common_name, latin_name, number_of_birds, date_observed) 
VALUES
    (1, 'Canada goose', 'Branta canadensis', 4, '2022-04-05'),
    (2, 'Northern cardinal', 'Cardinalis cardinalis', 1, '2022-02-15'),
    (3, 'House sparrow', 'Passer domesticus', 8, '2022-03-07'),
    (4, 'Blue jay', 'Cyanocitta cristata', 1, '2022-01-24');

-- Reference cited (References 2-5 refer to the images provided in the /imgs folder):
-- [1] Avibase, "Ottawa bird checklist - Avibase - Bird Checklists of the World,"" Avibase - The World Bird Database. https://avibase.bsc-eoc.org/checklist.jsp?region=CAonoc&list=howardmoore (accessed Apr. 05, 2022).
-- [2] F. Cone, A Peregrine Falcon Perched on a Tree Branch. 2020. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/a-peregrine-falcon-perched-on-a-tree-branch-5247923/
-- [3] J. Pishyari, Wilds Ducks Paddling on in Icy Lake. 2021. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/wilds-ducks-paddling-on-in-icy-lake-7102264/
-- [4] B. Sayles, Flock of Canada geese soaring in sky during migration. 2021. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/flock-of-canada-geese-soaring-in-sky-during-migration-7651244/
-- [5] T. Nord, Photo of Northern Cardinal Perched on Brown Tree Branch. 2020. Accessed: Apr. 12, 2022. [Photography]. Available: https://www.pexels.com/photo/photo-of-northern-cardinal-perched-on-brown-tree-branch-3647326/
