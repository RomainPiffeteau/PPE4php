<div id="menuDroite">
	<h3>Le prix de mes demandes de Réparation</h3>
	<div class="encadre">
		<?php
		// Vérifie si l'utilisateur est un Délégué ou un responsable
		if($grade['id'] == 2 || $grade['id'] == 3){
			// Vérifie si l'utilisateur à bien des répérations qui lui sont associées (répérations provenant de getReparations dans le pdo)
			if(count($mesReparations) > 0){
				?>
				<!-- Affiche le nom des différentes colonnes de la table Panne -->
					<table class="listeLegere">
						<tr>
							<th>Demandeur</th>
							<th>Equipement</th>
							<th>Type de Panne</th>
							<th>Date de la demande</th>
							<th>Prix</th>
							<th>Prix avec majoration</th>
							<th>Jour demande</th>
							<th>Jour prise en charge</th>
							<th>Majoration</th>
							<th>Échéance Prévue</th>
							<th>Échéance Réelle</th>
							<th>Commentaire</th>
						</tr>

						<?php
						// Parcours la liste des répérations du visiteur dans la BDD et affiche les données dans un tableau
						foreach($mesReparations as $lineReparation){
							?>
							<tr>
								<td><?=$lineReparation['nom']?> <?=$lineReparation['prenom']?></td>
								<td><?=$lineReparation['libelle']?></td>
								<td><?=$lineReparation['naturePanne']?></td>
								<td><?=$lineReparation['jourDemande']?></td>
								<td><?php if(empty($lineReparation['prix'])) echo "/"; else echo $lineReparation['prix'].'€'; ?></td>
								<td><?php if(empty($lineReparation['prix'])) echo "/";
										else {
											// Affiche le prix avec l'ajout de la majoration si il y en a une
											$prix = $lineReparation['prix'];
											if(!empty($lineReparation['majoration'])){
												$prix = $prix + $prix*$lineReparation['majoration']*0.01;
												echo $prix.'€';
											}
											else{
												echo $prix.'€';
											}
										} ?>
						   	</td>
								<td><?php
								 			// Vérifie s'il existe déjà une date de demande de prise en charge et utilise la date du jour le cas échéant
											if($lineReparation['jourPriseEnCharge'] != null){
												// Utilise le champ 'jourPriseEnCharge' dans la BDD
												$dateDuJour = $lineReparation['jourPriseEnCharge'];
												// Conversion du String en date
												$dateJour = date_create_from_format('Y-m-d', $dateDuJour);
												date('Y-m-d',$dateJour->getTimestamp());
											}
											else{
												// Utilise la date du jour si le champ 'jourPriseEnCharge' est vide dans la BDD
												$dateJour = new DateTime();
	 										  $dateJour->format('Y-m-d');
											}
											$date = $lineReparation['jourDemande'];
											echo $date . "<BR>";
											$dateDemande = new DateTime($date);
											// Compare la date de la demande et la date de la prise en charge
									    $interval = $dateDemande->diff($dateJour);
										  $interval = $interval->format('%a');
										  $intervalValue = intval($interval);
											// echo "Il y a ".$intervalValue .' jour(s) <br/>';

											// Si la date de la demande date d'il y a plus de 3 jours, demande d'ajout d'une majoration
											if($intervalValue > 3){
												$intervalValue=$intervalValue-3;
												$idPanne = $lineReparation['id'];
												// Création d'un champ permettant de renseigner un taux de majoration entre 0 et 100
												// Utilise l'idPanne pour le nom de la balise input afin de différencier les balises input
												echo  'Le délai de 3 jours est dépassé de '.$intervalValue.' jour(s), veuillez
												entrer une majoration <form name="test" action="" method="post">
												<input type="number" name="majoration'.$idPanne.'" min="0" max="100">
												<input type ="submit"> </form>' ;
												// Effectue l'ajout dans la BDD uniquement si le visiteur a entré une valeur dans le champ
												if(isset($_POST['majoration'.$idPanne])){
													try{
														//Récupération de la valeur entrée par l'utilisateur dans une variable
														$majoration = $_POST['majoration'.$idPanne];
														// Met à jour les données du tuple avec le taux de majoration ajouté par le visiteur grâce à la méthode contenue dans le pdo
														$pdo->updateMajoration($majoration, $idPanne);
													}
													catch(Exception $e){
														die('Erreur : '.$e->getMessage());
													}
												}
											}
										?>
							 </td>
							 <td><?php if(empty($lineReparation['jourPriseEnCharge'])) echo "/"; else echo $lineReparation['jourPriseEnCharge']; ?></td>
							 <td><?php if(empty($lineReparation['majoration'])) echo "/"; else echo $lineReparation['majoration'].'%'; ?></td>
							 <td><?php if(empty($lineReparation['dateFinT'])) echo "/"; else echo $lineReparation['dateFinT'] ?></td>
							 <td><?php if(empty($lineReparation['dateFinR'])) echo "/"; else echo $lineReparation['dateFinR'] ?></td>
							 <td><?php if(empty($lineReparation['dateFinR'])) echo "/"; else echo $lineReparation['commentaire'] ?></td>
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
			}
			else{
				?>
				<!-- Si l'utilisateur n'est ni un délégué ni un responsable il ne peut pas ajouter une majoration -->
				Vous n'avez pas les droits pour accéder à cette demande.
				<?php
			}
				?>
	</div>
</div>
