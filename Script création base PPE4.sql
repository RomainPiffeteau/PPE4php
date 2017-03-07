use gsbjm
GO
CREATE TABLE ROLEVISITEUR(
	id int not null,
	libelle char(20) not null,
	CONSTRAINT pk_role PRIMARY KEY (id)
)
GO

CREATE TABLE VISITEUR(
	id int not null,
	nom char(30) not null,
	prenom char(20) not null,
	loginv char(20) not null, 
	mdp char(30) not null,
	adresse char(75) not null,
	cp char(10) not null, 
	ville char(50) not null,
	dateEmb date not null,
	idRole int not null,
	CONSTRAINT pk_visiteur PRIMARY KEY (id),
	CONSTRAINT fk_role FOREIGN KEY (idRole) references ROLEVISITEUR(id)
)
GO

CREATE TABLE TYPEEQUIPEMENT(
	id int not null,
	libelle char(30) not null,
	taux float not null,
	CONSTRAINT pk_type PRIMARY KEY (id)
) 
GO


CREATE TABLE EQUIPEMENT(
	id int not null,
	dateAffectation date not null,
	prixOrigine int not null,
	etatOrigine char(30) not null,
	dateAchat date not null,
	idVisiteur int not null,
	idType int not null,
	CONSTRAINT pk_equipement PRIMARY KEY (id),
	CONSTRAINT fk_visiteur_equipement FOREIGN KEY (idVisiteur) REFERENCES visiteur(id),
	CONSTRAINT fk_type_equipement FOREIGN KEY (idType) REFERENCES typeequipement(id)
)

CREATE TABLE TYPEPANNE(
	id int not null,
	naturePanne char(30) not null,
	CONSTRAINT pk_typepanne PRIMARY KEY (id)
)

CREATE TABLE DATEPRISEENCHARGE(
	jour date not null,
	CONSTRAINT pk_date PRIMARY KEY (jour)
)


CREATE TABLE PRISEENCHARGE(
	idEquipement int not null,
	idTypePanne int not null,
	jour date not null,
	prix float not null,
	dateFinR date not null,
	dateFinT date not null,
	CONSTRAINT pk_priseencharge PRIMARY KEY (idEquipement, idTypePanne, jour, prix),
	CONSTRAINT fk_equipe_priseencharge FOREIGN KEY (id) REFERENCES equipement(id),
	CONSTRAINT fk_typepanne_priseencharge FOREIGN KEY (id) REFERENCES typepanne(id),
	CONSTRAINT fk_jour_priseencharge FOREIGN KEY (jour) REFERENCES datepriseencharge(jour)
)

CREATE TABLE DECLARER(
	idVisiteur int not null,
	idEquipement int not null,
	idTypePanne int not null,
	jour date not null,
	CONSTRAINT pk_declarer PRIMARY KEY (idVisiteur,idEquipement,idTypePanne,jour),
	CONSTRAINT fk_visiteur_declarer FOREIGN KEY (idVisiteur) REFERENCES visiteur(id),
	CONSTRAINT fk_equipement_declarer FOREIGN KEY (idTypePanne) REFERENCES equipement(id),
	CONSTRAINT fk_typepanne_declarer FOREIGN KEY (id) REFERENCES typepanne(id),
	CONSTRAINT fk_date_declarer FOREIGN KEY (jour) REFERENCES datepriseencharge(jour)
)

CREATE TABLE LIENVISITEUR(
	idVisiteur int not null,
	idChef int not null,
	CONSTRAINT pk_lienvisiteur PRIMARY KEY (idVisiteur),
	CONSTRAINT fk_visiteur_lienvisiteur FOREIGN KEY (idVisiteur) REFERENCES visiteur(id),
	CONSTRAINT fk_visiteur_lienchef FOREIGN KEY (idChef) REFERENCES visiteur(id)
)