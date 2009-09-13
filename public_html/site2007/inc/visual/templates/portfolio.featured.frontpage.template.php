	
			<div id="FeaturedItem">
				<h3>Featured Site</h3>
				<h4><?= $title?></h4>
				
				<a class="FeatureImage" href="/Portfolio/Featured/<?= $label ?>">
					<img src="/img/portfolio/<?= $label . '/' . $image ?>" alt="<?= $title ?>" />
				</a>
				<?= $description ?>
				
				<ul>
					<li><a href="/Portfolio/Featured/<?= $label?>">View Feature &#187;</a></li>
					<!--<li><a href="/Portoflio/Featured">Read about other featured sites</a></li>-->
					<!--<li></li>-->
				</ul>
				
			</div>
			