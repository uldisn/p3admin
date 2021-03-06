<?php
$this->breadcrumbs = array(
    $this->module->id,
);
?>

<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>

<h1>
	<?php echo Yii::t('P3AdminModule.crud', 'Application'); ?>
	<small><?php echo Yii::t('P3AdminModule.crud', 'Settings'); ?></small>
</h1>

<?php $this->beginClip('modules') ?>
<ul class="thumbnails">
    <?php foreach ($this->getModuleData() AS $name => $config): ?>
    <li class="span4">
        <div class="thumbnail">
            <h3><?php echo CHtml::link($name, array('/' . $name)) ?></h3>
            <small><?php echo ($config !== null) ? str_replace(".", "<wbr>.", $config['class']) :
                '<em>Not configured yet</em>' ?></small>
        </div>
    </li>
    <?php endforeach; ?>
    </table>
</ul>
<?php $this->endClip() ?>


<?php $this->beginClip('controllers') ?>
<h3>App</h3>
<ul>
    <?php foreach ($this->module->findApplicationControllers() AS $name): ?>
    <li><?php echo CHtml::link($name, array('/' . $name)) ?></li>
    <?php endforeach; ?>
</ul>

<?php foreach ($this->getModuleData() AS $name => $config): ?>
<h3><?php echo CHtml::link($name, array('/' . $name)) ?></h3>
<ul>
    <?php foreach ($this->module->findApplicationControllers($config['class']) AS $controller_name): ?>
    <li><?php echo CHtml::link($controller_name, array('/' . $name.'/'. $controller_name,)) ?></li>
    <?php endforeach; ?>        
</ul>    
<?php $this->endClip() ?>


<?php $this->beginClip('__md') ?>
disabled
<?php
// TODO: disabled - incompatiblity with Yii 1.1.13(?) - Yii::app()->user == 'Guest' ?!
#$metadata = Yii::app()->getModule('p3admin')->metadata->getAll();
#var_dump($metadata);
?>
<?php $this->endClip() ?>

<?php $this->beginClip('__pkg') ?>
<ul>
    <?php
    $json = CJSON::decode(file_get_contents(Yii::getPathOfAlias('root') . DIRECTORY_SEPARATOR . 'composer.lock'));
    if (isset($json['packages'])) foreach ($json['packages'] AS $package) {
        echo "<li><span class=''>" . CHtml::link($package['name'], (isset($package['homepage']))?$package['homepage']:'') . "</span> <span class='label'>" . $package['version'] . "</span></li>";
    };
    ?>
</ul>
<h3>Dev Packages</h3>
<ul>
    <?php
    $json = CJSON::decode(file_get_contents(Yii::getPathOfAlias('root') . DIRECTORY_SEPARATOR . 'composer.lock'));
    if (isset($json['packages-dev'])) foreach ($json['packages-dev'] AS $package) {
        echo "<li><span class=''>" . CHtml::link($package['name'], (isset($package['homepage']))?$package['homepage']:'') . "</span> <span class='label'>" . $package['version'] . "</span></li>";
    };
    ?>
</ul>

<?php $this->endClip() ?>


<?php $this->beginClip('__set') ?>
<h3><?php echo Yii::t('P3AdminModule.crud', 'Language'); ?></h3>
<p>
    <?php echo Yii::app()->language ?>
</p>
<?php $this->endClip() ?>


<?php
$this->widget('bootstrap.widgets.TbTabs',
              array(
                   'type' => 'tabs',
                   'placement' => 'above', // 'above', 'right', 'below' or 'left'
                   'tabs' => array(
                       array('label' => Yii::t('P3AdminModule.crud', 'Modules'),
                             'content' => $this->clips['modules'],
                             'active' => true),
                       array('label' => Yii::t('P3AdminModule.crud', 'Controllers'),
                             'content' => $this->clips['controllers']),
                       array('label' => Yii::t('P3AdminModule.crud', 'Packages'),
                             'content' => $this->clips['__pkg']),
                       array('label' => Yii::t('P3AdminModule.crud', 'User'),
                             'content' => $this->renderPartial('_user', array(), true)),
                       array('label' => Yii::t('P3AdminModule.crud', 'Configuration'),
                             'content' => $this->renderPartial('_config', array(), true),
                       ),
                       array('label' => Yii::t('P3AdminModule.crud', 'Settings'),
                             'content' => $this->clips['__set'],
                       ),
                       array('label' => Yii::t('P3AdminModule.crud', 'Models'),
                             'content' => $this->clips['__md']),

                   )
              )
);
?>



