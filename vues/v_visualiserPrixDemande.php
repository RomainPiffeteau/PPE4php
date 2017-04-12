<div id="menuDroite">
	<h3>Mes Demandes de Réparation</h3>
	<div class="encadre">
		<?php
		// echo $grade['id'];
		if($grade['id'] == 2 || $grade['id'] == 3){
			if(count($mesReparations) > 0){
				?>
					<table class="listeLegere">
						<tr>
							<th>Equipement</th>
							<th>Type de Panne</th>
							<th>Date de la demande</th>
							<th>Prix</th>
							<th>Prix avec majoration</th>
							<th>Jour demande</th>
							<th>Majoration</th>
							<th>Échéance Prévue</th>
							<th>Échéance Réelle</th>
							<th>Commentaire</th>
						</tr>

						<?php
						foreach($mesReparations as $lineReparation){
							?>
							<tr>
								<td><?=$lineReparation['libelle']?></td>
								<td><?=$lineReparation['naturePanne']?></td>
								<td><?=$lineReparation['jourDemande']?></td>
								<td><?php if(empty($lineReparation['prix'])) echo "/"; else echo $lineReparation['prix'].'€'; ?></td>
								<td><?php if(empty($lineReparation['prix'])) echo "/";
								else {
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
								<td><?php $dt = new DateTime();
 										  $dt->format('Y-m-d');
											$date = $lineReparation['jourDemande'];
											echo $date . "<BR>";
											$date2 = new DateTime($date);
									    $interval = $date2->diff($dt);
											//$interval = date_diff($dt,$date2);
										  $interval = $interval->format('%a');
										  $intervalValue = intval($interval);
											echo "Il y a ".$intervalValue .' jour(s) <br/>';
											if($intervalValue > 3){
												$intervalValue=$intervalValue-3;
												$idPanne = $lineReparation['id'];
												echo  'Le délai de 3 jours est dépassé de '.$intervalValue.' jour(s), veuillez
												entrer une majoration <form name="test" action="" method="post">
												<input type="number" name="majoration'.$idPanne.'" min="0" max="100">
												<input type ="submit"> </form>' ;
												if(isset($_POST['majoration'.$idPanne])){
													try{
														$bdd = new PDO('mysql:host=localhost;dbname=gsbjm;charset=utf8', 'root', '');
														$test = $_POST['majoration'.$idPanne];
														//echo $test;
														$bdd->exec('UPDATE panne SET majoration = '.$test.' where id = '.$idPanne);
													}
													catch(Exception $e){
														die('Erreur : '.$e->getMessage());
													}
												}

											}
										?>
							 </td>
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
				Vous n'avez pas les droits pour accéder à cette demande.
				<?php
			}
				?>
	</div>
</div>
