<?php

/**
 * @package     Andromeda
 * @subpackage  hero
 *
 * @copyright   (C) 2024 Helge Lente <h.lente@gmx.net>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;

$wa = $app->getDocument()->getWebAssetManager();
$wa->useScript('hero');
$wa->useStyle('swiper');
$wa->useStyle('swiper.effect-fade');
$wa->useStyle('swiper.navigation');
$wa->useStyle('swiper.pagination');
?>

<div class="swiper hero">
  <button class="swiper-button-prev" type="button" aria-controls="hero-<?php echo($module->id)?>">
    <span class="visually-hidden"><?php echo Text::_('TPL_ANDROMEDA_CAROUSEL_PREV'); ?></span>
  </button>
  <div id="hero-<?php echo($module->id)?>" class="swiper-wrapper">
    <?php foreach ($items as $item) : ?>
        <div class="swiper-slide">
            <?php echo LayoutHelper::render('joomla.content.hero_image', $item); ?>
            <?php if ($params->get('title_only')) : ?>
                <div class="carousel-title">
                    <?php if ($params->get('item_title')) : ?>
                        <?php $item_heading = $params->get('item_heading', 'h4'); ?>
                        <<?php echo $item_heading; ?> class="mod-articles-title" itemprop="name">
                            <?php if ($params->get('link_titles') == 1) : ?>
                                <?php $attributes = ['class' => 'mod-articles-link ' . $item->active, 'itemprop' => 'url']; ?>
                                <?php $link = htmlspecialchars($item->link, ENT_COMPAT, 'UTF-8', false); ?>
                                <?php $title = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false); ?>
                                <?php echo HTMLHelper::_('link', $link, $title, $attributes); ?>
                            <?php else : ?>
                                <?php echo $item->title; ?>
                            <?php endif; ?>
                        </<?php echo $item_heading; ?>>
                    <?php endif; ?>
                </div>
                <div class="carousel-caption d-none d-md-block">
                    <?php $images = json_decode($item->images);?>
                    <?php if (isset($images->image_intro_caption) && $images->image_intro_caption !== '') : ?>
                        <p><?php echo($images->image_intro_caption); ?></p>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <div class="carousel-introtext">
                    <?php if ($params->get('item_title')) : ?>
                        <?php $item_heading = $params->get('item_heading', 'h4'); ?>
                        <<?php echo $item_heading; ?> class="mod-articles-title" itemprop="name">
                            <?php echo $item->title; ?>
                        </<?php echo $item_heading; ?>>
                    <?php endif; ?>
                    <?php if ($params->get('show_introtext')) : ?>
                        <p><?php echo($item->introtext) ?></p>
                    <?php endif; ?>
                    <?php if ($params->get('show_readmore')) : ?>
                        <?php if ($params->get('show_readmore_title', '') !== '') : ?>
                            <?php $item->params->set('show_readmore_title', $params->get('show_readmore_title')); ?>
                            <?php $item->params->set('readmore_limit', $params->get('readmore_limit')); ?>
                        <?php endif; ?>
                        <?php echo LayoutHelper::render('joomla.content.readmore', ['item' => $item, 'params' => $item->params, 'link' => $item->link]); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
      <?php endforeach ?>
  </div>
  <div class="swiper-pagination"></div>
  <!-- <div class="swiper-button-next" role="button"></div>
  <div class="swiper-button-prev"></div> -->
  <button class="swiper-button-next" type="button" aria-controls="hero-<?php echo($module->id)?>">
    <span class="visually-hidden"><?php echo Text::_('TPL_ANDROMEDA_CAROUSEL_NEXT'); ?></span>
  </button>
</div>

