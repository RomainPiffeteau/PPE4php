<div id="menuDroite">
	<?php
	$grade = $pdo->getGrade($_SESSION['idVisiteur']);
	?>
	<h3>Demandes de Réparation de mes <?=$pdo->getGradeInferieur($grade['id'])['libelle']?>s à Charge :</h3>
	<div class="encadre">
		<?php
		if(count($mesPersonnesACharge)>0){
			foreach($mesPersonnesACharge as $linePAC){
				$reparations = getReparations($linePAC['id']);
				if(count($reparations)>0){
					?>
					<table class="listeLegere">
						<caption><?=$linePAC['nom']?> <?=$linePAC['prenom']?></caption>
						<tr>
							<th>Equipement</th>
							<th>Type de Panne</th>
							<th>Date de la demande</th>
							<th>Prix</th>
							<th>Échéance Prévue</th>
							<th>Échéance Réelle</th>
						</tr>
						<?php
						foreach($reparations as $lineReparation){
							?>
							<tr>
								<td><?=$lineReparation['equipement']?></td>
								<td><?=$lineReparation['typePanne']?></td>
								<td><?=$lineReparation['jour']?></td>
								<td><?php if(empty($lineReparation['prix'])) echo "/"; else echo $lineReparation['prix']."€" ?></td>
								<td><?php if(empty($lineReparation['dateFinT'])) echo "/"; else echo $lineReparation['dateFinT'] ?></td>
								<td><?php if(empty($lineReparation['dateFinR'])) echo "/"; else echo $lineReparation['dateFinR'] ?></td>
							</tr>
							<?php
						}
						?>
					</table>
					<?php
				}else{
					?>
					Cette personne n'a pas de demande de réparation.
					<?php
				}
				echo "<br><br>";
			}
		}else{
			?>
			Vous n'avez aucune personne à charge.
			<?php
		}
		?>
	</div>
</div>














