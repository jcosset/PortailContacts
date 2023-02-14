List tree um
create table mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, mode varchar(255))

create table liste_mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, listeID int not null, modeID int NOT null,
FOREIGN KEY (listeID) REFERENCES liste(id), FOREIGN KEY (modeID) REFERENCES mode_diffusion(id)
)

create table poste_liste_mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, posteID int not null, listeID int not null, modeID int NOT null,
FOREIGN KEY (posteID) REFERENCES poste(id), FOREIGN KEY (listeID) REFERENCES liste(id), FOREIGN KEY (modeID) REFERENCES mode_diffusion(id)
)

Formananager
Gestion poste
accronyme poste
14/12
ALTER TABLE Contact
ADD COLUMN telephone VARCHAR(255) null,
ADD COLUMN email_pro VARCHAR(255) null

ALTER TABLE Contact
ADD COLUMN commentaire_niv_2 LONGTEXT null,

Ajout Email_pro, telephone table, commentaire niv 2 contact

16/12/2022
create table address(id INT AUTO_INCREMENT PRIMARY KEY, Rue varchar(255), Compl varchar(255),
CP int, Ville varchar(255), Pays varchar(255),
)
ALTER TABLE address
ADD COLUMN cedex VARCHAR(255),

ALTER TABLE contact
ADD COLUMN addressID int;
ALTER TABLE contact ADD FOREIGN KEY (addressID) REFERENCES address(id);

CRUD LISTE

# 06/02/2023

Entite adresse mail
Mail Non obligatoire
Ajouter des étoiles fields
Migrer github flag

Finaliser

Entite
Poste
Cont

Ajout poste liste de diffusion directement modal modif poste

===========
Civilite Table
==========

// @i@

The problem
The problem consists in rendering events on a calendar, avoiding overlapping events to visually overlap.
Your implementation should meet the two following constraints:

Every overlapping event should have the same width as every event it overlaps
Every event should use the maximum width available while satisfying constraint 1

A visual illustration of the problem is given below.
Rendering events on a calendar means here: the relative position of events to the top of the screen and their height is a function of the height of the screen, the start/end time of the calendar, and the start time/duration of the events. For example: if the calendar goes from 00:00 to 24:00 and the screen is 2400px high, an event starting at 12:00 and lasting 1h would be positioned at 1200px of the top of the screen and have a height of 100px.
Using the maximum width available here implies that the width of every group of mutually overlapping events equals the width of the window.

The input
The input (available below) is an array of events occurring on the same date. They have the following structure:

[
{
"id": 1,
"start": "17:00",
"duration": 60
},
{
"id": 2,
"start": "17:00",
"duration": 120
},
{
"id": 3,
"start": "19:40",
"duration": 10
},
{
"id": 4,
"start": "15:00",
"duration": 20
},
{
"id": 5,
"start": "18:00",
"duration": 60
},
{
"id": 6,
"start": "10:25",
"duration": 35
},
{
"id": 7,
"start": "10:45",
"duration": 30
},
{
"id": 8,
"start": "17:00",
"duration": 60
},
{
"id": 9,
"start": "10:00",
"duration": 30
},

]

The output
Your code should render the events on a webpage in a container spanning the whole window.
The top of the page represents 09:00 am. The bottom of the page represents 09:00 pm.
The events should be represented as a div with a background color and a 1px border. The div should display the event's id.
Your implementation should be responsive (i.e. respond to window resize events).

Visual illustration of the problem
1 event
|

2 events

||
|

3 events where events 1, 2 and 3 overlap, but events 1 and 3 do not

|
|
|
|

The configuration above meets all constraints. Be careful, something like below would not meet constraint 2 :
|
|
|

If we combine cases 1, 2 and 3, you should end up with something like
The schema below assumes the width of event 1 equals the width of the window.

    	|

    | |
    |

    |
    		|

| |
| |
|

Satisfying both constraints
The schema below assumes the width of event 1 equals the width of the window.

[{start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}, {start: 1, end:2}]
