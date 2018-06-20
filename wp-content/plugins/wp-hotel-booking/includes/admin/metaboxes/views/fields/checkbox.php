<?php

/**
 * Admin View: Admin meta box checkbox field.
 *
 * @version     1.9.7
 * @package     WP_Hotel_Booking/Views
 * @category    View
 * @author      Thimpress, leehld
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit;
?>

<?php
$field = wp_parse_args( $field, array(
	'id'     => '',
	'name'   => '',
	'std'    => '',
	'attr'   => '',
	'filter' => null
) );

$field_attr = '';
if ( $field['attr'] ) {
	if ( is_array( $field['attr'] ) ) {
		$field_attr = join( " ", $field['attr'] );
	} else {
		$field_attr = $field['attr'];
	}
}

$value = $field['std'];
if ( is_callable( $field['filter'] ) ) {
	$value = call_user_func_array( $field['filter'], array( $value ) );
}

printf( '<input type="checkbox" name="%s" id="%s" %s %s value="1"/>', $field['name'], $field['id'], checked( $value, 1, false ), $field_attr ); ?>