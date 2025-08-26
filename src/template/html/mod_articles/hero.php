<?php

/**
 * @package     Andromeda
 * @subpackage  carousel
 *
 * @copyright   (C) 2024 Helge Lente <h.lente@gmx.net>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
// $wa = $app->getDocument()->getWebAssetManager();
// $wa->registerAndUseStyle('mod_articles', 'mod_articles/mod-articles.css');

if (!$list) {
    return;
}

$items = $list;

require ModuleHelper::getLayoutPath('mod_articles', 'hero_items'); ?>
