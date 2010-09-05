<?php
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');

$columns = $this->params->get('col');
?>
<div id="ss-sermon-container">
<h1 class="componentheading"><?php echo JText::_('COM_SERMONSPEAKER_SERMON_TITLE'); ?></h1>
<!-- Begin Data -->
<?php if ($this->params->get('hide_dl') == "0" && strlen($this->item->sermon_path) > 0) : ?>
	<h3 class="contentheading"><a title="<?php echo JText::_('COM_SERMONSPEAKER_DIRECTLINK_HOOVER'); ?>" href="<?php echo $this->lnk; ?>"><?php echo $this->escape($this->item->sermon_title); ?></a></h3>
<?php else : ?>
	<h3 class="contentheading"><?php echo $this->escape($this->item->sermon_title); ?></h3>
<?php endif; ?>
<div class="ss-sermondetail-container">
	<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_SERMON'); ?>:</div>
	<div class="ss-sermondetail-text"><?php echo JHTML::date($this->item->sermon_date, JText::_($this->params->get('date_format'))); ?></div>
	<?php if (in_array('sermon:scripture', $columns) && $this->item->sermon_scripture) : ?>
		<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_SCRIPTURE'); ?>:</div>
		<div class="ss-sermondetail-text"><?php echo $this->item->sermon_scripture; ?></div>
	<?php endif;
	if (in_array('sermon:custom1', $columns) && strlen($this->item->custom1) > 0) : ?>
		<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_CUSTOM1'); ?>:</div>
		<div class="ss-sermondetail-text"><?php echo $this->item->custom1; ?></div>
	<?php endif;
	if (in_array('sermon:custom2', $columns) && strlen($this->item->custom2) > 0) : ?>
		<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_CUSTOM2'); ?>:</div>
		<div class="ss-sermondetail-text"><?php echo $this->item->custom2; ?></div>
	<?php endif; ?>
	<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_SERIE_TITLE'); ?>:</div>
	<div class="ss-sermondetail-text"><a href="<?php echo JRoute::_('index.php?view=serie&id='.$this->serie->id); ?>">
		<?php echo $this->escape($this->serie->series_title); ?></a>
	</div>
	<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_SPEAKER'); ?>:</div>
	<div class="ss-sermondetail-text">
		<?php echo SermonspeakerHelperSermonSpeaker::SpeakerTooltip($this->speaker->id, $this->speaker->pic, $this->speaker->name); ?>
	</div>
	<?php if ($this->speaker->pic) : ?>
		<div class="ss-sermondetail-label"></div>
		<div class="ss-sermondetail-text"><img height=150 src="<?php echo $this->speaker->pic; ?>"></div>
	<?php endif; ?>
	<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_SERMONTIME'); ?>:</div>
	<div class="ss-sermondetail-text"><?php echo SermonspeakerHelperSermonspeaker::insertTime($this->item->sermon_time); ?></div>
	<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_HITS'); ?>:</div>
	<div class="ss-sermondetail-text"><?php echo $this->item->hits; ?></div>
	<?php if (in_array('sermon:notes', $columns) && strlen($this->item->notes) > 0) : ?>
		<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_SERMONNOTES'); ?>:</div>
		<div class="ss-sermondetail-text"><?php echo $this->item->notes; ?></div>
	<?php endif;
	if (in_array('sermon:player', $columns)) : ?>
		<div class="ss-sermondetail-label"></div>
		<div class="ss-sermondetail-text ss-sermon-player">
			<?php $ret = SermonspeakerHelperSermonspeaker::insertPlayer($this->lnk, $this->item->sermon_time, 1, $this->item->sermon_title, $this->speaker->name); ?>
		</div>
	<?php endif;
	if ($this->params->get('popup_player') == '1') : ?>
		<div class="ss-sermondetail-label"></div>
		<div class="ss-sermondetail-text"><?php echo SermonspeakerHelperSermonspeaker::insertPopupButton($this->item->id, $ret); ?></div>
	<?php endif;
	if ($this->params->get('dl_button') == "1") : ?>
		<div class="ss-sermondetail-label"></div>
		<div class="ss-sermondetail-text"><?php echo SermonspeakerHelperSermonspeaker::insertdlbutton($this->item->id, $this->item->sermon_path); ?></div>
	<?php endif;
	if ($this->item->addfile && $this->item->addfileDesc) : ?>
		<div class="ss-sermondetail-label"><?php echo JText::_('COM_SERMONSPEAKER_ADDFILE'); ?>:</div>
		<div class="ss-sermondetail-text">
			<?php echo SermonspeakerHelperSermonspeaker::insertAddfile($this->item->addfile, $this->item->addfileDesc); ?>
		</div>
	<?php endif; ?>
</div>
<?php 
/*
// Code from Douglas Machado
// Shows Tags on bottom of site if some are present.
// experimental
	$keywords=explode(',',$this->item->metakey);
	$keyTotal = count($keywords);
	if ($keyTotal > '1') :
		$rowCount = 1;
		$html = "<label>Tags: </label>\r";
		foreach($keywords as $keyword) :
			$keyword = trim($keyword);
			$html .= '<a href="'.JRoute::_("index.php?option=com_search&ordering=newest&searchphrase=all&searchword=".$keyword).'" >'.$keyword.'</a>';
			if($keyTotal != $rowCount) $html .= ', ';
			$rowCount++;
		endforeach;
		echo $html;
	endif;
*/
?>
<table width="100%">
	<?php
	// Support for JComments
	$comments = JPATH_BASE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
	if (file_exists($comments)) :
		require_once($comments); ?>
		<tr><td><br /></td></tr>
		<tr>
			<td>
				<?php echo JComments::showComments($this->item->id, 'com_sermonspeaker', $this->item->sermon_title); ?>
			</td>
		</tr>
	<?php endif; ?>
</table>
</div>