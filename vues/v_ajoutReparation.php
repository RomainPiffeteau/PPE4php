<?php
$arrayEquip = $pdo->getEquipVisiteur($idVisiteur);
echo"

<h3>Ajouter une nouvelle demande de réparation</h3>
<form method='POST' action='index.php?uc=reparation&action=ajouter'>
<table class='tabNonQuadrille'>
<tr>
	<td>Ajout d'une demande de réparation suite à une panne</td>
	<td>
		<select name='equipement'>
		//liste déroulante de tous les équipements attribués à l'utilisateur courant
			foreach($arrayEquip as $libelle)
			{
			echo '<option value ="'.$libelle.'">'.$libelle.'</option>'
			}
				
		</select>
			
	</td>
	<td>
		<input type='text' name=etatOrigine size='30' maxlength='30'>
	</td>
	<td>
		<input type='text' name=dateAchat size='15' maxlength='15'>
	</td>
</tr>
<tr>
	<td>Affectation</td>
	<td>
	//listedéroulante à faire de tous les visiteurs
		<select name='visiteur'>
			<option value="">Choisissez le visiteur</option>
				<?php
				foreach ($tab as $line){
				?>
				<option value="<?=$line['id']?>">
					<?=$line['nom']?> <?=$line['prenom']?> </option>
				<?php
				}
				?>
			
		
		<select/>
	</td>
	<td>
		<input type='text' name=
</tr>
<tr>
	<td>Montant engage</td>
	<td>
		<input  type='text' name=montant  size='30' maxlength='45'>
	</td>
</tr>

</table>
<input type='submit' value='Valider' name='valider'>
         <input type='reset' value='Annuler' name='annuler'>

</form>
";
?>