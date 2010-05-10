<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
$Itemid	= JRequest::getInt('Itemid');
$sort	= JRequest::getWord('sort','sermondate');
?>
<table width="100%" cellpadding="2" cellspacing="0">
	<tr class="componentheading">
		<th align="left" valign="bottom"><?php echo JText::_('SERMONLIST'); ?></th>
	</tr>
</table>
<p />
<div class="Pages">
	<b><?php echo JText::_('SERSORTBY'); ?></b>
	<?php
	$link = 'index.php?view=sermons&sort=';
	if ($sort == "sermondate") { $sortheader = JText::_('SERDATE').' | '; }
	else { $sortheader = '<a title="'.JText::_('SORTDATE').'" href="'.JRoute::_($link.'sermondate').'">'.JText::_('SERDATE').'</a> | '; }
	if ($sort == "mostrecentlypublished") { $sortheader .= JText::_('SERPUB').' | '; }
	else { $sortheader .= '<a title="'.JText::_('SORTPUB').'" href="'.JRoute::_($link.'mostrecentlypublished').'">'.JText::_('SERPUB').'</a> | '; }
	if ($sort == "mostviewed") { $sortheader .= JText::_('SERVIEW').' | '; }
	else { $sortheader .= '<a title="'.JText::_('SORTVIEW').'" href="'.JRoute::_($link.'mostviewed').'">'.JText::_('SERVIEW').'</a> | '; }
	if ($sort == "alphabetically") { $sortheader .= JText::_('SERALPH').' | '; }
	else { $sortheader .= '<a title="'.JText::_('SORTALPH').'" href="'.JRoute::_( $link.'alphabetically').'">'.JText::_('SERALPH').'</a>'; }
	echo $sortheader;
	?>
	<div class="Paginator">
		<?php echo $this->pagination->getResultsCounter(); ?><br />
		<?php if ($this->pagination->getPagesCounter()) echo $this->pagination->getPagesCounter()."<br />"; ?>
		<?php if ($this->pagination->getPagesLinks()) echo $this->pagination->getPagesLinks()."<br />"; ?>
	</div>
</div>
<hr style="width: 100%; height: 2px;" />
<table cellpadding="2" cellspacing="2" width="100%">
	<tr>
		<?php if ($this->params->get('client_col_sermon_number')) { ?>
			<th width="5%" align="left" valign="bottom"><?php echo JText::_('SERMONNUMBER'); ?></th>
		<?php } ?>
		<th align="left"><?php echo JText::_('SERMONNAME');?></th>
		<?php if ($this->params->get('client_col_sermon_scripture_reference')) { echo "<th align=\"left\">".JText::_('SCRIPTURE')."</th>\n"; } ?>
		<th align="left"><?php echo JText::_('SPEAKER');?></th>
		<?php if ($this->params->get('client_col_sermon_date')) { echo "<th align=\"left\">".JText::_('SERMON_DATE')."</th>\n"; } ?>
		<?php if ($this->params->get('client_col_sermon_time')) { echo "<th align=\"center\">".JText::_('SERMONTIME')."</th>\n"; }?>
		<?php if ($this->params->get('client_col_sermon_addfile')) { echo "<th align=\"left\">".JText::_('ADDFILE')."</th>\n"; }?>
	</tr>
<!-- Begin Data -->
	<?php
	$i = 0;
	foreach($this->rows as $row) {
		echo "<tr class=\"row$i\">\n"; 
		$i = 1 - $i;
		if ($this->params->get('client_col_sermon_number')) { ?>
			<td align="left" valign="middle"><?php echo $row->sermon_number; ?></td>
		<?php } ?>
		<td align="left">
			&nbsp;<a href="<?php echo JRoute::_("index.php?view=sermon&id=$row->slug"); ?>">
				<img title="<?php echo JText::_('PLAYTOPLAY'); ?>" src="<?php echo JURI::root().'components/com_sermonspeaker/images/play.gif'; ?>" width='16' height='16' border='0' align='top' alt="" />
			</a>
			<a title="<?php echo JText::_('SINGLE_SERMON_HOOVER_TAG'); ?>" href="<?php echo JRoute::_("index.php?view=sermon&id=$row->slug"); ?>">
				<?php echo $row->sermon_title; ?>
			</a>
		</td>
		<?php if ($this->params->get('client_col_sermon_scripture_reference')) { echo "<td>".$this->escape($row->sermon_scripture)."</td>\n"; } ?>
		<?php if ($row->pic == "") { $row->pic = JURI::root()."components/com_sermonspeaker/images/nopict.jpg"; }?>
		<td>
			<a class="modal" href="<?php echo JRoute::_('index.php?view=speaker&layout=popup&id='.$row->s_id.'&tmpl=component')?>" rel="{handler: 'iframe', size: {x: 700, y: 500}}">
			<?php echo JHTML::tooltip('<img src="'.$row->pic.'" alt="'.$row->name.'"><br>'.$row->name,'','',$row->name); ?>
			</a>
		</td>
		<?php
		if ($this->params->get('client_col_sermon_date')) {
			echo "<td align=\"left\" valign=\"middle\">" . JHtml::_('date', $row->sermon_date, '%x', 0) . "</td>\n";
		}
		if ($this->params->get('client_col_sermon_time')) { echo "<td align=\"center\">".JHtml::Date($row->sermon_time, '%X', 0)."</td>\n"; }
		if ($this->params->get('client_col_sermon_addfile')) {
			$return = SermonspeakerHelperSermonspeaker::insertAddfile($row->addfile, $row->addfileDesc);
			if ($return != NULL) {
				echo "<td>".$return."</td>";
			} else {
				echo "<td></td>";
			}
		}
		echo "</tr>";
	}
	?>


</table>
<br />
<div class="Pages">
	<div class="Paginator">
		<?php echo $this->pagination->getPagesLinks(); ?><br />
	</div>
</div>
