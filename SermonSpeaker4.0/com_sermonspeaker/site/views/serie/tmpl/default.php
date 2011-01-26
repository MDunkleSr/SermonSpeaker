<?php
defined('_JEXEC') or die('Restricted access');
JHtml::core();
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');

// TODO show category name in header
$this->cat = '';

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<div id="ss-serie-container">
<h1 class="componentheading"><?php echo JText::_('COM_SERMONSPEAKER_SERIE_TITLE').": ".$this->serie->series_title; ?></h1>

<div class="ss-serie-desc">
	<?php if ($this->serie->avatar != '') : ?>
		<img class="ss-avatar" src="<?php echo SermonspeakerHelperSermonspeaker::makelink($this->serie->avatar); ?>">
	<?php endif; ?>
	<?php echo $this->serie->series_description; ?>
</div>
<?php if (in_array('serie:player', $this->columns) && count($this->items)) : ?>
	<div class="ss-serie-player">
		<hr class="ss-serie-player" />
	<?php
	$player = SermonspeakerHelperSermonspeaker::insertPlayer($this->items);
	echo $player['mspace'];
	echo $player['script'];
	?>
		<hr class="ss-serie-player" />
	</div>
<?php endif; ?>
<?php if (empty($this->items)) : ?>
	<div class="no_entries"><?php echo JText::sprintf('COM_SERMONSPEAKER_NO_ENTRIES', JText::_('COM_SERMONSPEAKER_SERMONS')); ?></div>
<?php else : ?>

<form action="<?php echo JFilterOutput::ampReplace(JFactory::getURI()->toString()); ?>" method="post" id="adminForm" name="adminForm">
	<?php if ($this->params->get('show_pagination_limit')) : ?>
	<div class="display-limit">
		<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
		<?php echo $this->pagination->getLimitBox(); ?>
	</div>
	<?php endif; ?>
	<table class="category">
	<!-- Create the headers with sorting links -->
		<thead><tr>
			<?php if (in_array('serie:num', $this->columns)) : ?>
				<th class="num">
					<?php echo JHTML::_('grid.sort', 'COM_SERMONSPEAKER_SERMONNUMBER', 'sermon_number', $listDirn, $listOrder); ?>
				</th>
			<?php endif; ?>
			<th class="ss-title">
				<?php echo JHTML::_('grid.sort', 'JGLOBAL_TITLE', 'sermon_title', $listDirn, $listOrder); ?>
			</th>
			<?php if (in_array('serie:scripture', $this->columns)) : ?>
				<th class="ss-col">
					<?php echo JHTML::_('grid.sort', 'COM_SERMONSPEAKER_SCRIPTURE', 'sermon_scripture', $listDirn, $listOrder); ?>
				</th>
			<?php endif;
			if (in_array('serie:speaker', $this->columns)) : ?>
				<th class="ss-col">
					<?php echo JHTML::_('grid.sort', 'COM_SERMONSPEAKER_SPEAKER', 'name', $listDirn, $listOrder); ?>
				</th>
			<?php endif;
			if (in_array('serie:date', $this->columns)) : ?>
				<th class="ss-col">
					<?php echo JHTML::_('grid.sort', 'COM_SERMONSPEAKER_SERMONDATE', 'sermon_date', $listDirn, $listOrder); ?>
				</th>
			<?php endif;
			if (in_array('serie:length', $this->columns)) : ?>
				<th class="ss-col">
					<?php echo JHTML::_('grid.sort', 'COM_SERMONSPEAKER_SERMONLENGTH', 'sermon_time', $listDirn, $listOrder); ?>
				</th>
			<?php endif;
			if (in_array('serie:addfile', $this->columns)) : ?>
				<th class="ss-col">
					<?php echo JHTML::_('grid.sort', 'COM_SERMONSPEAKER_ADDFILE', 'addfileDesc', $listDirn, $listOrder); ?>
				</th>
			<?php endif; ?>
		</tr></thead>
	<!-- Begin Data -->
		<tbody>
			<?php foreach($this->items as $i => $item) : ?>
				<tr class="<?php echo ($i % 2) ? "odd" : "even"; ?>">
					<?php if (in_array('serie:num', $this->columns)) : ?>
						<td class="num">
							<?php echo $item->sermon_number; ?>
						</td>
					<?php endif; ?>
					<td class="ss-title">
						<a href="<?php echo $item->link1; ?>">
							<img title="<?php echo JText::_('COM_SERMONSPEAKER_PLAYICON_HOOVER'); ?>" src="<?php echo JURI::root().'components/com_sermonspeaker/images/play.gif'; ?>" class='icon_play' alt="" />
						</a>
						<a title="<?php echo JText::_('COM_SERMONSPEAKER_SERMONTITLE_HOOVER'); ?>" href="<?php echo $item->link2; ?>">
							<?php echo $item->sermon_title; ?>
						</a>
					</td>
					<?php if (in_array('serie:scripture', $this->columns)) : ?>
						<td class="ss-col">
							<?php echo JHTML::_('content.prepare', $item->sermon_scripture); ?>
						</td>
					<?php endif;
					if (in_array('serie:speaker', $this->columns)) : ?>
						<td class="ss_col">
							<?php echo SermonspeakerHelperSermonSpeaker::SpeakerTooltip($item->speaker_slug, $item->pic, $item->name); ?>
						</td>
					<?php endif;
					if (in_array('serie:date', $this->columns)) : ?>
						<td class="ss_col">
							<?php echo JHTML::date($item->sermon_date, JText::_($this->params->get('date_format'))); ?>
						</td>
					<?php endif;
					if (in_array('serie:length', $this->columns)) : ?>
						<td class="ss_col">
							<?php echo SermonspeakerHelperSermonspeaker::insertTime($item->sermon_time); ?>
						</td>
					<?php endif;
					if (in_array('serie:addfile', $this->columns)) : ?>
						<td class="ss_col">
							<?php echo SermonspeakerHelperSermonspeaker::insertAddfile($item->addfile, $item->addfileDesc); ?>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		 	<p class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php endif; ?>

		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
	<div>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>
<?php endif; ?>
</div>