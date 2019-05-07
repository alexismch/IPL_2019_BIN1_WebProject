<div class="add-question">
	<h2>Posez une question</h2>
	<form class="add-question-form" method="POST">
		<div class="form-section">
			<label class="moving-label" for="title">Sujet</label>
			<input type="text" name="title" id="title" required>
		</div>
		<div class="form-section">
			<label>Catégorie</label>
			<select id="category" name="category" required>
				<?php
					foreach ($categories AS $key => $value) {
						echo '<option value="'.$value['category_id'].'">'.$value['name'].'</option>';
					}
				?>
			</select>
		</div>
		<div class="form-section">
			<label for="subject">Question</label>
			<textarea id="subject" name="subject" minlength="20" placeholder="Entrez votre question tout en étant clair et précis..." required></textarea>
		</div>
        <div id="submit-section">
            <button name="add-question-form" type="submit">Partager</button>
        </div>
	</form>
</div>