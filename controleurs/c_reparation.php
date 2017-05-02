<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'visualiser':
		$mesReparations=$pdo->getReparations($idVisiteur);
		include("vues/v_visualiserReparations.php");
		break;
	case 'visualiserPrix':
		$mesReparations=$pdo->getReparations($idVisiteur);
		include("vues/v_visualiserPrixDemande.php");
		break;
	case 'prisesEnCharge':
		$mesPersonnesACharge = $pdo->getPersonnesACharge($_SESSION['idVisiteur']);
		include("vues/v_reparationsPersonnesACharge.php");
		break;
	case 'ajouter':
		include("vues/v_ajoutReparation.php");
		$equipementPanne = isset($_POST['equipement']) ? $_POST['equipement'] : NULL;
		$typePanne = isset($_POST['typePanne']) ? $_POST['typePanne'] : NULL;
		$commentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : NULL;
		$dateDemande = date("Y-m-d");
		$pdo->addReparation($idVisiteur,$equipementPanne,$typePanne,$commentaire,$dateDemande);
		break;
	case 'montantGlobal':
		include("vues/v_reparationsMontantGlobal.php");
		break;
	case 'gestion':
		include("vues/v_reparationsGestion.php");
		break;
	case 'annulerDemande':
		if($pdo->annulerReparation($_REQUEST['id']))
			$msgReparation = "<p style=\"color: green;\">Réparation >Refusée</p>";
		else
			$msgReparation = "<p style=\"color: red;\">Erreur de refus !</p>";
		include("vues/v_reparationsGestion.php");
		break;
	case 'modifierDemande':
		$laPanne = $pdo->getInfosPanne($_REQUEST['id']);
		include("vues/v_reparationsModifierDemande.php");
		break;
	case 'validerDemande':
		if($pdo->validerReparation($_REQUEST['idPanne'], $_REQUEST['dateFinTheorique'], $_REQUEST['dateFinReelle'], $_REQUEST['prix'], $_REQUEST['commentaire']))
			$msgReparation = "<p style=\"color: green;\">Réparation validée</p>";
		else
			$msgReparation = "<p style=\"color: red;\">Erreur d'enregistrement !</p>";
		include("vues/v_reparationsGestion.php");
		break;
}
?>
