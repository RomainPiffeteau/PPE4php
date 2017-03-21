	<h3>Mes Demandes de Réparation</h3>
	<div class="encadre">
		<?php
			if(count($mesReparations) > 0){
				?>
					<table class="listeLegere">
						<tr>	
							<th>Equipement</th>
							<th>Type de Panne</th>
							<th>Date de la demande</th>
							<th>Prix</th>
							<th>Échéance Prévue</th>
							<th>Échéance Réelle</th>
						</tr>
						<?php
						foreach($mesReparations as $lineReparation){
							?>
							<tr>
								<td><?=$lineReparation['libelle']?></td>
								<td><?=$lineReparation['naturePanne']?></td>
								<td><?=$lineReparation['jourDemande']?></td>
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
					Vous n'avez aucune demande de réparation.
					<?php
				}
				?>
	</div>
</div>














