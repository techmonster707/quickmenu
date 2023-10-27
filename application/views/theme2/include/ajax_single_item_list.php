<?php if(count($item_list) > 0): ?>
<div class="row" id="">
<?php foreach ($item_list as $key => $row): ?>
	<div class="col-md-6">
		<div class="homeSingle_item">
			<div class="homeSingleImg menu-img img bg_loader" data-src="<?= get_img($row['thumb'],$row['img_url'],$row['img_type']) ;?>" style="background: url(<?= img_loader() ;?>);">
				<?php if(isset($row['veg_type']) && $row['veg_type'] !=0): ?> <i class="fa fa-circle veg_type <?= $row['veg_type']==1?'c_green':'c_red';?> style2" data-placement="top" data-toggle="tooltip" title="<?= veg_type($row['veg_type']);?>"></i><?php endif;?>
			</div>

			<div class="homeItemDetails list_view">
				<div class="homeItem_left">
					<div class="topTitle">
						<h4><?= html_escape($row['title']) ;?></h4>
					</div>
					<div class="price_section">
						<p>
							<?php if(isJson($row['allergen_id'])): ?>
							<span class="capital fz-13"><?= !empty(lang('allergens'))?lang('allergens'):'allregens' ;?>: <?= is_array(json_decode($row['allergen_id']))?allergens(json_decode($row['allergen_id'])):"";?></span>
						<?php endif;?>
					</p>
					<?php if($row['is_size']==0): ?>
						<p class="details">
							<?= character_limiter(html_escape($row['overview']),120) ;?>
						</p>
					<?php endif;?>
					<?php if($row['is_size']==1): ?>
						<div class="itemPrice_area i_small ">
							<?php $price = json_decode($row['price'],TRUE); ?>
							<?php foreach ($price as $key => $value):
								if(!empty($value)):
									?>
									<div class="itemPrice i_small ">
										<p class="smallItem_size"><?= $this->admin_m->get_size_by_slug($key,$row['user_id']);?> :  <?= currency_position($value,$shop_id);?></p>
									</div>
									<?php
								endif; 
							endforeach; 
							?>
						</div>
					<?php endif;?>
				</div>
				<div class="port_d_flex home_view">
					<a href="javascript:;" class="quick_view" data-id="<?=  html_escape($row['item_id']);?>" data-placement="top" data-toggle=""  title="Quick View"><i class="icofont-eye-open"></i> <?= lang('details'); ?></a>

					<?php if($row['is_size']==1): ?>
						<a href="javascript:;" class="quick_view" data-id="<?=  html_escape($row['item_id']);?>" data-placement="top" data-toggle=""  title="Quick View"><i class="icofont-ui-cart"></i> <?= lang('order_now'); ?></a>

					<?php else: ?>

					<?php if(shop($row['shop_id'])->is_cart == 1): ?>

						<?php if(shop($row['shop_id'])->stock_status == 1): ?>

							<?php if($row['in_stock'] > $row['remaining']): ?>
								<a href="javascript:;" class="add_to_cart" data-id="<?=  html_escape($row['item_id']);?>" data-type="item" data-placement="top" data-toggle="" title="Add to Cart"><i class="icofont-ui-cart"></i> <?= lang('order_now'); ?></a>
							<?php endif;?>

						<?php else: ?>
							<a href="javascript:;" class="add_to_cart" data-id="<?=  html_escape($row['item_id']);?>" data-type="item" data-placement="top" data-toggle="" title="Add to Cart"><i class="icofont-ui-cart"></i> <?= lang('order_now'); ?></a>

						<?php endif;?>
						
					<?php endif;?>

					<?php endif;?>
				</div>
			</div>
			<div class="homeItem_right">
				<?php if($row['is_size']==0): ?>
					<p><?= currency_position($row['price'],$shop_id); ?> </p>
				<?php endif;?>
			</div>

			</div>
		</div>
	</div>
<?php endforeach ?>

        	
</div><!-- row/2 -->
<div class="row text-center">
	<div class="ci-paginationArea">
		<div class="ci-pagination-link" data-id="<?= $cat_id;?>" data-slug="<?= $slug;?>">
			<div id="pagination"><?= $this->pagination->create_links();?></div>
		</div>
	</div>
</div>
<?php else: ?>
	<div class="row">
		<div class="col-md-12">
			<div class="not-found">
				<i class="fa fa-frown"></i>
				<h4><?= !empty(lang('not_found'))?lang('not_found'):'Not Found' ;?></h4>
			</div>
		</div>
	</div>
<?php endif;?>