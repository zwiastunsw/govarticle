<?php

/**
 * @package     GovArticle
 * @subpackage  com_govarticle
 * @author      Artur Stępień (artur.stepien@bestproject.pl)
 * @copyright   (C) 2005 - 2015 Open Source Matters. All rights reserved.
 * @copyright   (C) 2015 - Fundacja PCJ Otwarte Źródła
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0-standalone.html   
 * @link        http://dostepny.joomla.pl
 * 
 * Based on com_content from Joomla!
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$params = $this->params;
?>

<div id="archive-items">
	<?php foreach ($this->items as $i => $item) : ?>
		<?php $info = $item->params->get('info_block_position', 0); ?>
		<div class="row<?php echo $i % 2; ?>" itemscope itemtype="http://schema.org/Article">
			<div class="page-header">
				<h2 itemprop="name">
					<?php if ($params->get('link_titles')) : ?>
						<a href="<?php echo JRoute::_(GovArticleHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>" itemprop="url">
							<?php echo $this->escape($item->title); ?>
						</a>
					<?php else: ?>
						<?php echo $this->escape($item->title); ?>
					<?php endif; ?>
				</h2>
				<?php if ($params->get('show_author') && !empty($item->author )) : ?>
					<div class="createdby" itemprop="author" itemscope itemtype="http://schema.org/Person">
					<?php $author = ($item->created_by_alias) ? $item->created_by_alias : $item->author; ?>
					<?php $author = '<span itemprop="name">' . $author . '</span>'; ?>
						<?php if (!empty($item->contact_link) && $params->get('link_author') == true) : ?>
							<?php echo JText::sprintf('COM_GOVARTICLE_WRITTEN_BY', JHtml::_('link', $this->item->contact_link, $author, array('itemprop' => 'url'))); ?>
						<?php else: ?>
							<?php echo JText::sprintf('COM_GOVARTICLE_WRITTEN_BY', $author); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
			|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category')); ?>
		<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
			<div class="article-info muted">
				<dl class="article-info">
				<dt class="article-info-term">
					<?php echo JText::_('COM_GOVARTICLE_ARTICLE_INFO'); ?>
				</dt>

				<?php if ($params->get('show_parent_category') && !empty($item->parent_slug)) : ?>
					<dd>
						<div class="parent-category-name">
							<?php $title = $this->escape($item->parent_title); ?>
							<?php if ($params->get('link_parent_category') && !empty($item->parent_slug)) : ?>
								<?php $url = '<a href="' . JRoute::_(GovArticleHelperRoute::getCategoryRoute($item->parent_slug)) . '" itemprop="genre">' . $title . '</a>'; ?>
								<?php echo JText::sprintf('COM_GOVARTICLE_PARENT', $url); ?>
							<?php else : ?>
								<?php echo JText::sprintf('COM_GOVARTICLE_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
							<?php endif; ?>
						</div>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_category')) : ?>
					<dd>
						<div class="category-name">
							<?php $title = $this->escape($item->category_title); ?>
							<?php if ($params->get('link_category') && $item->catslug) : ?>
								<?php $url = '<a href="' . JRoute::_(GovArticleHelperRoute::getCategoryRoute($item->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>
								<?php echo JText::sprintf('COM_GOVARTICLE_CATEGORY', $url); ?>
							<?php else : ?>
								<?php echo JText::sprintf('COM_GOVARTICLE_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
							<?php endif; ?>
						</div>
					</dd>
				<?php endif; ?>

				<?php if ($params->get('show_publish_date')) : ?>
					<dd>
						<div class="published">
							<span class="icon-calendar"></span>
							<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'c'); ?>" itemprop="datePublished">
								<?php echo JText::sprintf('COM_GOVARTICLE_PUBLISHED_DATE_ON', JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
							</time>
						</div>
					</dd>
				<?php endif; ?>

				<?php if ($info == 0) : ?>
					<?php if ($params->get('show_modify_date')) : ?>
						<dd>
							<div class="modified">
								<span class="icon-calendar"></span>
								<time datetime="<?php echo JHtml::_('date', $item->modified, 'c'); ?>" itemprop="dateModified">
									<?php echo JText::sprintf('COM_GOVARTICLE_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_create_date')) : ?>
						<dd>
							<div class="create">
								<span class="icon-calendar"></span>
								<time datetime="<?php echo JHtml::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
									<?php echo JText::sprintf('COM_GOVARTICLE_CREATED_DATE_ON', JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
					<?php endif; ?>

					<?php if ($params->get('show_hits')) : ?>
						<dd>
							<div class="hits">
								<span class="icon-eye-open"></span> 
								<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
								<?php echo JText::sprintf('COM_GOVARTICLE_ARTICLE_HITS', $item->hits); ?>
							</div>
						</dd>
					<?php endif; ?>
				<?php endif; ?>
				</dl>
			</div>
		<?php endif; ?>

		<?php if (!$params->get('show_intro')) : ?>
			<?php echo $item->event->afterDisplayTitle; ?>
		<?php endif; ?>
		<?php echo $item->event->beforeDisplayContent; ?>
		<?php if ($params->get('show_intro')) :?>
			<div class="intro" itemprop="articleBody"> <?php echo JHtml::_('string.truncateComplex', $item->introtext, $params->get('introtext_limit')); ?> </div>
		<?php endif; ?>

		<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
			<div class="article-info muted">
				<dl class="article-info">
				<dt class="article-info-term"><?php echo JText::_('COM_GOVARTICLE_ARTICLE_INFO'); ?></dt>

				<?php if ($info == 1) : ?>
					<?php if ($params->get('show_parent_category') && !empty($item->parent_slug)) : ?>
						<dd>
							<div class="parent-category-name">
								<?php $title = $this->escape($item->parent_title); ?>
								<?php if ($params->get('link_parent_category') && $item->parent_slug) : ?>
									<?php $url = '<a href="' . JRoute::_(GovArticleHelperRoute::getCategoryRoute($item->parent_slug)) . '" itemprop="genre">' . $title . '</a>'; ?>
									<?php echo JText::sprintf('COM_GOVARTICLE_PARENT', $url); ?>
								<?php else : ?>
									<?php echo JText::sprintf('COM_GOVARTICLE_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>
								<?php endif; ?>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_category')) : ?>
						<dd>
							<div class="category-name">
								<?php $title = $this->escape($item->category_title); ?>
								<?php if ($params->get('link_category') && $item->catslug) : ?>
									<?php $url = '<a href="' . JRoute::_(GovArticleHelperRoute::getCategoryRoute($item->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>
									<?php echo JText::sprintf('COM_GOVARTICLE_CATEGORY', $url); ?>
								<?php else : ?>
									<?php echo JText::sprintf('COM_GOVARTICLE_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>
								<?php endif; ?>
							</div>
						</dd>
					<?php endif; ?>
					<?php if ($params->get('show_publish_date')) : ?>
						<dd>
							<div class="published">
								<span class="icon-calendar"></span>
								<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'c'); ?>" itemprop="datePublished">
									<?php echo JText::sprintf('COM_GOVARTICLE_PUBLISHED_DATE_ON', JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
								</time>
							</div>
						</dd>
					<?php endif; ?>
				<?php endif; ?>

				<?php if ($params->get('show_create_date')) : ?>
					<dd>
						<div class="create">
							<span class="icon-calendar"></span>
							<time datetime="<?php echo JHtml::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
								<?php echo JText::sprintf('COM_GOVARTICLE_CREATED_DATE_ON', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
							</time>
						</div>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_modify_date')) : ?>
					<dd>
						<div class="modified">
							<span class="icon-calendar"></span>
							<time datetime="<?php echo JHtml::_('date', $item->modified, 'c'); ?>" itemprop="dateModified">
								<?php echo JText::sprintf('COM_GOVARTICLE_LAST_UPDATED', JHtml::_('date', $item->modified, JText::_('DATE_FORMAT_LC3'))); ?>
							</time>
						</div>
					</dd>
				<?php endif; ?>
				<?php if ($params->get('show_hits')) : ?>
					<dd>
						<div class="hits">
							<span class="icon-eye-open"></span> 
							<meta content="UserPageVisits:<?php echo $item->hits; ?>" itemprop="interactionCount" />
							<?php echo JText::sprintf('COM_GOVARTICLE_ARTICLE_HITS', $item->hits); ?>
						</div>
					</dd>
				<?php endif; ?>
			</dl>
		</div>
		<?php endif; ?>
		<?php echo $item->event->afterDisplayContent; ?>
	</div>
	<?php endforeach; ?>
</div>
<div class="pagination">
	<p class="counter"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
