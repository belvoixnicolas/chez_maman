#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: entreprise
#------------------------------------------------------------

CREATE TABLE entreprise(
        id          Int  Auto_increment  NOT NULL ,
        logo        Varchar (50) ,
        video       Varchar (50) ,
        phrase      Varchar (50) ,
        description Text ,
        telephone   Int ,
        numeroRue   Int ,
        rue         Varchar (50) ,
        ville       Varchar (50) ,
        cp          Int
	,CONSTRAINT entreprise_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: profil
#------------------------------------------------------------

CREATE TABLE profil(
        id            Int  Auto_increment  NOT NULL ,
        mail          Varchar (50) NOT NULL ,
        motDePasse    Text NOT NULL ,
        salt          Text NOT NULL ,
        admin         Bool NOT NULL ,
        id_entreprise Int NOT NULL
	,CONSTRAINT profil_PK PRIMARY KEY (id)

	,CONSTRAINT profil_entreprise_FK FOREIGN KEY (id_entreprise) REFERENCES entreprise(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: avie
#------------------------------------------------------------

CREATE TABLE avie(
        id            Int  Auto_increment  NOT NULL ,
        text          Text NOT NULL ,
        date          Date NOT NULL ,
        afficher      Bool NOT NULL ,
        id_entreprise Int NOT NULL
	,CONSTRAINT avie_PK PRIMARY KEY (id)

	,CONSTRAINT avie_entreprise_FK FOREIGN KEY (id_entreprise) REFERENCES entreprise(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: services
#------------------------------------------------------------

CREATE TABLE services(
        id            Int  Auto_increment  NOT NULL ,
        text          Text NOT NULL ,
        image         Varchar (50) NOT NULL ,
        ordre         Int NOT NULL ,
        id_entreprise Int NOT NULL
	,CONSTRAINT services_PK PRIMARY KEY (id)

	,CONSTRAINT services_entreprise_FK FOREIGN KEY (id_entreprise) REFERENCES entreprise(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: menu
#------------------------------------------------------------

CREATE TABLE menu(
        id            Int  Auto_increment  NOT NULL ,
        titre         Varchar (50) NOT NULL ,
        image         Varchar (50) NOT NULL ,
        ordre         Int NOT NULL ,
        id_entreprise Int NOT NULL
	,CONSTRAINT menu_PK PRIMARY KEY (id)

	,CONSTRAINT menu_entreprise_FK FOREIGN KEY (id_entreprise) REFERENCES entreprise(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: produit
#------------------------------------------------------------

CREATE TABLE produit(
        id      Int  Auto_increment  NOT NULL ,
        text    Text ,
        image   Varchar (50) NOT NULL ,
        prix    Float NOT NULL ,
        ordre   Int NOT NULL ,
        id_menu Int NOT NULL
	,CONSTRAINT produit_PK PRIMARY KEY (id)

	,CONSTRAINT produit_menu_FK FOREIGN KEY (id_menu) REFERENCES menu(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: reseau
#------------------------------------------------------------

CREATE TABLE reseau(
        id            Int  Auto_increment  NOT NULL ,
        titre         Varchar (50) NOT NULL ,
        image         Varchar (50) NOT NULL ,
        url           Text NOT NULL ,
        id_entreprise Int NOT NULL
	,CONSTRAINT reseau_PK PRIMARY KEY (id)

	,CONSTRAINT reseau_entreprise_FK FOREIGN KEY (id_entreprise) REFERENCES entreprise(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: horraire
#------------------------------------------------------------

CREATE TABLE horraire(
        id            Int  Auto_increment  NOT NULL ,
        jour          Varchar (8) NOT NULL ,
        ouvertMat     Time ,
        fermeMat      Time ,
        ouvertAp      Time ,
        fermeAp       Time NOT NULL ,
        id_entreprise Int NOT NULL
	,CONSTRAINT horraire_PK PRIMARY KEY (id)

	,CONSTRAINT horraire_entreprise_FK FOREIGN KEY (id_entreprise) REFERENCES entreprise(id)
)ENGINE=InnoDB;

