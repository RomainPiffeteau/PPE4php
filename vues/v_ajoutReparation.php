<?php
$arrayEquip = $pdo->getEquipVisiteur($_SESSION['idVisiteur']);
$arrayTypesPanne = $pdo->getTypesPanne();
if(count($arrayEquip)>0){
?>
<div id="menuDroite">
<h3>Ajouter une nouvelle demande de réparation</h3>
<div id="encadre">
<form method='POST' action='index.php?uc=reparation&action=ajouter'>
<table class='tabNonQuadrille'>
<tr>
	<td width="20%">Ajout d'une demande de réparation suite à une panne sur l'équipement :</td>
	<td>
		<select name='equipement'>
		<option value = ""> Sélectionnez l'équipement concerné par la demande </option>
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
				<select name='equipement'>
				<option value =""> Sélectionnez un type de panne </option>
			<?php
			
			foreach($arrayTypesPanne as $ligne)
			{
			echo '<option value ="'.$ligne['id'].'">'.$ligne['naturePanne'].'</option>';
			}
			?>
		</select>
					
				</td>
</tr>
<tr>
	<td>Commentaire sur la panne :</td>
				<td>
					<textarea name=commentaire style="resize:vertical;width:300px"> </textarea>
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