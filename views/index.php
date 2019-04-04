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
    <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Maecenas sed diam eget risus varius blandit sit amet non magna. Donec id elit non mi porta gravida at eget metus. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

        Cras mattis consectetur purus sit amet fermentum. Donec ullamcorper nulla non metus auctor fringilla. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum. Maecenas sed diam eget risus varius blandit sit amet non magna. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
</div>
<div id="categories-display">
    <h1>Quelques catégories...</h1>
    <div class="categories">
        <?php
            foreach ($randomCategories as $key => $value) {
                echo '<button class="category">';
                    echo '<a href="/category/'.$categories[$value]['category_id'].'/'.$this->_global['fn']->clean($categories[$value]['name']).'">'.$categories[$value]['name'].'</a>';
                echo '</button>';
            }
        ?>
    </div>
    <a href="/category/0/all" class="plus-categories">
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