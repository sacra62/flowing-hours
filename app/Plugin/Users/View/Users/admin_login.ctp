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
<div class="users index">
    <table width="100%">

        <tr>
         <td style="text-align: left">   
             <img id="logo" src="<?php echo $this->Html->url( '/', true );?>img/528f1e1e0b1cdc75eb000001.gif">
         </td>   

   
       <?php
    $user = $this->Session->read('Auth');
    if (isset($user['User'])) {
        echo "<h2>Hello ".$user['User']['username'].'</h2>';
    } else {
        ?>   
        <?php echo $this->Session->flash('auth'); ?> 
          
         <td style="text-align: left">
    <fieldset>
            <?php
            echo $this->Form->create($model, array(
                'action' => 'login',
                'id' => 'LoginForm'));
            echo $this->Form->input('email', array(
                'label' => __d('users', 'Email')));
            echo $this->Form->input('password', array(
                'label' => __d('users', 'Password')));

            echo '<p>' . $this->Form->input('remember_me', array('type' => 'checkbox', 'label' => __d('users', 'Remember Me'))) . '</p>';
            echo '<p>' . $this->Html->link(__d('users', 'I forgot my password'), array('action' => 'reset_password')) . '</p>';

            echo $this->Form->hidden('User.return_to', array(
                'value' => '/'));
            echo $this->Form->end(__d('users', 'Submit'));
            ?>
        </fieldset>
         </td>
    <?php } ?>
         </tr>
 </table>

</div>

    <?php //@abrar for admin show admin sidebar?> <?php  if($this->Session->read('Auth.User.is_admin')) : echo $this->element('Users.Users/admin_sidebar');  ?> <?php else: echo $this->element('Users.Users/sidebar');?> <?php endif; ?>
