<div class="times view">
<h2><?php  echo __('Time'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($time['Time']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($time['Time']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($time['Time']['modified']); ?>
			&nbsp;
		</dd>
<!--		<dt><?php // echo __('User Id'); ?></dt>
		<dd>
			<?php // echo h($time['Time']['user_id']); ?>
			&nbsp;
		</dd>
		<dt><?php // echo __('Project Id'); ?></dt>
		<dd>
			<?php // echo h($time['Time']['project_id']); ?>
			&nbsp;
		</dd>-->
		<dt><?php echo __('Time In'); ?></dt>
		<dd>
			<?php echo h($time['Time']['time_in']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Time Out'); ?></dt>
		<dd>
			<?php echo h($time['Time']['time_out']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Activity'); ?></dt>
		<dd>
			<?php echo h($time['Time']['activity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo h($time['Time']['user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Project'); ?></dt>
		<dd>
			<?php echo h($time['Time']['project']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Time'), array('action' => 'edit', $time['Time']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Time'), array('action' => 'delete', $time['Time']['id']), null, __('Are you sure you want to delete # %s?', $time['Time']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Times'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Time'), array('action' => 'add')); ?> </li>
	</ul>
</div>
