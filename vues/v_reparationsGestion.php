<div id="menuDroite">
	<?php
	if($pdo->getGrade($_SESSION['idVisiteur'])['id'] == 1){
		?>
		<script>
			alert("Vous n'êtes pas autorisé à acceder à cete page !");
		</script>
		<?php
		include("vues/v_sommaire.php");
	}else{
		?>
		<h3>Gestion des Demandes de Réparation</h3>
		<div class="encadre">
			<?php
			$grade = $pdo->getGrade($_SESSION['idVisiteur'])['id'];
			if($grade == 2){
				$lesReparations = $pdo->getReparationsParGrade(1);
			}else{
				$lesReparations = $pdo->getReparationsParGrade($grade);
			}
			
			
			
			if(count($lesReparations) > 0){
				?>
				<table class="listeLegere">
					<tr>	
						<th>Membre</th>
						<th>Equipement</th>
						<th>Type de Panne</th>
						<th>Date de la demande</th>
						<th>Prix</th>
						<th>Échéance Prévue</th>
						<th>Échéance Réelle</th>
						<th>Commentaire</th>
						<th>Valider / Annuler</th>
					</tr>
					<?php
					foreach($lesReparations as $lineReparation){
						?>
						<tr>
							<td><?=$lineReparation['prenom']?> <?=$lineReparation['nom']?></td>
							<td><?=$lineReparation['libelle']?></td>
							<td><?=$lineReparation['naturePanne']?></td>
							<td><?=$lineReparation['jourDemande']?></td>
							<td><?php if(empty($lineReparation['prix'])) echo "/"; elseif(empty($lineReparation['majoration'])) echo $lineReparation['prix']."€"; else echo ($lineReparation['prix']*$lineReparation['majoration'])."€" ?></td>
							<td><?php if(empty($lineReparation['dateFinT'])) echo "/"; else echo $lineReparation['dateFinT'] ?></td>
							<td><?php if(empty($lineReparation['dateFinR'])) echo "/"; else echo $lineReparation['dateFinR'] ?></td>
							<td><?php if(empty($lineReparation['commentaire'])) echo "/"; else echo $lineReparation['commentaire'] ?></td>
							<td><img src="./img/valid.gif" alt="Valid" title="Accepter la demande" onMouseOver="this.style.cursor = 'pointer';" onClick="if(confirm('Voulez-vous vraiment accepter la demande ?')) document.location.href='./index.html?uc=reparation&action=validerDemande&id=<?=$lineReparation['id']?>';"/> <img src="./img/cancel.gif" alt="Cancel" title="Refuser la demande" onMouseOver="this.style.cursor = 'pointer';" onClick="if(confirm('Voulez-vous vraiment refuser la demande ?')) document.location.href= './index.html?uc=reparation&action=annulerDemande&id=<?=$lineReparation['id']?>';"/></td>
						</tr>
						<?php
					}
					?>
				</table>
				<?php
			}else{
				?>
				Il n'y a aucune demande de réparation disponible.
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>














