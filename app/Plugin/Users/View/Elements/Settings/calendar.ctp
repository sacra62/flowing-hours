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
$usersettings = $this->Session->read('Auth.User.settings');
$usersettings = (array) json_decode($usersettings);
?>
<div class=" calendar usersettings" id="calendar" style="display: none">
    <h2><?php echo __('Calendar Wallpaper'); ?></h2>
    <form id="calendar_form" action="">
        <?php
        foreach ($wallpapers as $wall) {
            ?>
            <div>
                <?php
                $walltitle = explode(".", $wall);
                $uservalue = $walltitle[0] == $usersettings['calendar_wallpaper'] ? ' checked ="checked"' : "";
                ?>
                <input type="radio" <?php echo $uservalue ?> value="<?php echo $walltitle[0] ?>" name="calendar_wallpaper" />


            </div>   

    <?php
}
?>
    </form>
</div>


