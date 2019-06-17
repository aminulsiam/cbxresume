<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class CBXResumeHelper {


	/**
	 *  Create table when plugin installation.
	 */
	public static function create_table() {
		//check if can activate plugin
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
		check_admin_referer( "activate-plugin_{$plugin}" );

		global $wpdb;

		//old name
		$cbxresume_table = $wpdb->prefix . 'cbxresumes';

		//db table migration if exists
		$charset_collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$charset_collate .= " COLLATE $wpdb->collate";
			}
		}

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		//create cbxresumes table
		$cbxresume_table_sql = "CREATE TABLE $cbxresume_table (
                          id bigint(11) unsigned NOT NULL AUTO_INCREMENT,
                          intro varchar(255) NOT NULL,
                          resume longtext NOT NULL ,
                          add_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who add this category',
                          mod_by bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'foreign key of user table. who modified this category',
                          add_date datetime DEFAULT NULL COMMENT 'created date',
                          mod_date datetime DEFAULT NULL COMMENT 'modified date',
                          PRIMARY KEY (id)
                        ) $charset_collate; ";

		dbDelta( array( $cbxresume_table_sql ) );
	} // end create_table method


	/**
	 * Display wp list table
	 */
	public static function displayResumeTableList() {

		if ( ! class_exists( 'CBXResumeListTable' ) ) {
			include_once CBXRESUME_ROOT_PATH . "includes/class-cbxresume-wp_list_table.php";
		}

		$cbxresume_list_table = new CBXResume_List_Table();
		?>
        <div class="wrap wqmain_body">

            <h2><?php echo esc_html__( 'Resume Details', 'cbxresume' ); ?></h2>

            <p>
                <a href="<?php echo admin_url( 'admin.php?page=cbxresumes&view=addedit' ) ?>"
                   class="button-primary">
					<?php echo esc_html__( 'Add new', 'cbxresume' ); ?>
                </a>
            </p>

            <form id="entry-table" method="GET">
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
				<?php
                    $cbxresume_list_table->prepare_items();
                    $cbxresume_list_table->search_box( 'search', 'search_id' );
                    $cbxresume_list_table->display();
				?>
            </form>
        </div>
		<?php
	} // end method displayResumeTableList


	/**
	 * Get resume data from database
	 *
	 * @param $wpdb , global properties of WP
	 * @param @int $resume_id, Get resume data by this variable
	 *
	 * @return array
	 */
	public static function getCbxresumeData( $wpdb, $resume_id ) {

		$resume_table = $wpdb->prefix . "cbxresumes";

		$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $resume_table WHERE id=%d", $resume_id ),
			'ARRAY_A' );

		$cbxresume_educations = maybe_unserialize( $data['resume'] );

		return $cbxresume_educations;
	} // end method getCbxresumeData


}//end class CBXResumeHelper