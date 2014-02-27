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
echo $this->Html->css('jquery-ui/smoothness/jquery-ui-1.10.3.custom.css');
echo $this->Html->css('settings.css');
echo $this->Html->script('jquery-core/jquery-1.9.1.js');
echo $this->Html->script('jquery-ui/smoothness/jquery-ui-1.10.3.custom.min.js');

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
        <li><a href="javascript:;" id="user_questionnaire_settings">Personality Settings</a></li>
        <li><a href="javascript:;" id="calendar_settings">Calendar Wallpaper</a></li>
        <li><a href="javascript:;" id="app_settings">App Wallpaper</a></li>    
    </ul>

</div>
<?php //@abrar for admin show admin sidebar ?>
<?php if ($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar'); ?>
<?php else: echo $this->element('Users.Users/sidebar'); ?>
<?php endif; ?>
<?php
//all the settings are here:
echo $this->element('Users.Settings/personality');
?>

