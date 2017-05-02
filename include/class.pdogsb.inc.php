<?php
/**
* Classe d'accès aux données.
*
* Utilise les services de la classe PDO
* pour l'application GSB
* Les attributs sont tous statiques,
* les 4 premiers pour la connexion
* $monPdo de type PDO
* $monPdoGsb qui contiendra l'unique instance de la classe
*
* @package default
* @author Cheri Bibi
* @version    1.1
* @link       http://www.php.net/manual/fr/book.pdo.php
*/

class PdoGsb{

      	private static $serveur='sqlsrv:Server=192.168.222.72';
      	private static $bdd='dbname=gsbjm';
        private static $user='P2017Bourreau';
      	private static $mdp='Password1';
	private static $monPdo;
	private static $monPdoGsb=null;
	
        // machine virtuelle
        // private static $serveur='dblib:host=192.168.222.72';
        // private static $bdd='dbname=gsbjm';


    /*   private static $serveur='mysql:host=localhost';
       private static $bdd='dbname=gsbjm';
       private static $user='root' ;
       private static $mdp='' ;
   private static $monPdo;
   private static $monPdoGsb=null;*/

	/**
	* Constructeur privé, crée l'instance de PDO qui sera sollicitée
	* pour toutes les méthodes de la classe
	*/

	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

