<?php
    $solaz_sidebar_right = solaz_get_sidebar_right();
    ?>
<?php if ($solaz_sidebar_right && $solaz_sidebar_right != "none") : ?>
    <div class="col-md-3 col-sm-12 col-xs-12 right-sidebar active-sidebar"><!-- main sidebar -->
        <?php dynamic_sidebar($solaz_sidebar_right); ?>
    </div>
<?php endif; ?>


