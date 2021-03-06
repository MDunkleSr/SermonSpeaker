<?php
defined('_JEXEC') or die;

require_once(JPATH_SITE.'/components/com_sermonspeaker/helpers/player.php');

/**
 * Flowplayer 5
 */
class SermonspeakerHelperPlayerFlowplayer5 extends SermonspeakerHelperPlayer
{
	private static $script_loaded;

	public function isSupported($file){
		$ext		= JFile::getExt($file);
		$video_ext	= array('mp4', 'webm', 'ogg', 'ogv', 'avi', 'm3u8', 'ts');
		if (in_array($ext, $video_ext))
		{
			$this->mode	= 'video';
		}
		else
		{
			$this->mode	= false;
		}
		return $this->mode;
	}

	public function getName()
	{
		return 'Flowplayer 5';
	}

	public function preparePlayer($item, $config)
	{
		$this->config	= $config;
		$this->player	= 'FlowPlayer5';
		$this->toggle	= $this->params->get('fileswitch', 0);

		// Load plugins
		$showplaylist			= (is_array($item)) ? 'true' : 'false';
		// Generic options
		$autostart = $this->config['autostart'] ? 'true' : 'false';

		if (is_array($item))
		{
			$this->setDimensions('23px', '100%');
			// Make sure to not use < or && in JavaScript code as it will break XHTML compatibility
			$options['onStart'] = 'function(){'
					.'var i = 0;'
					.'while (document.id("sermon"+i)){'
						.'document.id("sermon"+i).removeClass("ss-current");'
							.'i++;'
						.'}'
					.'entry = flowplayer().getClip();'
					.'document.id("sermon"+entry.index).addClass("ss-current");'
					.'if (entry.duration > 0){'
						.'time = new Array();'
						.'var hrs = Math.floor(entry.duration/3600);'
						.'if (hrs > 0){time.push(hrs);}'
						.'var min = Math.floor((entry.duration - hrs * 3600)/60);'
						.'if (hrs == 0 || min >= 10){'
							.'time.push(min);'
						.'} else {'
							.'time.push("0" + min);'
						.'}'
						.'var sec = entry.duration - hrs * 3600 - min * 60;'
						.'if (sec >= 10){'
							.'time.push(sec);'
						.'} else {'
							.'time.push("0" + sec);'
						.'}'
						.'var duration = time.join(":");'
						.'document.id("playing-duration").innerHTML = duration;'
					.'} else {'
						.'document.id("playing-duration").innerHTML = "";'
					.'}'
					.'document.id("playing-pic").src = entry.coverImage;'
					.'if(entry.coverImage){'
						.'document.id("playing-pic").style.display = "block";'
					.'}else{'
						.'document.id("playing-pic").style.display = "none";'
					.'}'
					.'if(entry.error){'
						.'document.id("playing-error").innerHTML = entry.error;'
						.'document.id("playing-error").style.display = "block";'
					.'}else{'
						.'document.id("playing-error").style.display = "none";'
					.'}'
					.'document.id("playing-title").innerHTML = entry.title;'
					.'document.id("playing-desc").innerHTML = entry.description;'
				.'}';
			$this->toggle = $this->params->get('fileswitch', 0);
			$type = ($this->config['type'] == 'audio' || ($this->config['type'] == 'auto' && !$this->config['prio'])) ? 'a' : 'v';
			$entries = array();
			foreach ($item as $temp_item)
			{
				$entry = array();
				// Choose picture to show
				$img = SermonspeakerHelperSermonspeaker::insertPicture($temp_item, 1);
				// Choosing the default file to play based on prio and availabilty
				if ($this->config['type'] == 'auto')
				{
					$file	= SermonspeakerHelperSermonspeaker::getFileByPrio($temp_item, $this->config['prio']);
				}
				else
				{
					$file	= ($this->config['type'] == 'video') ? $temp_item->videofile : $temp_item->audiofile;
				}
				if ($file)
				{
					$entry['url']			= SermonspeakerHelperSermonspeaker::makeLink($file);
				}
				else
				{
					$entry['url']	= ($img) ? $img : JURI::base(true).'/media/com_sermonspeaker/images/'.$this->params->get('defaultpic', 'nopict.jpg');
				}
				$entries[] = $entry['url'];
			}
			$this->playlist['default'] = implode(',', $entries);
		}
		else
		{
			$this->setDimensions('23px', '300px');
			$type	= ($this->mode == 'audio') ? 'a' : 'v';
			$cat	= ($type == 'a') ? 'Audio' : 'Video';
			$file	= ($type == 'a') ? $item->audiofile : $item->videofile;
			$file	= SermonspeakerHelperSermonspeaker::makeLink($file);
			$this->playlist['default'] = $file;
		}
		$this->setPopup($type);
		$this->mspace = '<div id="mediaspace'.$this->config['count'].'"></div>';
		$this->script = '<script type="text/javascript">'
							.'jQuery("#mediaspace'.$this->config['count'].'").flowplayer({'
								.'playlist: ["'.$file.'"]'
							.'});'
						.'</script>';

		// Loading needed Javascript only once
		if (!self::$script_loaded)
		{
			JHtml::Script('media/com_sermonspeaker/player/flowplayer5/flowplayer.min.js');
			JHtml::Stylesheet('media/com_sermonspeaker/player/flowplayer5/skin/minimalist.css');
			$doc = JFactory::getDocument();
			$doc->addScriptDeclaration('function ss_play(id){flowplayer().play(parseInt(id));}');
			if ($this->toggle)
			{
				$awidth		= is_numeric($this->config['awidth']) ? $this->config['awidth'].'px' : $this->config['awidth'];
				$aheight	= is_numeric($this->config['aheight']) ? $this->config['aheight'].'px' : $this->config['aheight'];
				$vwidth		= is_numeric($this->config['vwidth']) ? $this->config['vwidth'].'px' : $this->config['vwidth'];
				$vheight	= is_numeric($this->config['vheight']) ? $this->config['vheight'].'px' : $this->config['vheight'];
				if (!is_array($item))
				{
					$url = 'index.php?&task=download&id='.$item->slug.'&type=';
					$download_video = 'document.getElementById("sermon_download").onclick=function(){window.location.href=\''.JRoute::_($url.'video').'\'};document.getElementById("sermon_download").value="'.JText::_('COM_SERMONSPEAKER_DOWNLOADBUTTON_VIDEO').'"';
					$download_audio = 'document.getElementById("sermon_download").onclick=function(){window.location.href=\''.JRoute::_($url.'audio').'\'};document.getElementById("sermon_download").value="'.JText::_('COM_SERMONSPEAKER_DOWNLOADBUTTON_AUDIO').'"';
				}
				else
				{
					$download_video = '';
					$download_audio = '';
				}
				$doc->addScriptDeclaration('
					function Video() {
						flowplayer().play(['.$this->playlist['video'].']);
						document.getElementById("mediaspace'.$this->config['count'].'").style.width="'.$vwidth.'";
						document.getElementById("mediaspace'.$this->config['count'].'").style.height="'.$vheight.'";
						'.$download_video.'
					}
				');
				$doc->addScriptDeclaration('
					function Audio() {
						flowplayer().play(['.$this->playlist['audio'].']);
						document.getElementById("mediaspace'.$this->config['count'].'").style.width="'.$awidth.'";
						document.getElementById("mediaspace'.$this->config['count'].'").style.height="'.$aheight.'";
						'.$download_audio.'
					}
				');
			}
			self::$script_loaded = 1;
		}
		return;
	}
}