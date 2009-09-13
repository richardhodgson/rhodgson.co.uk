				
				<div id="View">
					
					<img src="/img/portfolio/<?= $label?>/<?= $thumbnail?>" alt="<?= $title?>" />
					<h3><?= $title?></h3>
					
					<? if ($link) {?>
					
					<ul id="ItemLink">
						<li><a href="/Portfolio/<?= $label?>"><b>View Portfolio Entry &#187;</b></a></li>
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
					
						<?//= $description?>
						
						<?= $column1?>
						
					</div>
					<div class="Column">
					
						
						<?= $column2?>
					</div>
					
					
				</div>
