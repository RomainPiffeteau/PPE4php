<div id="menuDroite">
	<h3>Ajouter un nouvel équipement</h3>
	<form method='POST' action='index.php?uc=equipement&action=ajouter'>
		<table class='tabNonQuadrille'>
			<tr>
				<td>
					Achat (date au format jj-mm-aaaa)
				</td>
				<td>
					<input  type='text' name=prixOrigine  size='30' maxlength='45'>
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
					<!--listedéroulante à faire de tous les visiteurs-->
					<select name="visiteur">
						<option value="">
							Choisissez le visiteur
						</option>
						<?php
						foreach ($tab as $line){
							?>
							<option value="<?=$line['id']?>">
								<?=$line['nom']?> <?=$line['prenom']?>
							</option>
							<?php
						}
						?>


					</select>
				</td>
				<td>
					<input type='text' name="">
				</td>
			</tr>
			<tr>
				<td>
					Montant engage
				</td>
				<td>
					<input  type='text' name=montant  size='30' maxlength='45'>
				</td>
			</tr>

		</table>
		<input type='submit' value='Valider' name='valider'>
		<input type='reset' value='Annuler' name='annuler'>

	</form>
</div>