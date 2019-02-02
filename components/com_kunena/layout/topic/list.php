<?php
/**
 * Kunena Component
 *
 * @package         Kunena.Site
 * @subpackage      Layout.Topic
 *
 * @copyright       Copyright (C) 2008 - 2018 Kunena Team. All rights reserved.
 * @license         https://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link            https://www.kunena.org
 **/
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

/**
 * KunenaLayoutTopicList
 *
 * @since  K4.0
 */
class KunenaLayoutTopicList extends KunenaLayout
{
	/**
	 * Method to return HTML select list for time filter
	 *
	 * @param   int|string $id     Id of the HTML select list
	 * @param   string     $attrib Extra attribute to apply to the list
	 *
	 * @since Kunena
	 * @return void
	 */
	public function displayTimeFilter($id = 'filter-time', $attrib = 'class="form-control filter" onchange="this.form.submit()"')
	{
		if (!isset($this->state))
		{
			return;
		}

		// Make the select list for time selection
		$timesel[] = HTMLHelper::_('select.option', -1, JText::_('COM_KUNENA_SHOW_ALL'));
		$timesel[] = HTMLHelper::_('select.option', 0, JText::_('COM_KUNENA_SHOW_LASTVISIT'));
		$timesel[] = HTMLHelper::_('select.option', 4, JText::_('COM_KUNENA_SHOW_4_HOURS'));
		$timesel[] = HTMLHelper::_('select.option', 8, JText::_('COM_KUNENA_SHOW_8_HOURS'));
		$timesel[] = HTMLHelper::_('select.option', 12, JText::_('COM_KUNENA_SHOW_12_HOURS'));
		$timesel[] = HTMLHelper::_('select.option', 24, JText::_('COM_KUNENA_SHOW_24_HOURS'));
		$timesel[] = HTMLHelper::_('select.option', 48, JText::_('COM_KUNENA_SHOW_48_HOURS'));
		$timesel[] = HTMLHelper::_('select.option', 168, JText::_('COM_KUNENA_SHOW_WEEK'));
		$timesel[] = HTMLHelper::_('select.option', 720, JText::_('COM_KUNENA_SHOW_MONTH'));
		$timesel[] = HTMLHelper::_('select.option', 8760, JText::_('COM_KUNENA_SHOW_YEAR'));
		echo HTMLHelper::_('select.genericlist', $timesel, 'sel', $attrib, 'value', 'text', $this->state->get('list.time'), $id);
	}
}
