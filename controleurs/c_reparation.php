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
		//TODO
		?>
		Cette Page est en cours de construction
		<?php
		break;
	case 'montantGlobal':
		include("vues/v_reparationsMontantGlobal.php");
		break;
	case 'gestion':
		include("vues/v_reparationsGestion.php");
		break;
	case 'annulerDemande':
		if($pdo->annulerReparation($_REQUEST['id']))
			$msgReparation = "<p style=\"color: green;\">Réparation Annulée</p>";
		else
			$msgReparation = "<p style=\"color: red;\">Erreur d'annulation</p>";
		include("vues/v_reparationsGestion.php");
		break;
	case 'validerDemande':
		
		break;
}
?>
