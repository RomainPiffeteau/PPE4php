<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'ajouter':
	
	?>
	Cette page est en cours de construction
	<?php
	include ("vues/v_ajoutEquipement.php");
	break;
	
}
?>