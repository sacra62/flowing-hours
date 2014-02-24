<div class="actions">
	<ul>
		<?php /*<li><?php echo $this->Html->link(__d('users', 'Logout'), array('admin' => false, 'action' => 'logout')); ?> */?>
		<li><?php echo $this->Html->link(__d('users', 'My Account'), array('admin' => true, 'action' => 'edit',$this->Session->read('Auth.User.id'))); ?>
		<li><?php echo $this->Html->link(__d('users', 'Add Users'), array('admin' => true, 'action'=>'add'));?></li>
		<li><?php echo $this->Html->link(__d('users', 'List Users'), array('admin' => true, 'action'=>'index'));?></li>
		<?php /*<li><?php echo $this->Html->link(__d('users', 'Frontend'), array('admin' => false, 'action'=>'index')); ?></li> */?>
	</ul>
</div>