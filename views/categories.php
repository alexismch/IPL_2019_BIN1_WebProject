<div id="categories-display">
	<h1>Toutes les catégories...</h1>
	<div class="categories">
		<?php
			foreach ($categories as $key => $value) {
				echo '<button class="category">';
					echo '<a href="/category/'.$value['link_referer'].'">'.$value['name'].'</a>';
				echo '</button>';
			}
		?>
	</div>
</div>