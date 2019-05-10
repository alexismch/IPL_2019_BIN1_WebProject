<div class="player">
    <div class="slog inside-background-div">
        <h1>TROUVEZ AVEC CLASS</h1>
    </div>
    <a href="#about-display" id="mouse" class="scroll mouse inside-background-div">
        <i></i>
    </a>
    <div class="background"></div>
    <script>
        $(document).ready(function() {
            $("a.scroll").click(function() {
                event.preventDefault()
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top
                }, "slow");
            });
        });
    </script>
</div>
<div id="about-display">
    <h1>À notre propos...</h1>
    <p>
        ClassNotFound© est une organisation indépendante qui a pour but, via son site, de mettre en communcation toute la communauté Informatique afin d'instaurer une entraide.
        <br>Entraide qui permettra aux "newbies" d'évoluer vers un avenir prometteur, et aux plus avancés d'encore s'améliorer.
    </p>
</div>
<div id="categories-display">
    <h1>Quelques catégories...</h1>
    <div class="categories">
        <?php
            foreach ($randomCategories as $key => $value) {
                echo '<button class="category">';
                    echo '<a href="/category/'.$categories[$value]['link_referer'].'">'.$categories[$value]['name'].'</a>';
                echo '</button>';
            }
        ?>
    </div>
    <a href="/category/all" class="plus-categories">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
</div>
<div class="horizontal-separator"></div>
<div id="questions-display">
    <h1>Les dernières questions...</h1>
    <div class="questions">
        <?php
            foreach ($lastQuestions as $key => $value) {
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
        ?>
    </div>
</div>