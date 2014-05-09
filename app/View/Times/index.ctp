<div class="times index">
	<h2><?php echo __('Times'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<!--<th><?php // echo $this->Paginator->sort('created'); ?></th>-->
			<!--<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
<!--			<th><?php // echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php // echo $this->Paginator->sort('project_id'); ?></th>-->
			<th><?php echo $this->Paginator->sort('time_in'); ?></th>
			<th><?php echo $this->Paginator->sort('time_out'); ?></th>
			<th><?php echo $this->Paginator->sort('duration'); ?></th>
			<th><?php echo $this->Paginator->sort('activity'); ?></th>
			<th><?php echo $this->Paginator->sort('user'); ?></th>
			<th><?php echo $this->Paginator->sort('project'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($times as $time): ?>
	<tr>
		<td><?php echo h($time['Time']['id']); ?>&nbsp;</td>
		<!--<td><?php // echo h($time['Time']['created']); ?>&nbsp;</td>-->
		<!--<td><?php // echo h($time['Time']['modified']); ?>&nbsp;</td>-->
<!--		<td><?php // echo h($time['Time']['user_id']); ?>&nbsp;</td>
		<td><?php // echo h($time['Time']['project_id']); ?>&nbsp;</td>-->
		<td><?php echo h($time['Time']['time_in']); ?>&nbsp;</td>
		<td><?php echo h($time['Time']['time_out']); ?>&nbsp;</td>
		<td><?php echo h($time['Time']['duration']); ?>&nbsp;</td>
		<td><?php echo h($time['Time']['activity']); ?>&nbsp;</td>
		<td><?php echo h($time['Time']['user']); ?>&nbsp;</td>
		<td><?php echo h($time['Time']['project']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $time['Time']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $time['Time']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $time['Time']['id']), null, __('Are you sure you want to delete # %s?', $time['Time']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Time'), array('action' => 'add')); ?></li>
	</ul>
</div>
