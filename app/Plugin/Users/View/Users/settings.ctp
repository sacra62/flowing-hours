<?php
/**
 * Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$apptheme = $user_settings['app_theme'];

echo $this->Html->css('jquery-ui/'.$apptheme.'/jquery-ui.css');
echo $this->Html->css('settings.css');
echo $this->Html->script('jquery-core/jquery-1.9.1.js');
echo $this->Html->script('jquery-ui/'.$apptheme.'/jquery-ui.min.js');

echo $this->Html->script('settings.js');
?>
<script>
    $(function() {
        baseURL = "<?php echo FULL_BASE_URL.$this->webroot ?>";
    });
</script>
<div class="users form settings">
    <h2><?php echo __('SETTINGS'); ?></h2>
    <ul>
        <li><a href="javascript:;" id="user_questionnaire_settings"><?php echo __("Personal Settings")?></a></li>
        <li><a href="javascript:;" id="calendar_settings"><?php echo __("CALENDAR_WALLPAPER")?></a></li>
        <li><a href="javascript:;" id="app_theme_settings"><?php echo __("App Theme")?></a></li>    
    </ul>

</div>
<?php //@abrar for admin show admin sidebar ?>
<?php if ($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar'); ?>
<?php else: echo $this->element('Users.Users/sidebar'); ?>
<?php endif; ?>
<?php
//all the settings are here:
echo $this->element('Users.Settings/personality');
echo $this->element('Users.Settings/calendar');
echo $this->element('Users.Settings/app_theme');

?>

