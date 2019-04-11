
<div id="questions-display">
	<h1>Les questions de la catégorie : <?php echo $this->_category['name']?></h1>
	<div class="questions">
	<?php
		if (empty($questions)) echo "<h3>Aucunes questions pour cette catégorie...</h3>";
		else {
			foreach ($questions as $key => $value) {
				echo '<div class="question">';
					echo '<div>';
						$link = "/question/".$value['question_id']."/".$this->_global['fn']->clean($value['title']);
						echo '<h3><a href="'.$link.'">'.$value['title'].'</a></h3>';
						echo '<span>par <a href="/user/'.$value['username'].'" class="author">'.$value['username'].'</a></span>';
					echo '</div>';
					echo '<p>';
						echo '<span>';
						echo $value['subject'];
						echo '</span>';
					echo '</p>';
				echo '</div>';
			}
		}
	?>
	</div>
</div>