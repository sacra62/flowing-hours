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
?>
<div class=" user_questionnaire usersettings" id="user_questionnaire" style="display: none" title="<?php echo __('PERSONALITY_QUESTIONNAIRE'); ?>">
    <form id="user_questionnaire_form" action="">
        <dl>
            <?php
            foreach ($questions as $us) {
                ?>
                <strong><?php echo __($us['user_preference']['question_title']) ?></strong>
                <div>
                    <?php echo __($us['user_preference']['question_description']) ?>
                    <?php
                    $uservalue = $user_settings[$us['user_preference']['code']];

                    $uservalue = isset($uservalue) ? $uservalue : $us['user_preference']['default'];
                    if ($us['user_preference']['type'] == "text") {
                        ?>
                        <input size="2" type="<?php echo $us['user_preference']['type'] ?>" value="<?php echo $uservalue ?>" name="<?php echo $us['user_preference']['code'] ?>" />

                        <?php
                    }
                    ?>
                    <?php
                    if ($us['user_preference']['type'] == "radio") {
                        ?>
                        <br/>
                        <input type="<?php echo $us['user_preference']['type'] ?>" value="1" <?php if ($uservalue == 1) echo 'checked="checked"'; ?> name="<?php echo $us['user_preference']['code'] ?>" /><?php echo __("YES")?>
                        <input type="<?php echo $us['user_preference']['type'] ?>" value="0" <?php if ($uservalue == 0) echo 'checked="checked"'; ?> name="<?php echo $us['user_preference']['code'] ?>" /><?php echo __("NO")?>

                        <?php
                    }
                    ?>     </div>   

                <?php
            }
            ?>
        </dl>
    </form>
</div>


