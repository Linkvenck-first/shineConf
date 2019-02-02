<?php
/**
 * @version    2.7.x
 * @package    K2
 * @author     JoomlaWorks http://www.joomlaworks.net
 * @copyright  Copyright (c) 2006 - 2016 JoomlaWorks Ltd. All rights reserved.
 * @license    GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addScript('https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.1/isotope.pkgd.min.js');
$intshow = 9;
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock k2Masonry<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>
  
	<?php if(count($items)): ?>
		<div class="masonry-list-k2 row">
		  <div class="grid-sizer"></div>
		<?php foreach ($items as $key=>$item):	?>
		  <div class="Item col-xs-6 col-md-4<?php if($key >= $intshow) echo ' hidden'; ?><?php if(count($items)==$key+1) echo ' lastItem'; ?>">
		  		<div class="item-top">
		  		<?php if($params->get('itemImage') && isset($item->image)): ?>
		  		<div class="item-image">
					<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
						<img class="img-responsive" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
					</a>
		  		</div>
				<?php endif; ?>
		  		<div class="item-body">
					<!-- Plugins: BeforeDisplay -->
					<?php echo $item->event->BeforeDisplay; ?>

					<!-- K2 Plugins: K2BeforeDisplay -->
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if($params->get('itemCategory')): ?>
					<a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>
					<?php endif; ?>

					<?php if($params->get('itemTitle')): ?>
					<div><a class="moduleItemTitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></div>
					<?php endif; ?>

			      
					<?php if($params->get('itemAuthor')): ?>
					<span class="moduleItemAuthor">
					<?php if(isset($item->authorLink)): ?>
					<?php echo JText::_('K2_WRITE_BY') ?>
					<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>">
						<?php echo $item->author; ?>
					</a>
					<?php else: ?>
					<?php echo $item->author; ?>
					<?php endif; ?>

					<?php if($params->get('userDescription')): ?>
					<?php echo $item->authorDescription; ?>
					<?php endif; ?>
							
					</span>
					<?php endif; ?>

					<?php if($params->get('itemDateCreated')): ?>
					<span class="moduleItemDateCreated"><?php echo JHTML::_('date', $item->created, "F d,Y"); ?></span>
					<?php endif; ?>

					<!-- Plugins: AfterDisplayTitle -->
					<?php echo $item->event->AfterDisplayTitle; ?>

					<!-- K2 Plugins: K2AfterDisplayTitle -->
					<?php echo $item->event->K2AfterDisplayTitle; ?>

					<!-- Plugins: BeforeDisplayContent -->
					<?php echo $item->event->BeforeDisplayContent; ?>

					<!-- K2 Plugins: K2BeforeDisplayContent -->
					<?php echo $item->event->K2BeforeDisplayContent; ?>

					<?php if($params->get('itemIntroText')): ?>
					<div class="moduleItemIntrotext">
						<?php echo $item->introtext; ?>
					</div>
					<?php endif; ?>

					<?php if($params->get('itemExtraFields') && count($item->extra_fields)): ?>
					<div class="moduleItemExtraFields">
					  <b><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></b>
					  <ul>
					    <?php foreach ($item->extra_fields as $extraField): ?>
								<?php if($extraField->value != ''): ?>
								<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
									<?php if($extraField->type == 'header'): ?>
									<h4 class="moduleItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
									<?php else: ?>
									<span class="moduleItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
									<span class="moduleItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
									<?php endif; ?>
									<div class="clr"></div>
								</li>
								<?php endif; ?>
					    <?php endforeach; ?>
					  </ul>
					</div>
					<?php endif; ?>

					<!-- Plugins: AfterDisplayContent -->
					<?php echo $item->event->AfterDisplayContent; ?>

					<!-- K2 Plugins: K2AfterDisplayContent -->
					<?php echo $item->event->K2AfterDisplayContent; ?>

					<?php if($params->get('itemTags') && count($item->tags)>0): ?>
					<div class="moduleItemTags">
						<b><?php echo JText::_('K2_TAGS'); ?>:</b>
					<?php foreach ($item->tags as $tag): ?>
					<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
					<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<?php if($params->get('itemAttachments') && count($item->attachments)): ?>
					<div class="moduleAttachments">
						<?php foreach ($item->attachments as $attachment): ?>
						<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>

					<?php if($params->get('itemReadMore') && $item->fulltext): ?>
					<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
						<?php echo JText::_('K2_READ_MORE'); ?>
					</a>
					<?php endif; ?>

					<!-- Plugins: AfterDisplay -->
					<?php echo $item->event->AfterDisplay; ?>

					<!-- K2 Plugins: K2AfterDisplay -->
					<?php echo $item->event->K2AfterDisplay; ?>
		  		</div>
		  		</div>
		  		<div class="item-bottom padding-25 clearfix">
		  			<!-- Social sharing -->
					<div class="btnSocialSharing pull-left">
						<i class="fa fa-share-alt" aria-hidden="true"></i>
					</div>
					<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>
						<div class="k2Comment pull-left hidden">
						<?php if(!empty($item->event->K2CommentsCounter)): ?>
							<!-- K2 Plugins: K2CommentsCounter -->
							<?php echo $item->event->K2CommentsCounter; ?>
						<?php else: ?>
							<?php if($item->numOfComments>0): ?>
							<a class="moduleItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
								<i class="fa fa-commenting-o" aria-hidden="true"></i>
								<span><?php echo $item->numOfComments; ?></span>
							</a>
							<?php else: ?>
							<a class="moduleItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
								<i class="fa fa-commenting-o" aria-hidden="true"></i>
							</a>
							<?php endif; ?>
						<?php endif; ?>
						</div>
					<?php endif; ?>
					

					<?php if($params->get('feed')): ?>
					<div class="k2FeedIcon pull-right">
						<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
							<i class="fa fa-rss" aria-hidden="true"></i>
							<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
						</a>
						<div class="clr"></div>
					</div>
					<?php endif; ?>
					<?php if($params->get('itemHits')): ?>
					<span class="moduleItemHits pull-right hidden">
						<i class="fa fa-eye" aria-hidden="true"></i>
						<span><?php echo $item->hits; ?></span>
					</span>
					<?php endif; ?>
		  		</div>
		  </div>
		<?php endforeach; ?>
		</div>

  	<?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
	<a class="btn btn-default moduleCustomLink" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
	<?php endif; ?>
	<div class="text-center"><button id="load-more" class="btn btn-default">Load More</button></div>
	
</div>