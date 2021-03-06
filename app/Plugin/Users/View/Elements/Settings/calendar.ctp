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
$wallpapersFolder = new Folder('img/wallpapers');
$wallpapers = $wallpapersFolder->find('.*\.jpg');
$usersettings = $user_settings; //set from the controller
?>
<div class=" calendar usersettings" id="calendar" style="display: none" title="<?php echo __('Calendar Wallpaper'); ?>">
    <form id="calendar_form" action="">
        <?php
        foreach ($wallpapers as $key=>$wall) {
            ?>
                <?php if($key%2==0) echo '<div class="clear"></div>';?>

            <div class="fleft">
                <?php
                $walltitle = explode(".", $wall);
                
                $uservalue = $walltitle[0] == $usersettings['calendar_wallpaper'] ? ' checked ="checked"' : "";
                ?>
                <input type="radio" <?php echo $uservalue ?> value="<?php echo $walltitle[0] ?>" name="calendar_wallpaper" /><?php echo  $this->Html->image(FULL_BASE_URL.$this->webroot.'img/wallpapers/thumbs/'.$wall) ?>


            </div> 

    <?php
}
?>
    </form>
</div>


