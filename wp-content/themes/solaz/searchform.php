<form role="search" method="get" id="searchform" class="searchform product-search" action="<?php echo esc_url(home_url( '/' )); ?>">
    <div class="search-form">
        <input type="text" onfocus="if (this.value == '<?php echo esc_html__("Blog Search...", "solaz") ?>') {this.value = '';}" onblur="if (this.value == '')  {this.value = '<?php echo esc_html__("Blog Search...", "solaz") ?>';}" value="<?php echo esc_html__("Blog Search...", "solaz") ?>" name="s" id="s" placeholder="<?php echo esc_html__("Blog Search...", "solaz") ?>"/>
        <button type="submit" id="searchsubmit" class="button btn-search"><i class="pe-7s-search"></i></button>
    </div>
</form>