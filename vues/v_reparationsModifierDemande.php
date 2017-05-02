<div id="menuDroite">
	<?php
	if($pdo->getGrade($_SESSION['idVisiteur'])['id'] == 1){
		?>
		<script>
			alert("Vous n'êtes pas autorisé acceder àete page !");
		</script>
		<?php
		include("vues/v_sommaire.php");
	}else{
		?>
		<h2>Modifier la Demande de Réparation</h2>
		<div class="encadre" style="min-width: 120%; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: space-around; align-items: stretch; font-family: Verdana; font-size: 14px;">
			<div style="margin: auto 0;">
				<table>
					<tr>
						<td align="right"><strong>Membre:</strong></td>
                        <td><?=$laPanne['nomVisiteur']?> <?=$laPanne['prenomVisiteur']?></td>
					</tr>
					<tr>
						<td align="right"><strong>Matériel:</strong></td>
                        <td><?=$laPanne['nomMateriel']?></td>
					</tr>
					<tr>
						<td align="right"><strong>Date de demande:</strong></td>
                        <td><?=$laPanne['dateDemande']?></td>
					</tr>
					<tr>
						<td align="right"><strong>Type de Panne:</strong></td>
                        <td><?=$laPanne['typePanne']?></td>
					</tr>
				</table>
			</div>
			<div align="center" style="margin: auto 0;">
				<form method="post" action="index.php?uc=reparation&action=validerDemande">
					<input type="hidden" name="idPanne" value="<?=$laPanne['idPanne']?>"/>
					<br>
					<strong>Date de réparation théorique:</strong><br>
					<input id ="dateFinTheorique" type="text" name="dateFinTheorique" placeholder="AAAA-MM-JJ" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" style="width: 300px;" <?php if(!empty($laPanne['dateFinTheorique'])) echo 'value="'.$laPanne['dateFinTheorique'].'" ' ?>required/><br>
					<br>
					<strong>Date de réparation réelle:</strong><br>
					<input id ="dateFinReelle" type="text" name="dateFinReelle" placeholder="AAAA-MM-JJ" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" style="width: 300px;"<?php if(!empty($laPanne['dateFinReelle'])) echo ' value="'.$laPanne['dateFinReelle'].'"' ?>/><br>
					<br>
					<strong>Prix:</strong><br>
					<input id ="prix" type="number" name="prix" min="0" style="width: 300px;"<?php if(!empty($laPanne['prix'])) echo ' value="'.$laPanne['prix'].'"' ?>/><br>
					<br>
					<strong>Commentaire:</strong><br>
					<textarea id ="commentaire" name="commentaire" style="resize: vertical; width: 300px;"><?php if(!empty($laPanne['commentaire'])) echo $laPanne['commentaire'] ?></textarea><br>
					<br>
					<script>
						var dateFinTheorique = document.getElementById('dateFinTheorique').value;
						var dateFinReelle = document.getElementById('dateFinReelle').value;
						var prix = document.getElementById('prix').value;
						var commentaire = document.getElementById('commentaire').value;
						function resetFields(){
							document.getElementById('dateFinTheorique').value = dateFinTheorique;
							document.getElementById('dateFinReelle').value = dateFinReelle;
							document.getElementById('prix').value = prix;
							document.getElementById('commentaire').value = commentaire;
						}
					</script>
					<input type="button" value="Réinitialiser" onClick="resetFields();"/> <input type="submit" value="Valider"/>
				</form>
			</div>
		</div>
		<?php
	}
	?>
</div>














