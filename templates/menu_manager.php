<?php
/**
 * Template : Menu Manager
 *
 * @package	Admin Menu & Widget Manager
 * @author	Sujin 수진 Choi
 * @version 3.0.0
 */
?>

<div class="description">Turn off the checkbox which you don't want to see.</div>

<br />

<form id="EVNSCO-admin_menu" method="post">
	<input type="hidden" name="mode" value="EVNSCO-menu" />

	<?php
	foreach( $this->all_menu as $menu_item ) {
		if ( empty( $menu_item[0] ) ) continue;

		printf( '<input type="hidden" name="AllMenu[%s]" value="on" />', $menu_item[2] );

		if ( !empty( $this->all_sub_menu[ $menu_item[2] ] ) ) {
			foreach( $this->all_sub_menu[ $menu_item[2] ] as $sub_menu_item ) {
				printf( '<input type="hidden" name="AllSubMenu[%s][%s]" value="on" />', $menu_item[2], $sub_menu_item[2] );
			}
		}
	}
	?>

	<ul>
		<?php foreach( $this->all_menu as $menu_item ) { ?>
			<?php if ( empty( $menu_item[0] ) ) continue; ?>
			<?php extract( $this->GetMenuItemListVars( $menu_item ) ); ?>

			<li class="<?php echo $li_class ?>">
				<span class="dashicons dashicons-arrow-right"></span>

				<label>
					<?php if ( $name !== 'Appearance' ) { ?>
						<input type="checkbox" name="MenuItem[<?php echo $menu_id ?>]" <?php echo $checked ?> />
					<?php } ?>
					<?php echo $name ?>
				</label>

				<?php if ( !$li_class ) { ?>

				<ul>
					<?php foreach( $this->all_sub_menu[ $menu_id ] as $sub_menu_item ) { ?>
						<?php extract( $this->GetSubMenuItemListVars( $menu_id, $sub_menu_item ) ); ?>

						<?php if ( $name !== 'Admin Menu Manager' ) { ?>
							<li>
								<label>
									<input type="checkbox" name="SubMenuItem[<?php echo $menu_id ?>][<?php echo $sub_id ?>]" <?php echo $checked ?> /> <?php echo $name ?>
								</label>
							</li>
						<?php } // !Admin Menu Manager ?>
					<?php } // submenu loop ?>
				</ul>

				<?php	} // submenu if ?>
			</li>
		<?php } // menu loop ?>
	</ul>

	<?php submit_button( 'Save' ); ?>
</form>
