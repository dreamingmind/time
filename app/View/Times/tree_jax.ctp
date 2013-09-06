<?php 

$line = "You moved line $line.";
echo $this->Html->para('line', $line);
$sibling = "It's new previous sibling is $sibling.";
echo $this->Html->para('sibling', $sibling);
$parent = "It's new parent is $parent.";
echo $this->Html->para('parent', $parent);

?>

