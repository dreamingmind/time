<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
// create global variables set for javascript paths
$this->start('jsGlobalVars');
echo "var webroot = '{$this->request->webroot}';";
echo "var action = '{$this->request->params['action']}/';";
echo "var controller = '{$this->request->params['controller']}/';";
$this->end();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php // echo $cakeDescription  ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('kickstart');
        echo $this->Html->css('kickstart-grid');
        echo $this->Html->css('time');
        echo $this->Html->script(array('jquery-1.10.2', 'jquery-ui', 'kickstart', 'app', 'timekeep'));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        // Javascript often needs to construct a path but doesn't have access to needed
        // environmental or contextual values. Global vars here can fix that.
        echo "<script type=\"text/javascript\">
        //<![CDATA[
        // global data for javascript\r";
        echo $this->fetch('jsGlobalVars');
        echo"\r//]]>
        </script>";
        ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <!--<h3>Project Time Keeping</h3>-->
                <?php echo $this->element('menu') ?>
            </div>
            <div id="content">

                <?php echo $this->Session->flash(); ?>

                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
