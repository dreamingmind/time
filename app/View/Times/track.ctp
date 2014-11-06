<?php
echo $this->Form->create('Time');
    echo $this->Html->tag('Table', NULL, array('class' => 'striped tight sortable'));
        echo $this->Html->tableHeaders(array('Project', 'Time In', 'Duration', 'Activity', 'Tools'), array('class' => 'thead'));
        if (!empty($this->request->data)) {
            foreach ($this->request->data as $index => $record) {
                echo $this->element('track_row', array(
                    'projects' => $projectInList,
                    'index' => $index
                ));
            }
        }
    echo '</table>';
echo '</form>';

echo $this->Form->button($this->Html->tag('i', '', array('class' => 'icon-plus-sign')) . ' New', array('class' => 'orange', 'bind' => 'click.newTimeRow'));

echo $this->Form->button($this->Html->tag('i', '', array('class' => 'icon-plus-sign')) . ' Project', array('class' => 'blue', 'bind' => 'click.newProject'));

echo $this->Form->create('Project');
?>
<table class="tight project">
<tr>
    <td>
        <?php echo $this->Form->input('Project.name'); ?>
    </td>
    <td>
        <?php echo $this->Form->input('Project.client_id'); ?>
    </td>
    <td>
        <?php echo $this->Form->button('Add', array('class' => 'small green', 'bind' => 'click.addProject')) . ' '
                . $this->Form->button('Cancel', array('class' => 'small red', 'bind' => 'click.cancelProject')); ?>
    </td>
</tr>
</table>
</form>