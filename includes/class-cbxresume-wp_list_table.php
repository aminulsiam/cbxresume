<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


/**
 * Class CBXPetitionSign_List_Table
 */
class CBXResume_List_Table extends WP_List_Table {

	function __construct() {

		//Set parent defaults
		parent::__construct( array(
			'singular' => 'cbxresume',     //singular name of the listed records
			'plural'   => 'cbxresumes',    //plural name of the listed records
			'ajax'     => false      //does this table support ajax?
		) );
	}


	/**
	 * Callback for collumn 'name'
	 *
	 * @param array $item
	 *
	 * @return string
	 */

	function column_id( $item ) {
		return '<a href="' . admin_url( 'admin.php?page=cbxresumes&view=addedit&id=' . $item['id'] ) . '">' . esc_html( $item['id'] ) . '</a>';
	}


	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/
			$this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
			/*$2%s*/
			$item['id']                //The value of the checkbox should be the record's id
		);
	}

	function column_default( $item, $column_name ) {

		switch ( $column_name ) {
			case 'id':
				return $item[ $column_name ];
			default:
				return print_r( $item, true );
		}
	}

	function get_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			'id' => esc_html__( 'ID', 'cbxresume' )
		);

		return $columns;
	}


	function get_sortable_columns() {
		$sortable_columns = array(
			'id'   => array( 'id', false ), //true means it's already sorted
			'name' => array( 'name', false )
		);

		return $sortable_columns;
	}


	/**
	 * Petition Bulk actions
	 *
	 * @return array|mixed|void
	 */
	function get_bulk_actions() {

		$bulk_actions = apply_filters( 'cbxresume_bulk_action',
			array(
				'delete' => esc_html__( 'Delete', 'cbxresume' )
			) );

		return $bulk_actions;

	}//end method get_bulk_actions

	function process_bulk_action() {

		//todo:: process your bulk action like insert, delete, email etc.

	}//end method process_bulk_action


	function prepare_items() {

		$this->process_bulk_action();

		$user   = get_current_user_id();
		$screen = get_current_screen();

		$current_page = $this->get_pagenum();

		$option_name = $screen->get_option( 'per_page', 'option' ); //the core class name is WP_Screen

		$per_page = intval( get_user_meta( $user, $option_name, true ) );


		if ( $per_page == 0 ) {
			$per_page = intval( $screen->get_option( 'per_page', 'default' ) );
		}


		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();


		$this->_column_headers = array( $columns, $hidden, $sortable );


		$order   = ( isset( $_REQUEST['order'] ) && $_REQUEST['order'] != '' ) ? $_REQUEST['order'] : 'desc';
		$orderby = ( isset( $_REQUEST['orderby'] ) && $_REQUEST['orderby'] != '' ) ? $_REQUEST['orderby'] : 'id';

		$search = ( isset( $_REQUEST['s'] ) && $_REQUEST['s'] != '' ) ? sanitize_text_field( $_REQUEST['s'] ) : '';

		$data = self::getcbxresumeData( $search, $orderby, $order, $per_page, $current_page );

		$total_items = intval( $this->getDataCount( $search, $orderby, $order ) );

		$this->items = $data;

		$this->set_pagination_args( array(
			'total_items' => $total_items,                  //WE have to calculate the total number of items
			'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
			'total_pages' => ceil( $total_items / $per_page )   //WE have to calculate the total number of pages
		) );

	} // end method prepare_items


	/**
	 * Get Data
	 *
	 * @param string $search
	 * @param string $orderby
	 * @param string $order
	 * @param int $perpage
	 * @param int $page
	 *
	 * @return array|null|object
	 */
	public static function getcbxresumeData(
		$search = '',
		$orderby = 'id',
		$order = 'desc',
		$perpage = 20,
		$page = 1
	) {

		global $wpdb;

		$store_table = $wpdb->prefix . "cbxresumes";

		$sql_select = "SELECT * FROM $store_table";

		$where_sql = '';

		if ( $search != '' ) {
			if ( $where_sql != '' ) {
				$where_sql .= ' AND ';
			}
			$where_sql .= $wpdb->prepare( " resume LIKE '%%%s%%' ", $search );
		}


		if ( $where_sql == '' ) {
			$where_sql = '1';
		}


		$start_point = ( $page * $perpage ) - $perpage;
		$limit_sql   = "LIMIT";
		$limit_sql   .= ' ' . $start_point . ',';
		$limit_sql   .= ' ' . $perpage;

		$sortingOrder = " ORDER BY $orderby $order ";

		$data = $wpdb->get_results( "$sql_select  WHERE  $where_sql $sortingOrder", 'ARRAY_A' );

		return $data;
	}//end method getcbxstoreData

	/**
	 * Get total data count
	 *
	 * @param int $perpage
	 * @param int $page
	 *
	 * @return array|null|object
	 */
	function getDataCount( $search = '', $orderby = 'id', $order = 'desc' ) {
		global $wpdb;

		$store_table = $wpdb->prefix . "cbxbussnesshours_stores";

		$sql_select = "SELECT COUNT(*) FROM $store_table";
		$where_sql  = '';

		if ( $search != '' ) {
			if ( $where_sql != '' ) {
				$where_sql .= ' AND ';
			}
			$where_sql .= $wpdb->prepare( " name LIKE '%%%s%%' ", $search );
		}

		if ( $where_sql == '' ) {
			$where_sql = '1';
		}

		$sortingOrder = " ORDER BY $orderby $order ";

		$count = $wpdb->get_var( "$sql_select  WHERE  $where_sql $sortingOrder" );

		return $count;
	}//end method getDataCount


	/**
	 * Generates content for a single row of the table
	 *toplevel_page_cbxresumes
	 * @since  3.1.0
	 * @access public
	 *
	 * @param object $item The current item
	 */
	public function single_row( $item ) {
		$row_class = 'cbxresume';
		$row_class = apply_filters( 'cbxresume_row_class', $row_class, $item );
		echo '<tr id="cbxresume_row_' . $item['id'] . '" class="' . $row_class . '">';
		$this->single_row_columns( $item );
		echo '</tr>';
	}


	/**
	 * Message to be displayed when there are no items
	 *
	 * @since  3.1.0
	 * @access public
	 */
	public function no_items() {
		echo '<div class="notice notice-info inline "><p>' . esc_html__( 'No resume found. Please change your search criteria for better result.',
				'cbxresume' ) . '</p></div>';
	}
}//end class CBXResume_List_Table
