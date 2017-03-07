<!-- Division pour le sommaire -->
<div id="menuGauche">
	<div id="infosUtil">

		<h2>
			MENU
		</h2>

	</div>  
	<ul id="menuList">
	<li >
	<?php
	$grade = $pdo->getGrade();
	?>
	Visiteur :
	
	<br>
	<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
	</li>
	<li class="smenu">
	<a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais">Saisie fiche de frais</a>
	</li>
	<li class="smenu">
	<a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
	</li>
	<li class="smenu">
	<a href="index.php?uc=reparation&action=ajouter" title="Faire une demande de réparation">Faire une demande de réparation</a>
	</li>
	<li class="smenu">
	<a href="index.php?uc=reparation&action=visualiser" title="Visualiser mes demandes de réparation">Visualiser mes demandes de réparation</a>
	</li>
	<li class="smenu">
	<a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
	</li>
	</ul>

</div>
