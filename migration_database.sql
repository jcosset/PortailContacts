CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
);
CREATE TABLE `contact_tag` (
  `id` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL
);
CREATE TABLE `entite_tag` (
  `id` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `id_entite` int(11) NOT NULL
);
CREATE TABLE `poste_tag` (
  `id` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `id_poste` int(11) NOT NULL
);
Alter table Entite add column acronyme varchar(255);
Alter table Entite add column tel varchar(16);
Alter table Entite add column adresse_geo int;
Alter table Entite add column adresse_postale int;
Alter table Entite add column site varchar(255);
Alter table Entite add column logo varchar(255);
Alter table Poste add column acronyme varchar(255);
Alter table Poste add column adresse int;
Alter table Poste add column email_secretariat varchar(255);
Alter table Poste add column tel_secretariat varchar(255);
Alter table Poste add column tel varchar(16);
ALTER table address MODIFY CP int;
ALTER table Poste drop column Rue;
ALTER table Poste drop column CP;
ALTER table Poste drop column Ville;
ALTER table Poste drop column Pays;
Alter table Entite add column compl_geo varchar(255);
Alter table Entite add column compl_postale varchar(255);
Alter table Contact add column compl varchar(255);
Alter table Entite add column email varchar(255);
ALTER table address drop column Compl;
ALTER table address drop column cedex;
ALTER table Entite add column cedex varchar(255) null;
ALTER table Poste Modify column Compl varchar(100) default "";
ALTER table Poste Modify column Email_fonctionnel varchar(50) default "";
ALTER table Contact Modify column Email varchar(50) default "";
ALTER table Contact Modify column Photo blob null;
ALTER table Contact Modify column TAG varchar(50) default "";
ALTER table Contact Modify column Poste_actuel int null;
Alter table Poste add column emplacement text null; 

-- Procédures stockées 19/01/2023

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `liste_poste_recursive`()
with recursive cte  as (
  select     id,
             Nom,
             Uper_id,
    		1 lvl
  from       Entite

  union all
  select     p.id,
             concat(t.Nom,'/' ,p.Nom),
             t.Uper_id,
    			lvl+1

  from       cte p,  Entite t
          WHERE p.Uper_id = t.id
)
select pos.id as id, cte.Nom as entitename, pos.Nom as nom, md.mode, plmd.listeID as listeID from cte
join Poste  as pos on (pos.Entite = cte.id)
join poste_liste_mode_diffusion as plmd   on plmd.posteID = pos.id  join
mode_diffusion as md on (md.id = plmd.modeID)
WHERE lvl >0 and Uper_id = 0$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recursive_entite`()
with recursive cte  as (
  select     id,
             Nom,
             Uper_id,
    		1 lvl
  from       Entite

  union all
  select     p.id,
             concat(t.Nom,'\\' ,p.Nom),
             t.Uper_id,
    			lvl+1

  from       cte p,  Entite t
          WHERE p.Uper_id = t.id
)
select id, Nom as nom, Uper_id as uper_id from cte WHERE lvl >0 and Uper_id = 0$$
DELIMITER ;


DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recursive_poste`()
with recursive cte  as (
  select     id,
             Nom,
             Uper_id,
    		1 lvl
  from       Entite

  union all
  select     p.id,
             concat(t.Nom,'\\' ,p.Nom),
             t.Uper_id,
    			lvl+1

  from       cte p,  Entite t
          WHERE p.Uper_id = t.id
)
select Poste.id as id, cte.Nom as entitename, Poste.Nom as Nom from cte
join Poste on (Poste.Entite = cte.id) WHERE lvl >0 and Uper_id = 0$$
DELIMITER ;

-- Migration 27/01/2023
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `recursive_poste_with_id`(IN `id_` INT UNSIGNED)
with recursive cte2  as (
  select     id,
             Nom,
             Uper_id,
    		1 lvl
  from       Entite

  union all
  select     p.id,
             concat(t.Nom,'\\' ,p.Nom),
             t.Uper_id,
    			lvl+1

  from       cte2 p,  Entite t
          WHERE p.Uper_id = t.id
)
select Poste.id as id, cte2.Nom as entitename, Poste.Nom as Nom from cte2
join Poste on (Poste.Entite = cte2.id) WHERE lvl >0 and Uper_id = 0 and Poste.id =id_$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `liste_poste_recursive_with_listeid`(IN `listeID_` INT)
with recursive cte(id, Nom, Uper_id, lvl)  as (
  select     id,
             Nom,
             Uper_id,
    		1 lvl
  from       Entite

  union all
  select     p.id,
             concat(t.Nom,'\\' ,p.Nom),
             t.Uper_id,
    			lvl+1

  from       cte p,  Entite t
          WHERE p.Uper_id = t.id
)
select pos.id as id, cte.Nom as entitename, pos.Nom as nom, md.mode, liste.Nom as listename, plmd.listeID as listeID from cte
join Poste  as pos on (pos.Entite = cte.id)
join poste_liste_mode_diffusion as plmd on ( plmd.posteID = pos.id)  join
mode_diffusion as md on (md.id = plmd.modeID) join liste on (liste.id = plmd.listeID)
WHERE lvl >0 and Uper_id = 0 and plmd.listeID = listeID_$$
DELIMITER ;

CREATE TABLE `grade` (
	`id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	`grade` VARCHAR(255) NOT NULL
);

INSERT INTO grade (grade) VALUES 
("2ème classe"),
("1ème classe"),
("Brigadier"),
("Brigadier chef"),
("Gendarme"),
("Maréchal des logis chef"),
("Adjudant"),
("Adjudant chef"),
("Major"),
("Sous lieutenant"),
("Lieutenant"),
("Capitaine"),
("Chef d’escadron"),
("Lieutenant colonel"),
("Colonel"),
("Général de brigade"),
("Général de division"),
("Général de corps d’armée"),
("Général d’armée"),
("Policier adjoint"),
("Gardien de la paix"),
("Sous brigadier"),
("Major EXE"),
("Major RULP"),
("Commandant"),
("Commandant divisionnaire"),
("Commandant divisionnaire fonctionnel"),
("Commissaire"),
("Commissaire divisionnaire"),
("Commissaire général"),
("Contrôleur général"),
("Inspecteur général"),
("Conseiller"),
("Conseillère"),
("Conseiller spécial"),
("Conseillère spéciale"),
("Chef de cabinet"),
("Cheffe de cabinet"),
("Directeur de cabinet"),
("Directrice de cabinet"),
("Sous préfet"),
("Sous préfète"),
("Préfet"),
("Préfète"),
("Surveillant"),
("Surveillant brigadier"),
("Premier surveillant"),
("Secrétaire général"),
("Délégué interministériel"),
("Déléguée interministérielle"),
("Ministre"),
("Ministre délégué"),
("Ministre déléguée"),
("Secrétaire d’Etat"),
("Premier ministre"),
("Première ministre"),
("Président"),
("Présidente"),
("Secrétaire"),
("Trésorier"),
("Trésorière"),
("Secrétaire général"),
("Directeur"),
("Directrice"),
("Directeur adjoint"),
("Directrice adjointe"),
("Sous directeur"),
("Sous directeur adjoint"),
("Sous directrice"),
("Sous directrice adjointe"),
("Auxiliaire"),
("Sapeur 2ème classe"),
("Sapeur 1ère classe"),
("Caporal"),
("Caporal chef"),
("Sergent"),
("Sergent chef");

