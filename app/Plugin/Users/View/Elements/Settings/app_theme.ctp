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
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
$themeFolder = new Folder('css/jquery-ui');

$themes = $themeFolder->read();
$usersettings = $user_settings; //set from the controller
?>
<div class=" app_theme usersettings" id="app_theme" style="display: none" title="<?php echo __('App Theme'); ?>">
    <form id="app_theme_form" action="">
        <?php
        foreach ($themes[0] as $key => $th) {
            ?>
            <?php if ($key % 2 == 0) echo '<div class="clear"></div>'; ?>

            <div class="fleft">
                <?php
                $uservalue = $th == $usersettings['app_theme'] ? ' checked ="checked"' : "";
                ?>
                <input type="radio" <?php echo $uservalue ?> value="<?php echo $th ?>" name="app_theme" /><?php echo $this->Html->image(FULL_BASE_URL . $this->webroot . 'img/app_theme/theme_' . $th.'.png') ?>


            </div> 

            <?php
        }
        ?>
    </form>
</div>


