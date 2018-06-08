<?php

if (!defined('ABSPATH')) exit;

?><header class="elfsight-admin-header">
    <div class="elfsight-admin-header-title"><?php _e($this->pluginName . ' Plugin', $this->textDomain); ?></div>

    <a class="elfsight-admin-header-logo" href="<?php echo admin_url('admin.php?page=' . $this->slug); ?>" title="<?php _e($this->pluginName . ' Plugin', $this->textDomain); ?>">
        <img src="<?php echo plugins_url('assets/img/logo.png', $this->pluginFile); ?>" width="48" height="48" alt="<?php _e($this->pluginName . ' Plugin', $this->textDomain); ?>">
    </a>

    <div class="elfsight-admin-header-version">
        <span class="elfsight-admin-tooltip-trigger">
            <span class="elfsight-admin-header-version-text"><?php _e('Version ' . $this->version, $this->textDomain); ?></span>
            
            <?php if ($activated && !empty($last_check_datetime)): ?>
                <span class="elfsight-admin-tooltip-content">
                    <span class="elfsight-admin-tooltip-content-inner">
                        <?php printf(__('Last update check on %1$s at %2$s', $this->textDomain), date_i18n(get_option('date_format'), $last_check_datetime), date_i18n(get_option('time_format'), $last_check_datetime)); ?>

                        <?php if (!empty($last_upgraded_at)) {?>
                            <br>
                            <?php printf(__('Last updated on %1$s', $this->textDomain), date_i18n(get_option('date_format'), $last_upgraded_at)); ?>
                        <?php } ?>
                    </span>
                </span>
            <?php endif ?>
        </span>
    </div>
    
    <div class="elfsight-admin-header-support">
        <a class="elfsight-admin-button-transparent elfsight-admin-button-small elfsight-admin-button" href="#/support/" data-elfsight-admin-page="support"><?php _e('Need help?', $this->textDomain); ?></a>
    </div>
</header>