<?php
defined('_JEXEC') or die('Restricted access');
JHtml::core();
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<div id="ss-sermons-container">
<h1 class="componentheading"><?php echo JText::_('COM_SERMONSPEAKER_SERIESSERMONS_TITLE').$this->cat; ?></h1>
<p />
<?php if (empty($this->items)) : ?>
	<div class="no_entries"><?php echo JText::sprintf('COM_SERMONSPEAKER_NO_ENTRIES', JText::_('COM_SERMONSPEAKER_SERIES')); ?></div>
<?php else : ?>

<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" id="adminForm" name="adminForm">
	<fieldset class="filters">
	<legend class="hidelabeltxt"><?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?></legend>
		<div class="display-limit">
			<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	</fieldset>
	<!-- Begin Data -->
	<?php
	$count = NULL;
	$model	= &$this->getModel();
	foreach($this->items as $item) :
		$sermons = &$model->getSermons($item->id); ?>
		<div>
			<?php if($item->avatar) : ?>
				<img src="<?php echo SermonspeakerHelperSermonspeaker::makelink($item->avatar); ?>" style="float:right; margin-top:25px;">
			<?php endif; ?>
			<h3 class="contentheading"><?php echo $this->escape($item->series_title); ?></h3>
			<p><?php echo $item->series_description; ?></p>
		</div>
		<div style="margin-left:10%;">
			<?php foreach($sermons as $sermon) { 
				$count ++;?>
				<h4 style="margin-left:-5%;">
					<?php echo $this->escape($sermon->sermon_title);
					if (in_array('seriessermon:date', $this->columns)):
						echo ' ('.JHTML::date($sermon->sermon_date, JText::_($this->params->get('date_format')), false).')';
					endif; ?>
				</h4>
				<?php if (in_array('seriessermon:notes', $this->columns)):
					echo $sermon->notes;
				endif;
				if ($sermon->addfile && $sermon->addfileDesc && in_array('seriessermon:addfile', $this->columns)):
					echo '<b>'.JText::_('COM_SERMONSPEAKER_ADDFILE').' : </b>';
					echo SermonspeakerHelperSermonspeaker::insertAddfile($sermon->addfile, $sermon->addfileDesc);
					echo "<br />\n";
				endif;
				$lnk = SermonspeakerHelperSermonspeaker::makelink($sermon->audiofile); 
				if (in_array('seriessermon:player', $this->columns)):
					$player = SermonspeakerHelperSermonspeaker::insertPlayer($sermon, '', $count);
					echo $player['mspace'];
					echo $player['script'];
				else :
					// if player is disabled show a link
					echo JText::_('COM_SERMONSPEAKER_DIRECTLINK_HOOVER').': <a title="'.JText::_('COM_SERMONSPEAKER_DIRECTLINK_HOOVER').'" href="'.$lnk.'">'.$this->escape($sermon->sermon_title).'</a>';
				endif; ?>
			<?php } ?>
		</div>
		<br style="clear:both;" />
		<hr size="2" width="100%" />
		<?php endforeach; ?>
	<br />
	<div class="Pages">
		<div class="Paginator">
			<?php echo $this->pagination->getListFooter(); ?><br />
		</div>
	</div>
</form>
<?php endif; ?>
</div>