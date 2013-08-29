<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP Behavior
 * @author jasont
 */
class ThinTreeBehavior extends ModelBehavior {

    public $settings = array();

    function setup(&$model, $config = array()) {
        $this->settings[$model->alias] = $config;
    }

    function cleanup(&$model) {
        parent::cleanup($model);
    }

    function beforeFind(&$model, $query) {
        
    }

    function afterFind(&$model, $results, $primary) {
        
    }

    function beforeValidate(&$model) {
        
    }

    function beforeSave(&$model) {
        
    }

    function afterSave(&$model, $created) {
        
    }

    function beforeDelete(&$model, $cascade = true) {
        
    }

    function afterDelete(&$model) {
        
    }

    function onError(&$model, $error) {
        
    }
    
    function newNode($data) {
        
    }
    
    function moveTo ($id,$parent_id,$sibling_sequence) {
        
    }
    
    function removeFromTree($id, $children = False) {
        
    }
    
    function getDescendents ($id) {
        
    }
    
    function getSiblings($id) {
        
    }
    
    function childCount($id) {
        
    }
    
    function getChildren($id) {
        
    }
    
    function getPath($id) {
        
    }
    
    function getTreeArray ($id) {
        
    }
    
    function getAncestors($id) {
        
    }

}
