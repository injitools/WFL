<div class="row">
    <?php
    $i = 0;
    foreach ($form->inputs as $input) {
        echo '<div class="col-sm-6">';
        $input->draw();
        echo '</div>';
        if (!(++$i % 2)) {
            echo '</div><div class="row">';
        }
    }
    ?>
</div>