<?php
    $solaz_sidebar_left = solaz_get_sidebar_left();
?>
<?php if ($solaz_sidebar_left && $solaz_sidebar_left != "none") : ?>
    <div class="col-md-3 col-sm-12 col-xs-12 left-sidebar active-sidebar"><!-- main sidebar -->
        <?php dynamic_sidebar($solaz_sidebar_left); ?>
    </div>
<?php endif; ?>


