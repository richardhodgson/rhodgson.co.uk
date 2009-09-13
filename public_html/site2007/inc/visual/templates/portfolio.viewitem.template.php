				
				<div id="PortfolioItem">
					
					<img src="/img/portfolio/<?= $label?>/<?= $thumbnail?>" alt="<?= $title?>" />
					<h3><?= $title?></h3>
					
					<? if ($link) {?>
					
					<ul id="ItemLink">
						<? if ($featured) { ?>
						
						<li><a href="/Portfolio/Featured/<?= $label?>"><b>Read more about this Featured Entry &#187;</b></a></li>
						<? } ?>
					
						<? if (strpos($link, '$') === false) { ?>
						
						<li><a href="<?= $link?>"><?= $link?></a></li>
						<? } else { 
							$links = explode('$', $link);
						
							foreach ($links as $link) { ?>
							
							<li><a href="<?= $link?>"><?= $link?></a></li>
						<? }
						} ?>
						
					</ul>
					<? }?>
					
					<div class="Column ClearBoth">
					
						<h4 class="ClearBoth">Project Client</h4>
						<p><?= $client?></p>
						
						<h4>Skills Involved</h4>
						<p><?= $Skills?></p>
						
						<h4>The Brief</h4>
						<?= $brief?>
						
					</div>
					<div class="Column">
					
						<h4>The Solution</h4>
						<?= $solution?>
						
						
						<ul>
						<? if ($id > 1) { ?>
						
							<li><a href="/Portfolio/<?= $next?>">View Next Entry &#187;</a></li>
						<? } ?>
						
							<li><a href="/Portfolio">Back to the Portfolio &#187;</a></li>
						
						</ul>
												
					</div>
					
					
				</div>
