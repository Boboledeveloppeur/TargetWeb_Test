			<aside role="complementary">
				<div class="panel bordered filled">
					<h2>
						Les Temps de Cuissons
					</h2>
					<?php $list_cuisines = wp_list_categories('echo=0&title_li=&taxonomy=recipe_cuisine&show_option_none='.__('No cuisines added yet').''); ?>
					<ul>
						<?= $list_cuisines; ?>
					</ul>
					<h2>
						Tous les ingredients
					</h2>
					<?php $list_ingredients = wp_list_categories('echo=0&title_li=&taxonomy=recipe_ingredient&show_option_none='.__('No ingredients added yet').''); ?>
					<ul>
						<?= $list_ingredients; ?>
					</ul>
				</div>
			</aside>
