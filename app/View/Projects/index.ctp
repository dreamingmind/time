<div class="projects index">
	<?php 
	echo $this->Form->create();
	echo $this->Form->input('client_id', array('empty' => 'select'));
	echo $this->Form->input('name', array('required' => FALSE));
	echo $this->Form->input('note');
	echo $this->Form->end('Submit');
	?>
	<h5><?php echo __('Projects'); ?></h5>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('client_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('note'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php 
    $this->Form->create();
    foreach ($projects as $project): ?>
	<tr>
		<td><?php echo h($project['Project']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($project['Client']['name'], array('controller' => 'clients', 'action' => 'view', $project['Client']['id'])); ?>
		</td>
		<td><?php echo h($project['Project']['name']); ?>&nbsp;</td>
		<td><?php echo h($project['Project']['note']); ?>&nbsp;</td>
        <td><?php 
        echo $this->Form->input('Project.state', array(
            'options' => $taskStates, 
            'bind' => 'change.jxEdit', 
            'selected' => TRUE, 
            'value' => $project['Project']['state'], 
            'originalValue' => $project['Project']['state'], 
            'label' => '',
            'recordId' => $project['Project']['id'],
            'alias' => 'Project',
            'fieldName' => 'state'));
        ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $project['Project']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $project['Project']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $project['Project']['id']), null, __('Are you sure you want to delete # %s?', $project['Project']['id'])); ?>
		</td>
	</tr>
<?php 
$this->Form->end('Update');
endforeach; ?>
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
