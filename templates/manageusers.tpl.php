<?php

$this->data['header'] = $this->t('{userregistration:userregistration:link_panel}');
$this->data['head'] = '<link rel="stylesheet" href="resources/userregistration.css" type="text/css">';

$this->includeAtTemplateBase('includes/header.php'); ?>

<?php if(isset($this->data['error'])){ ?>
	  <div class="alert alert-error"><?php echo $this->data['error']; ?></div>
<?php }?>

<h1><?php echo $this->t('link_manageusers'); ?></h1>

<p>
<?php echo $this->t('manage1_search_instructions')?>
</p>
<?php
$used_attr = isset($this->data['attr']) ? $this->data['attr'] : '';
$used_pattern = isset($this->data['pattern']) ? $this->data['pattern'] : '';
$results = isset($this->data['search_results']) ? $this->data['search_results'] : null;
?>

<form class="form-inline" id="search_form" method="get">
 <fieldset>
  <select class="input-small" name="attr">
<?php
foreach($this->data['searchable_attributes'] as $attr => $name) {
  echo '<option value="'.$attr.'"';
  if ($used_attr == $attr) {
      echo ' selected="selected"';
  }
  echo '>'.$name.'</option>';
}
?>
  </select>
  <input placeholder="<?php echo $this->t('search_string')?>" name="pattern" class="input-normal" type="text" value="<?php echo $used_pattern?>" />
  <input class="btn" type="submit" id="search_button" name="search" value="<?php echo $this->t('search')?>" />
 </fieldset>
</form>
<?php
if ($results !== null):
?>
<h3><?php echo $this->t('search_results')?></h3>

<p class="pull-right"><?php echo $this->t('filter')?> <span class="label label-info"><?php echo $this->data['searchable_attributes'][$used_attr] ?></span>: <span class="label"><?php echo $used_pattern ?></span></p>
<?php

    if (count($results) > 0):
?>
<table id="search_results" class="table table-striped table-hover">
 <thead>
  <tr>
  <th><?php echo $this->t('{attributes:attribute_mail}')?></th>
  <th><?php echo $this->t('{attributes:attribute_cn}')?></th>
  <th><?php echo $this->t('{attributes:attribute_sn}')?></th>
  <th></th>
  </tr>
 </thead>
 <tbody>
<?php
        foreach ($results as $userid => $u):

            $url_modify = SimpleSAML_Utilities::addURLparameter(
                SimpleSAML_Module::getModuleURL('userregistration/admin_modifyUser.php'),
                array(
                    'user' => $userid,
                    'attr' => $used_attr,
                    'pattern' => $used_pattern,
                )
            );
            $url_remove = SimpleSAML_Utilities::addURLparameter(
                SimpleSAML_Module::getModuleURL('userregistration/admin_removeUser.php'),
                array(
                    'user' => $userid,
                    'attr' => $used_attr,
                    'pattern' => $used_pattern,
                )
            );

?>
  <tr>
  <td><?php echo $u['mail']?></td>
  <td><?php echo $u['cn']?></td>
  <td><?php echo $u['sn']?></td>
   <td>
   <a href="<?php echo $url_modify?>" class="btn btn-small"><?php echo $this->t('edit')?></a>
   <a href="<?php echo $url_remove?>" class="btn btn-small btn-danger"><?php echo $this->t('remove') ?></a>
   </td>
  </tr>
<?php
        endforeach;
?>
 </tbody>
</table>
<?php
    else:
?>
<div id="search_no_results" class="alert alert-error"><?php echo $this->t('no_results')?></div>
<?php
    endif;
endif;
?>

<?php $this->includeAtTemplateBase('includes/footer.php'); ?>
