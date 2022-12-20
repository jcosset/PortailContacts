List tree um
create table mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, mode varchar(255))

create table liste_mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, listeID int not null, modeID int NOT null,
  FOREIGN KEY (listeID) REFERENCES liste(id), FOREIGN KEY (modeID) REFERENCES mode_diffusion(id)
                                 )

create table poste_liste_mode_diffusion(id INT AUTO_INCREMENT PRIMARY KEY, posteID int not null, listeID int not null, modeID int NOT null,
 FOREIGN KEY (posteID) REFERENCES poste(id),  FOREIGN KEY (listeID) REFERENCES liste(id), FOREIGN KEY (modeID) REFERENCES mode_diffusion(id)
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