	/**
	* Fonction statique qui crée l'unique instance de la classe
	*
	* Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
	*
	* @return l'unique objet de la classe PdoGsb
	*/
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;
	}

	/**
	* Retourne les informations d'un visiteur
	*
	* @param $login
	* @param $mdp
	* @return l'id, le nom et le prénom sous la forme d'un tableau associatif
	*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select id, nom, prenom
			from visiteur
			where loginv like '$login' and mdp like '$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		if(count($ligne)>0)
			return $ligne[0];
		else
			return null;
	}

/**
 * Retourne les équipements d'un visiteur
 * @param $idVisiteur
 * @return les équipements associés au visiteur concerné sous la forme d'un tableau associatif
*/
	public function getEquipVisiteur($idVisiteur){
	$req = "select libelle, equipement.id
		from typeequipement, equipement
		where equipement.idVisiteur=$idVisiteur
		and equipement.idType=typeequipement.id";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}

	/**
 * Retourne les types de pannes
 * @param $idVisiteur
 * @return les équipements associés au visiteur concerné sous la forme d'un tableau associatif
*/
	public function getTypesPanne(){
	$req = "select id, naturePanne
		from typepanne
		";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetchAll(PDO::FETCH_ASSOC);
		return $ligne;
	}


	/**
	* Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
	* concernées par les deux arguments
	*
	* La boucle foreach ne peut être utilisée ici car on procède
	* à une modification de la structure itérée - transformation du champ date-
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif
	*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur'
		and lignefraishorsforfait.mois = '$mois' ";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbLignes = count($lesLignes);
		for ($i=0; $i<$nbLignes; $i++){
			$date = $lesLignes[$i]['date'];
			$lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
		}
		return $lesLignes;
	}

	/**
	* Retourne le nombre de justificatif d'un visiteur pour un mois donné
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @return le nombre entier de justificatifs
	*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}

	/**
	* Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
	* concernées par les deux arguments
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @return l'id, le libelle et la quantité sous la forme d'un tableau associatif
	*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois'
		order by lignefraisforfait.idfraisforfait";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	/**
	* Retourne tous les id de la table FraisForfait
	*
	* @return un tableau associatif
	*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}

	/**
	* Met à jour la table ligneFraisForfait pour un visiteur et
	* un mois donné en enregistrant les nouveaux montants
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
	* @return un tableau associatif
	*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}

	}

	/**
	* met à jour le nombre de justificatifs de la table ficheFrais
	* pour le mois et le visiteur concerné
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = $nbJustificatifs
		where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}

	/**
	* Teste si un visiteur possède une fiche de frais pour le mois passé en argument
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @return vrai ou faux
	*/
	public function estPremierFraisMois($idVisiteur,$mois){
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais
		where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		if($laLigne['nblignesfrais'] == 0){
			$ok = true;
		}
		return $ok;
	}

	/**
	* Retourne le dernier mois en cours d'un visiteur
	*
	* @param $idVisiteur
	* @return le mois sous la forme aaaamm
	*/
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		$dernierMois = $laLigne['dernierMois'];
		return $dernierMois;
	}

	/**
	* Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
	*
	* récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
	* avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche['idEtat']=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');

		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat)
		values('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais['idfrais'];
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite)
			values('$idVisiteur','$mois','$unIdFrais',0)";
			PdoGsb::$monPdo->exec($req);
		 }
	}

	/**
	* Crée un nouveau frais hors forfait pour un visiteur un mois donné
	* à partir des informations fournies en paramètre
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @param $libelle : le libelle du frais
	* @param $date : la date du frais au format français jj//mm/aaaa
	* @param $montant : le montant
	*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait
		values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
		PdoGsb::$monPdo->exec($req);
	}

	/**
	* Supprime le frais hors forfait dont l'id est passé en argument
	*
	* @param $idFrais
	*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
		PdoGsb::$monPdo->exec($req);
	}

	/**
	* Retourne les mois pour lesquel un visiteur a une fiche de frais
	*
	* @param $idVisiteur
	* @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant
	*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur'
		order by fichefrais.mois desc ";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch();
		}
		return $lesMois;
	}

	/**
	* Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
	*
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	* @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état
	*/
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs,
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}

	/**
	* Modifie l'état et la date de modification d'une fiche de frais
	*
	* Modifie le champ idEtat et met la date de modif à aujourd'hui
	* @param $idVisiteur
	* @param $mois sous la forme aaaamm
	*/
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = '$etat', dateModif = now()
		where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}

	/**
	 *Obtiens le grade de la personne dans un tableau
	 *
	 *@param $idVisiteur
	 *@return un tableau avec les champs 'id' et 'libelle'
	 */
	public function getGrade($idVisiteur){
		$req = "select r.id, r.libelle
			from visiteur v, rolevisiteur r
			where v.id ='$idVisiteur' and v.idRole = r.id";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetchAll(PDO::FETCH_ASSOC)[0];
		return $laLigne;
	}

	/**
	 *Obtiens le grade inférieur dans un tableau
	 *
	 *@param $idGrade
	 *@return un tableau avec le champs 'libelle'
	 */
	public function getGradeInferieur($idGrade){
		if($idGrade > 1){ // si grade > "Visiteur"
			$req = "select libelle
				from rolevisiteur
				where id = ".($idGrade-1);
			$res = PdoGsb::$monPdo->query($req);
			$laLigne = $res->fetchAll(PDO::FETCH_ASSOC)[0];
		}else{
			$laLigne['libelle'] = 'GRADE INVALIDE';
		}
		return $laLigne;
	}

	/**
	 *Obtiens la liste des dossiers de réparation pour l'utilisateur
	 *
	 *@param $idVisiteur
	 *@return un tableau de réparations avec les champs 'id', 'jourDemande', 'jourPriseEnCharge', 'prix', 'dateFinTheorique', 'dateFinReelle', 'majoration', 'commentaire', 'libelle' et 'naturePanne'
	 */
	public function getReparations($idVisiteur){
		$req = "SELECT distinct p.id, p.jourDemande, p.jourPriseEnCharge, p.prix, p.dateFinTheorique, p.dateFinReelle, p.majoration, te.libelle, tp.naturePanne, v.nom, v.prenom
			FROM panne p, equipement e, typeEquipement te, typePanne tp, lienvisiteur lv, visiteur v
			WHERE p.idEquipement = e.id
			AND e.idType = te.id
			AND p.idTypePanne = tp.id
			AND p.idVisiteur = '$idVisiteur'
			AND v.id = '$idVisiteur'
			OR p.idEquipement = e.id
			AND e.idType = te.id
			AND p.idTypePanne = tp.id
			AND lv.idVisiteur = p.idVisiteur
			AND lv.idChef = '$idVisiteur'
			AND v.id = lv.idVisiteur
			ORDER BY p.jourDemande DESC";
		$res = PdoGsb::$monPdo->query($req);
		$reparations = $res->fetchAll(PDO::FETCH_ASSOC);
		return $reparations;
	}

  /**
   *Met à jour le champ majoration dans la base de données pour le tuple associé à l'idPanne donné en paramète
   *@param $majoration, $idPanne
   *@return un boolean indiquant le succès de la requête
   */
  public function updateMajoration($majoration, $idPanne){
    $req = "UPDATE panne SET majoration = $majoration where id = $idPanne";
    $req = PdoGSB::$monPdo->exec($req);
		return ($req>0);
  }

	/**
	 *Obtiens la liste des dossiers de réparation pour le grade
	 *
	 *@param $grade
	 *@return un tableau de réparations avec les champs 'id', 'jourDemande', 'jourPriseEnCharge', 'prix', 'dateFinTheorique', 'dateFinReelle', 'majoration', 'commentaire', 'libelle', 'naturePanne', 'nom' et 'prenom'
	 */
	public function getReparationsParGrade($grade){
		$req = "SELECT p.id, p.jourDemande, p.jourPriseEnCharge, p.prix, p.dateFinTheorique, p.dateFinReelle, p.majoration, p.commentaire, te.libelle, tp.naturePanne, v.nom, v.prenom
			FROM panne p, equipement e, typeEquipement te, typePanne tp, visiteur v
			WHERE p.idEquipement = e.id
			AND e.idType = te.id
			AND p.idTypePanne = tp.id
			AND p.idVisiteur = v.id
			AND v.idRole <= '$grade'
			ORDER BY p.jourDemande DESC";
		$res = PdoGsb::$monPdo->query($req);
		$reparations = $res->fetchAll(PDO::FETCH_ASSOC);
		return $reparations;
	}

	/**
	*Obtiens la liste des personnes à charge de l'utilisateur
	*
	*@param $idVisiteur
	*@return un tableau de personnes avec les champs 'id', 'nom' et 'prenom'
	*/
	public function getPersonnesACharge($idChef){
		$req = "select v.id, v.nom, v.prenom
			from visiteur v, lienvisiteur lv
			where lv.idChef = '$idChef'
			and lv.idVisiteur = v.id";
		$res = PdoGsb::$monPdo->query($req);
		$personnes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $personnes;
	}

	/**
	*Obtiens la liste des prix des réparations
	*
	*@param $idVisiteur
	*@return un tableau avec les champs 'idVisiteur', 'nom', 'idEquiepement', 'jourDemande', 'jourPriseEnCharge', 'prix', 'majoration' et 'commentaire'
	*/
	public function getPrixReparations($idVisiteur){
	$req = "SELECT v.id as idVisiteur, v.nom, e.id as idEquipement, p.jourDemande, p.jourPriseEnCharge, p.prix, p.majoration, p.commentaire
			FROM visiteur v, equipement e, panne p
			WHERE v.id = p.idVisiteur
			AND v.id = e.idVisiteur";
		$res = PdoGsb::$monPdo->query($req);
		$mesPrixReparations = $res->fetchAll(PDO::FETCH_ASSOC);
		return $mesPrixReparations;
	}

	/**
	*annule une réparation
	*
	*@param $idReparation
	*@return un boolean indique le succès de la requête
	*/
	public function annulerReparation($idReparation){
		$req = "DELETE FROM panne WHERE id = $idReparation";
		$req = PdoGSB::$monPdo->exec($req);
		return ($req>0);
	}

	/**
	*récupère les infos d'une réparation
	*
	*@param $idReparation
	*@return un tableau avec les champs 'nomVisiteur', 'prenomVisiteur', 'nomMateriel', 'dateDemande', 'typePanne', 'dateFinTheorique', 'dateFinReelle', 'prix' et 'commentaire'
	*/
	public function getInfosPanne($idReparation){
		$req = "SELECT p.id as idPanne, v.nom as nomVisiteur, v.prenom as prenomVisiteur, te.libelle as nomMateriel, p.jourDemande as dateDemande, tp.naturePanne as typePanne, p.dateFinTheorique, p.dateFinReelle, p.prix, p.commentaire
					FROM panne p, visiteur v, typeequipement te, equipement e, typepanne tp
					WHERE p.id=$idReparation
						AND p.idTypePanne = tp.id
						AND p.idVisiteur = v.id
						AND p.idEquipement = e.id
						AND e.idType=te.id";
		$res = PdoGsb::$monPdo->query($req);
		$mesPrixReparations = $res->fetchAll(PDO::FETCH_ASSOC);
		return $mesPrixReparations[0];
	}

	/**
	*valide une réparation
	*
	*@param $idPanne, $dateFinTheorique, $dateFinReelle, $prix, $commentaire
	*@return un boolean indique le succès de la requête
	*/
	public function validerReparation($idPanne, $dateFinTheorique, $dateFinReelle, $prix, $commentaire){
		$req = "UPDATE `panne` SET `dateFinTheorique`='".addslashes($dateFinTheorique)."' WHERE `id`=$idPanne";
		$req = PdoGSB::$monPdo->exec($req);
		$nbLineAffect = $req;
		if(!empty($dateFinReelle)){
			$req = "UPDATE `panne` SET `dateFinReelle`='".addslashes($dateFinReelle)."' WHERE `id`=$idPanne";
			$req = PdoGSB::$monPdo->exec($req);
			$nbLineAffect += $req;
		}else{
			$req = "UPDATE `panne` SET `dateFinReelle`=NULL WHERE `id`=$idPanne";
			$req = PdoGSB::$monPdo->exec($req);
			$nbLineAffect += $req;
		}
		if(!empty($prix)){
			$req = "UPDATE `panne` SET `prix`=$prix WHERE `id`=$idPanne";
			$req = PdoGSB::$monPdo->exec($req);
			$nbLineAffect += $req;
		}else{
			$req = "UPDATE `panne` SET `prix`=0 WHERE `id`=$idPanne";
			$req = PdoGSB::$monPdo->exec($req);
			$nbLineAffect += $req;
		}
		if(!empty($commentaire)){
			$req = "UPDATE `panne` SET `commentaire`='".addslashes($commentaire)."' WHERE `id`=$idPanne";
			$req = PdoGSB::$monPdo->exec($req);
			$nbLineAffect += $req;
		}else{
			$req = "UPDATE `panne` SET `commentaire`='' WHERE `id`=$idPanne";
			$req = PdoGSB::$monPdo->exec($req);
			$nbLineAffect += $req;
		}
		return ($nbLineAffect>0);
	}
}
?>
