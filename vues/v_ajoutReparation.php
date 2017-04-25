<?php
$arrayEquip = $pdo->getEquipVisiteur($_SESSION['idVisiteur']);
if(count($arrayEquip)>0){
?>
<div id="menuDroite">
<h3>Ajouter une nouvelle demande de réparation</h3>
<div id="encadre">
<form method='POST' action='index.php?uc=reparation&action=ajouter'>
<table class='tabNonQuadrille'>
<tr>
	<td>Ajout d'une demande de réparation suite à une panne sur l'équipement :</td>
	<td>
		<select name='equipement'>
			<?php
			foreach($arrayEquip as $ligne)
			{
			echo '<option value ="'.$ligne['id'].'">'.$ligne['libelle'].'</option>';
			}
			?>
		</select>
			
	</td>
</tr>
<tr>
	<td>Type de la panne :</td>
				<td>
					<input type='radio' name='typePanne' value=1> Dysfonctionnement occasionnel
				
				
					<input type='radio' name='typePanne' value=2> Hors service
				
				
					<input type='radio' name='typePanne' value=3> A reçu un choc
				
				
					<input type='radio' name='typePanne' value=4> A besoin d'une révision
				</td>
</tr>
<tr>
	<td>Commentaire sur la panne :</td>
				<td>
					<input type='text' name=commentaire size='100' maxlength='200'>
				</td>
</tr>				

</table>
<input type='submit' value='Valider' name='valider'>
         <input type='reset' value='Annuler' name='annuler'>

</form>
</div>
<?php
}
else {
?>
<h3>Vous n'avez aucun équipement</h3>
<?php
}
?>
</div>