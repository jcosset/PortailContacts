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