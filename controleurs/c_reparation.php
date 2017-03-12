<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'visualiser':{
		$mesReparations=$pdo->getMesReparations($idVisiteur);
		include("vues/v_visualiserReparations.php");
		break;
	}
	case 'ajouter':{
		//TODO
		?>
		Cette Page est en cours de construction
		<?php
	}
}
?>