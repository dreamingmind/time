<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP TkHelper
 * @author jasont
 */
class TkHelper extends AppHelper {

    public $helpers = array('Form', 'Html');

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
    }

    public function beforeRender($viewFile) {
        
    }

    public function afterRender($viewFile) {
        
    }

    public function beforeLayout($viewLayout) {
        
    }

    public function afterLayout($viewLayout) {
        
    }

    public function setProjectDefaultButton($projectId = NULL) {
        $buttonOptions = array('class' => 'button small blue', 'title' => 'Set default project', 'bind' => 'click.setDefaultProject');
        if (empty($projectId)) {
            $buttonOptions['class'] = 'button small';
            $buttonOptions['disabled'] = TRUE;
        }
        return $this->Form->button($this->Html->tag('i', '', array('class' => 'icon-reply')), $buttonOptions);
    }

    public function timeFormActionButtons() {
        $buttons = array(
            $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-stop')), '', array('bind' => 'click.timeStop', 'escape' => FALSE)),
            $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-pause')), '', array('bind' => 'click.timePause', 'escape' => FALSE)),
            $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-backward')), '', array('bind' => 'click.timeBack', 'escape' => FALSE)),
        );
        return $this->Html->nestedList($buttons, array('class' => 'button-bar'));
//        $actionButtons = '<ul class="button-bar">
//<li><a href="" bind="timeStop"><i class="icon-stop blue timestop"></i></a></li>
//<li><a href=""><i class="icon-pause timepause"></i></a></li>
//<li><a href=""><i class="icon-backward timeback"></i></a></li>
//</ul>';
    }

}
