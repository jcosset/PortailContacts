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

