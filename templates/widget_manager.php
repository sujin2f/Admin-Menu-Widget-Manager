<?php
/**
 * Template : Widget Manager
 *
 * @package	Admin Menu & Widget Manager
 * @author	Sujin 수진 Choi
 * @version 3.0.0
 */
?>

<div class="description">Turn off the checkbox which you don't want to see.</div>

<br />

<form id="EVNSCO-admin_widget" method="post">
	<input type="hidden" name="mode" value="EVNSCO-widget" />

	<?php
	foreach( $this->all_widget->widgets as $WP_Widget ) {
		printf( '<input type="hidden" name="AllWidgets[%s]" value="on" />', $WP_Widget->id_base );
	}
	?>

	<ul>
		<?php foreach( $this->all_widget->widgets as $WP_Widget ) { ?>
			<?php $checked = ( empty( $this->data_widget_manager[ $WP_Widget->id_base ] ) ) ? 'checked="checked"' : ''; ?>

			<li>
				<label>
					<input type="checkbox" name="WidgetItem[<?php echo $WP_Widget->id_base ?>]" <?php echo $checked ?> /> <?php echo $WP_Widget->name ?>
				</label>
			</li>
		<?php } // widget loop ?>
	</ul>

	<?php submit_button( 'Save' ); ?>
</form>
