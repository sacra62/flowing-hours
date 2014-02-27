<div class="actions">
	<ul>
		<?php if (!$this->Session->read('Auth.User.id')) : ?>
			<li><?php echo $this->Html->link(__('LOGIN'), array('action' => 'login')); ?></li>
            <?php if (!empty($allowRegistration) && $allowRegistration)  : ?>
			<li><?php echo $this->Html->link(__('REGISTER_ACCOUNT'), array('action' => 'add')); ?></li>
            <?php endif; ?>
		<?php else : ?>
			<li><?php echo $this->Html->link(__('MY_ACCOUNT'), array('action' => 'edit',$this->Session->read('Auth.User.id')));?>
			<li><?php echo $this->Html->link(__('CHANGE_PASSWORD'), array('action' => 'change_password')); ?>
		<?php endif ?>
		<li><?php echo $this->Html->link(__('SETTINGS'), array('action' => 'settings')); ?></li>

	</ul>
</div>
