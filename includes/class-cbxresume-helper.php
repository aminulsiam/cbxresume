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
	public static function getResumeData( $wpdb, $atts ) {

		$resume_table = $wpdb->prefix . "cbxresumes";


		if ( '' == $atts['id'] & is_array( $atts ) ) {

			$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $resume_table WHERE add_by=%d ORDER BY id DESC
 lIMIT 1", get_current_user_id() ), 'ARRAY_A' );

			$cbxresume_data = maybe_unserialize( $data['resume'] );

			return $cbxresume_data;
		}

		//Get the data for update resume by indivisual id
		$data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $resume_table WHERE id=%d", $atts ),
			'ARRAY_A' );

		$cbxresume_data = maybe_unserialize( $data['resume'] );

		return $cbxresume_data;


	} // end method getCbxresumeData


	/**
	 * Add Skill field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Skill_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_skill">';

		$field .= '<input type="text" name="cbxresume[skill][' . $last_count_val . ']" 
				   placeholder="' . esc_html__( 'write your skill', 'cbxresume' ) . '" /> 
				   
		           <a href="#" class="button cbxresume_skill_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method cbxresumeAddSkillField


	/**
	 * Resume Education field is create form here.
	 *
	 * @param $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Education_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_education">
					<input type="text" name="cbxresume[education][' . $last_count_val . '][institute]"
					 placeholder="' . esc_html__( 'School/University', 'cbxresume' ) . '" />
					<input type="text" name="cbxresume[education][' . $last_count_val . '][degree]" 
					placeholder="' . esc_html__( 'Degree', 'cbxresume' ) . '" />
					<input type="text" name="cbxresume[education][' . $last_count_val . '][field]" 
					placeholder="' . esc_html__( 'Field', 'cbxresume' ) . '" />';


		$field .= '<select name="cbxresume[education][' . $last_count_val . '][from]">
					<option value="">' . esc_html__( 'From', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';


		$field .= '<select name="cbxresume[education][' . $last_count_val . '][to]"><option value="">' . esc_html__(
				'To', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';

		$field .= '<input type="text" name="cbxresume[education][' . $last_count_val . '][grade]" placeholder="grade" />
					<input type="text" name="cbxresume[education][' . $last_count_val . '][activity]"
					 placeholder="' . esc_html__( 'Activity', 'cbxresume' ) . '" />
					<input type="text" name="cbxresume[education][' . $last_count_val . '][description]"
					 placeholder="' . esc_html__( 'Description', 'cbxresume' ) . '" />
					<a href="#" class="button cbxresume_education_remove"><span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>' . esc_html__( 'Remove',
				'cbxresume' ) . '</a>
					</div>';

		return $field;

	}// end method resumeAdd_Education_Field

	/**
	 * Add Experience field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Experience_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_experience">';

		$field .= '<input type="text" name="cbxresume[experience][' . $last_count_val . '][title]" 
				   placeholder="' . esc_html__( 'Title/Designation', 'cbxresume' ) . '" />
				    
				   <input type="text" name="cbxresume[experience][' . $last_count_val . '][company]" 
				   placeholder="' . esc_html__( 'Company name', 'cbxresume' ) . '" />';

		$field .= '</select>';


		$field .= '<select name="cbxresume[experience][' . $last_count_val . '][start_date]"><option value="">' . esc_html__(
				'Start date', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';

		$field .= '<input type="text" name="cbxresume[experience][' . $last_count_val . '][description]" 
		           placeholder="' . esc_html__( 'Description', 'cbxresume' ) . '"/> 
		           <a href="#" class="button cbxresume_experience_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_Experience_Field


	/**
	 * Add Language field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Language_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_language">';

		$field .= '<input type="text" name="cbxresume[language][' . $last_count_val . '][language_name]" 
				   placeholder="' . esc_html__( 'Language', 'cbxresume' ) . '" />';

		$field .= '</select>';

		$language_proficiency = CBXResumeHelper::getLanguageProficiency();

		$field .= ' <select name="cbxresume[language][' . $last_count_val . '][language_proficiency]">';

		foreach ( $language_proficiency as $key => $language ) {
			$field .= '<option value="' . $key . '">' . $language . '</option>';
		}

		$field .= '</select>';


		$field .= ' <a href="#" class="button cbxresume_language_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_Language_Field


	/**
	 * Add License field is create from here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_License_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_license">';

		$field .= '<input type="text" name="cbxresume[license][' . $last_count_val . '][name]" 
				   placeholder="' . esc_html__( 'Name', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[license][' . $last_count_val . '][issuing_organization]" 
				   placeholder="' . esc_html__( 'Issuing Organization', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[license][' . $last_count_val . '][issue_date]" 
				   placeholder="' . esc_html__( 'Issue date', 'cbxresume' ) . '" /> 
				   
		           <a href="#" class="button cbxresume_license_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_License_Field


	/**
	 * Add Volunteer field is create from here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Volunteer_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_volunteer">';

		$field .= '<input type="text" name="cbxresume[volunteer][' . $last_count_val . '][organization]" 
				   placeholder="' . esc_html__( 'Organization', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[volunteer][' . $last_count_val . '][role]" 
				   placeholder="' . esc_html__( 'Role', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[volunteer][' . $last_count_val . '][cause]" 
				   placeholder="' . esc_html__( 'Cause', 'cbxresume' ) . '" />';

		$field .= '<select name="cbxresume[volunteer][' . $last_count_val . '][from]">
					<option value="">' . esc_html__( 'From', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';

		$field .= '<select name="cbxresume[volunteer][' . $last_count_val . '][to]"><option value="">' . esc_html__(
				'To', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';

		$field .= '<input type="text" name="cbxresume[volunteer][' . $last_count_val . '][description]" 
				   placeholder="' . esc_html__( 'Description', 'cbxresume' ) . '" />  
				   
		           <a href="#" class="button cbxresume_volunteer_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resume resumeAdd_Volunteer_Field


	/**
	 * Add publication field is create from here.
	 *
	 * @param $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_publication_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_publication">';

		$field .= '<input type="text" name="cbxresume[publication][' . $last_count_val . '][title]" 
				   placeholder="' . esc_html__( 'Title', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[publication][' . $last_count_val . '][publisher]" 
				   placeholder="' . esc_html__( 'Publisher', 'cbxresume' ) . '" /> ';


		$field .= '<select name="cbxresume[publication][' . $last_count_val . '][year]">
					<option value="">' . esc_html__( 'Year', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';


		$publication_month = CBXResumeHelper::getResumeMonth();

		$field .= '<select name="cbxresume[publication][' . $last_count_val . '][month]">
					<option value="">' . esc_html__( 'Month', 'cbxresume' ) . '</option>';

		foreach ( $publication_month as $key => $month ) {
			$field .= '<option value="' . $key . '">' . $month . '</option>';
		}

		$field .= '</select>';

		$field .= '<select name="cbxresume[publication][' . $last_count_val . '][day]">
					<option value="">' . esc_html__( 'Day', 'cbxresume' ) . '</option>';

		for ( $i = 1; $i <= 31; $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';


		$field .= '<input type = "text" name = "cbxresume[publication][' . $last_count_val . '][writter]" 
				   placeholder = "' . esc_html__( 'Writter', 'cbxresume' ) . '" />
				   
				   <input type = "text" name = "cbxresume[publication][' . $last_count_val . '][publication_url]" 
				   placeholder = "' . esc_html__( 'Publication url', 'cbxresume' ) . '" />
				   
				   <input type = "text" name = "cbxresume[publication][' . $last_count_val . '][description]" 
				   placeholder = "' . esc_html__( 'Description', 'cbxresume' ) . '" />      
				   
		           <a href = "#" class="button cbxresume_publication_remove" >
		           <span class="dashicons dashicons-trash" style = "margin-top: 3px;color: red;" ></span > '
		          . esc_html__( 'Remove', 'cbxresume' ) . ' </a > ';

		$field .= '</div > ';

		return $field;

	} // end method resumeAdd_publication_Field


	/**
	 * Add Course field is create from here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Course_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_course">';

		$field .= '<input type="text" name="cbxresume[course][' . $last_count_val . '][name]" 
				   placeholder="' . esc_html__( 'Name', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[course][' . $last_count_val . '][number]" 
				   placeholder="' . esc_html__( 'Course number', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[course][' . $last_count_val . '][associated_with]" 
				   placeholder="' . esc_html__( 'Associated with others', 'cbxresume' ) . '" /> 
				   
		           <a href="#" class="button cbxresume_course_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_Course_Field

	/**
	 * Add project field is create from here.
	 *
	 * @param $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Project_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_project">';

		$field .= '<input type="text" name="cbxresume[project][' . $last_count_val . '][project_name]" 
				   placeholder="' . esc_html__( 'Project name', 'cbxresume' ) . '" /> | ';


		$publication_month = CBXResumeHelper::getResumeMonth();

		$field .= '<label>' . esc_html__( 'Start date', 'cbxresume' ) . '</label>';

		$field .= '<select name="cbxresume[project][' . $last_count_val . '][month]">
					<option value="">' . esc_html__( 'Month', 'cbxresume' ) . '</option>';

		foreach ( $publication_month as $key => $month ) {
			$field .= '<option value="' . $key . '">' . $month . '</option>';
		}

		$field .= '</select>';


		$field .= '<select name="cbxresume[project][' . $last_count_val . '][year]">
					<option value="">' . esc_html__( 'Year', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select> | ';


		$field .= '<input type = "text" name = "cbxresume[project][' . $last_count_val . '][writter]" 
				   placeholder = "' . esc_html__( 'Writter', 'cbxresume' ) . '" />
				   
				   <input type = "text" name = "cbxresume[project][' . $last_count_val . '][project_url]" 
				   placeholder = "' . esc_html__( 'Project url', 'cbxresume' ) . '" />
				   
				   <input type = "text" name = "cbxresume[project][' . $last_count_val . '][associated_with]" 
				   placeholder = "' . esc_html__( 'Description', 'cbxresume' ) . '" />      
				   
		           <a href = "#" class="button cbxresume_project_remove" >
		           <span class="dashicons dashicons-trash" style = "margin-top: 3px;color: red;" ></span > '
		          . esc_html__( 'Remove', 'cbxresume' ) . ' </a > ';

		$field .= '</div > ';

		return $field;


	} // end method resumeAdd_Project_Field


	/**
	 * Add Honors & Awards field is create from here.
	 *
	 * @param $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Honors_Awards_Field(
		$last_count_val
	) {


		$field = '<div class="cbxresume_honor_award">';

		$field .= '<input type="text" name="cbxresume[honor_award][' . $last_count_val . '][title]" 
				   placeholder="' . esc_html__( 'Title', 'cbxresume' ) . '" /> 
				  
				   <input type = "text" name = "cbxresume[honor_award][' . $last_count_val . '][associated_with]" 
				   placeholder = "' . esc_html__( 'Associated with', 'cbxresume' ) . '" /> 
				   
				   <input type = "text" name = "cbxresume[honor_award][' . $last_count_val . '][issuer]" 
				   placeholder = "' . esc_html__( 'Issuer', 'cbxresume' ) . '" />';


		$publication_month = CBXResumeHelper::getResumeMonth();

		$field .= '<label>' . esc_html__( 'Start date', 'cbxresume' ) . '</label>';

		$field .= '<select name="cbxresume[honor_award][' . $last_count_val . '][month]">
					<option value="">' . esc_html__( 'Month', 'cbxresume' ) . '</option>';

		foreach ( $publication_month as $key => $month ) {
			$field .= '<option value="' . $key . '">' . $month . '</option>';
		}

		$field .= '</select>';


		$field .= '<select name="cbxresume[honor_award][' . $last_count_val . '][year]">
					<option value="">' . esc_html__( 'Year', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select> | ';


		$field .= '<input type = "text" name = "cbxresume[honor_award][' . $last_count_val . '][description]" 
				   placeholder = "' . esc_html__( 'Description', 'cbxresume' ) . '" />
				   
		           <a href = "#" class="button cbxresume_honor_award_remove" >
		           <span class="dashicons dashicons-trash" style = "margin-top: 3px;color: red;" ></span > '
		          . esc_html__( 'Remove', 'cbxresume' ) . ' </a > ';

		$field .= '</div > ';

		return $field;


	} // end method resumeAdd_Honors_Awards_Field


	/**
	 * Add Test score field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Test_Score_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_test_score">';

		$field .= '<input type="text" name="cbxresume[test_score][' . $last_count_val . '][test_name]" 
				   placeholder="' . esc_html__( 'write your test name', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[test_score][' . $last_count_val . '][associated_with]" 
				   placeholder="' . esc_html__( 'Associated with ', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[test_score][' . $last_count_val . '][score]" 
				   placeholder="' . esc_html__( 'Score', 'cbxresume' ) . '" />';


		$test_score_month = CBXResumeHelper::getResumeMonth();

		$field .= '<label>  | ' . esc_html__( 'Start date', 'cbxresume' ) . '</label>';

		$field .= '<select name="cbxresume[test_score][' . $last_count_val . '][month]">
					<option value="">' . esc_html__( 'Month', 'cbxresume' ) . '</option>';

		foreach ( $test_score_month as $key => $month ) {
			$field .= '<option value="' . $key . '">' . $month . '</option>';
		}

		$field .= '</select>';


		$field .= '<select name="cbxresume[test_score][' . $last_count_val . '][year]">
					<option value="">' . esc_html__( 'Year', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select> | ';


		$field .= '<input type = "text" name = "cbxresume[test_score][' . $last_count_val . '][description]" 
				   placeholder = "' . esc_html__( 'Description', 'cbxresume' ) . '" />
				   
				   <a href="#" class="button cbxresume_test_score_remove">
				   <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_Test_Score_Field


	/**
	 * Add Skill field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_Organization_Field(
		$last_count_val
	) {

		$field = '<div class="cbxresume_test_score">';

		$field .= '<input type="text" name="cbxresume[organization][' . $last_count_val . '][name]" 
				   placeholder="' . esc_html__( 'write your organization name', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[organization][' . $last_count_val . '][position_held]" 
				   placeholder="' . esc_html__( 'Position ', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[organization][' . $last_count_val . '][assciated_with]" 
				   placeholder="' . esc_html__( 'Associated with', 'cbxresume' ) . '" />';


		$organization_month = CBXResumeHelper::getResumeMonth();

		$field .= '<label>  | ' . esc_html__( 'Start date', 'cbxresume' ) . '</label>';

		$field .= '<select name="cbxresume[organization][' . $last_count_val . '][start_month]">
					<option value="">' . esc_html__( 'Month', 'cbxresume' ) . '</option>';

		foreach ( $organization_month as $key => $month ) {
			$field .= '<option value="' . $key . '">' . $month . '</option>';
		}

		$field .= '</select>';


		$field .= '<select name="cbxresume[organization][' . $last_count_val . '][start_year]">
					<option value="">' . esc_html__( 'Year', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select> | ';


		$field .= '<input type = "text" name = "cbxresume[organization][' . $last_count_val . '][description]" 
				   placeholder = "' . esc_html__( 'Description', 'cbxresume' ) . '" />
				   
				   <a href="#" class="button cbxresume_organization_remove">
				   <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_Test_Score_Field


	/**
	 * Add patent field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public
	static function resumeAdd_patent_Field(
		$last_count_val
	) {


		$field = '<div class="cbxresume_patent">';

		$field .= '<input type="text" name="cbxresume[patent][' . $last_count_val . '][title]" 
				   placeholder="' . esc_html__( 'write your organization name', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[patent][' . $last_count_val . '][office]" 
				   placeholder="' . esc_html__( 'Position ', 'cbxresume' ) . '" /> 
				   
				   <input type="text" name="cbxresume[patent][' . $last_count_val . '][application_number]" 
				   placeholder="' . esc_html__( 'Associated with', 'cbxresume' ) . '" />';


		$organization_month = CBXResumeHelper::getResumeMonth();

		$field .= '<label>  | ' . esc_html__( 'Issue date', 'cbxresume' ) . '</label>';

		$field .= '<select name="cbxresume[patent][' . $last_count_val . '][issue_month]">
					<option value="">' . esc_html__( 'Month', 'cbxresume' ) . '</option>';

		foreach ( $organization_month as $key => $month ) {
			$field .= '<option value="' . $key . '">' . $month . '</option>';
		}

		$field .= '</select>';

		$field .= '</select>';

		$field .= '<select name="cbxresume[patent][' . $last_count_val . '][issue_day]">
					<option value="">' . esc_html__( 'Day', 'cbxresume' ) . '</option>';

		for ( $i = 1; $i <= 31; $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select>';


		$field .= '<select name="cbxresume[patent][' . $last_count_val . '][issue_year]">
					<option value="">' . esc_html__( 'Year', 'cbxresume' ) . '</option>';

		for ( $i = 2000; $i <= date( 'Y' ); $i ++ ) {
			$field .= '<option value="' . $i . '">' . $i . '</option>';
		}

		$field .= '</select> | ';


		$field .= '<input type = "text" name = "cbxresume[patent][' . $last_count_val . '][patent_url]" 
				   placeholder = "' . esc_html__( 'Patent url', 'cbxresume' ) . '" />
				   
				   <input type = "text" name = "cbxresume[patent][' . $last_count_val . '][description]" 
				   placeholder = "' . esc_html__( 'Description', 'cbxresume' ) . '" />
				   
				   <a href="#" class="button cbxresume_patent_remove">
				   <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAdd_patent_Field


	/**
	 * Get all language proficiency list form here.
	 *
	 * @return array
	 */
	public
	static function getLanguageProficiency() {

		$language_proficiency = array(
			'elementary'           => esc_html__( 'Elementary proficiency', 'cbxresume' ),
			'limited_working'      => esc_html__( 'Limited working proficiency', 'cbxresume' ),
			'professional_working' => esc_html__( 'Professional working proficiency', 'cbxresume' ),
			'full_professional'    => esc_html__( 'Full professional proficiency', 'cbxresume' ),
			'native_or_bilingual'  => esc_html__( 'Native or bilingual proficiency', 'cbxresume' ),
		);

		return $language_proficiency;

	} // end method getLanguageProficiency


	/**
	 * Get all publication month list form here.
	 *
	 * @return array
	 */
	public
	static function getResumeMonth() {

		$publication_month = array(
			'jan' => esc_html__( 'January', 'cbxresume' ),
			'feb' => esc_html__( 'February', 'cbxresume' ),
			'mar' => esc_html__( 'March', 'cbxresume' ),
			'apr' => esc_html__( 'April', 'cbxresume' ),
			'may' => esc_html__( 'May', 'cbxresume' ),
			'jun' => esc_html__( 'June', 'cbxresume' ),
			'jul' => esc_html__( 'July', 'cbxresume' ),
			'agu' => esc_html__( 'Aguest', 'cbxresume' ),
			'sep' => esc_html__( 'September', 'cbxresume' ),
			'oct' => esc_html__( 'October', 'cbxresume' ),
			'nov' => esc_html__( 'November', 'cbxresume' ),
			'dec' => esc_html__( 'December', 'cbxresume' )
		);

		return $publication_month;

	} // end method getLanguageProficiency

	/**
	 * Get cbxresume data for shortcode
	 *
	 * @param $cbxresume_data
	 */
	public
	static function displayResumeData(
		$cbxresume_data
	) {

		?>
        <h3><?php echo esc_html__( 'Education', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_education = isset( $cbxresume_data['education'] ) ? $cbxresume_data['education'] : array();

			foreach ( $cbxresume_education as $education ) {
				?>
                <li><?php esc_html_e( $education['institute'] ) ?></li>
                <li><?php esc_html_e( $education['degree'] ) ?></li>
                <li><?php esc_html_e( $education['field'] ) ?></li>
                <li><?php esc_html_e( $education['from'] ) ?></li>
                <li><?php esc_html_e( $education['to'] ) ?></li>
                <li><?php esc_html_e( $education['grade'] ) ?></li>
                <li><?php esc_html_e( $education['activity'] ) ?></li>
                <li><?php esc_html_e( $education['description'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Experience', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_experience = isset( $cbxresume_data['experience'] ) ? $cbxresume_data['experience'] : array();

			foreach ( $cbxresume_experience as $experience ) {
				?>
                <li><?php esc_html_e( $experience['title'] ) ?></li>
                <li><?php esc_html_e( $experience['company'] ) ?></li>
                <li><?php esc_html_e( $experience['start_date'] ) ?></li>
                <li><?php esc_html_e( $experience['description'] ) ?></li>
			<?php } ?>
        </ul>


        <h3><?php echo esc_html__( 'Language', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_language = isset( $cbxresume_data['language'] ) ? $cbxresume_data['language'] : array();

			foreach ( $cbxresume_language as $language ) {
				?>
                <li><?php esc_html_e( $language['language_name'] . " : " . $language['language_proficiency'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'License', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_license = isset( $cbxresume_data['license'] ) ? $cbxresume_data['license'] : array();

			foreach ( $cbxresume_license as $license ) {
				?>
                <li><?php esc_html_e( $license['name'] ) ?></li>
                <li><?php esc_html_e( $license['issuing_organization'] ) ?></li>
                <li><?php esc_html_e( $license['issue_date'] ) ?></li>
			<?php } ?>
        </ul>


        <h3><?php echo esc_html__( 'Volunteer', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_volunteer = isset( $cbxresume_data['volunteer'] ) ? $cbxresume_data['volunteer'] : array();

			foreach ( $cbxresume_volunteer as $volunteer ) {
				?>
                <li><?php esc_html_e( $volunteer['organization'] ) ?></li>
                <li><?php esc_html_e( $volunteer['role'] ) ?></li>
                <li><?php esc_html_e( $volunteer['cause'] ) ?></li>
                <li><?php esc_html_e( $volunteer['from'] ) ?></li>
                <li><?php esc_html_e( $volunteer['to'] ) ?></li>
                <li><?php esc_html_e( $volunteer['description'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Skill', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_skill = isset( $cbxresume_data['skill'] ) ? $cbxresume_data['skill'] : array();

			foreach ( $cbxresume_skill as $skill ) {
				?>
                <li><?php esc_html_e( $skill ) ?></li>
			<?php } ?>
        </ul>


        <h3><?php echo esc_html__( 'Publication', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_publication = isset( $cbxresume_data['publication'] ) ? $cbxresume_data['publication'] : array();

			foreach ( $cbxresume_publication as $publication ) {
				?>
                <li><?php esc_html_e( $publication['title'] ) ?></li>
                <li><?php esc_html_e( $publication['publisher'] ) ?></li>
                <li><?php esc_html_e( $publication['year'] ) ?></li>
                <li><?php esc_html_e( $publication['month'] ) ?></li>
                <li><?php esc_html_e( $publication['day'] ) ?></li>
                <li><?php esc_html_e( $publication['writter'] ) ?></li>
                <li><?php esc_html_e( $publication['publication_url'] ) ?></li>
                <li><?php esc_html_e( $publication['description'] ) ?></li>
			<?php } ?>
        </ul>


        <h3><?php echo esc_html__( 'Course', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_course = isset( $cbxresume_data['course'] ) ? $cbxresume_data['course'] : array();

			foreach ( $cbxresume_course as $course ) {
				?>
                <li><?php esc_html_e( $course['name'] ) ?></li>
                <li><?php esc_html_e( $course['number'] ) ?></li>
                <li><?php esc_html_e( $course['associated_with'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Project', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_project = isset( $cbxresume_data['project'] ) ? $cbxresume_data['project'] : array();

			foreach ( $cbxresume_project as $project ) {
				?>
                <li><?php esc_html_e( $project['project_name'] ) ?></li>
                <li><?php esc_html_e( $project['month'] ) ?></li>
                <li><?php esc_html_e( $project['year'] ) ?></li>
                <li><?php esc_html_e( $project['writter'] ) ?></li>
                <li><?php esc_html_e( $project['project_url'] ) ?></li>
                <li><?php esc_html_e( $project['associated_with'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Honors & Awards', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_honors = isset( $cbxresume_data['honor_award'] ) ? $cbxresume_data['honor_award'] : array();

			foreach ( $cbxresume_honors as $honor ) {
				?>
                <li><?php esc_html_e( $honor['title'] ) ?></li>
                <li><?php esc_html_e( $honor['associated_with'] ) ?></li>
                <li><?php esc_html_e( $honor['issuer'] ) ?></li>
                <li><?php esc_html_e( $honor['month'] ) ?></li>
                <li><?php esc_html_e( $honor['year'] ) ?></li>
                <li><?php esc_html_e( $honor['description'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Test score', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_test_score = isset( $cbxresume_data['test_score'] ) ? $cbxresume_data['test_score'] : array();

			foreach ( $cbxresume_test_score as $test_score ) {
				?>
                <li><?php esc_html_e( $test_score['test_name'] ) ?></li>
                <li><?php esc_html_e( $test_score['associated_with'] ) ?></li>
                <li><?php esc_html_e( $test_score['score'] ) ?></li>
                <li><?php esc_html_e( $test_score['month'] ) ?></li>
                <li><?php esc_html_e( $test_score['year'] ) ?></li>
                <li><?php esc_html_e( $test_score['description'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Organization', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_organization = isset( $cbxresume_data['organization'] ) ? $cbxresume_data['organization'] : array();

			foreach ( $cbxresume_organization as $org ) {
				?>
                <li><?php esc_html_e( $org['name'] ) ?></li>
                <li><?php esc_html_e( $org['position_held'] ) ?></li>
                <li><?php esc_html_e( $org['assciated_with'] ) ?></li>
                <li><?php esc_html_e( $org['start_month'] ) ?></li>
                <li><?php esc_html_e( $org['start_year'] ) ?></li>
                <li><?php esc_html_e( $org['description'] ) ?></li>
			<?php } ?>
        </ul>

        <h3><?php echo esc_html__( 'Patents', 'cbxresume' ); ?></h3>
        <ul>
			<?php
			$cbxresume_patent = isset( $cbxresume_data['patent'] ) ? $cbxresume_data['patent'] : array();

			foreach ( $cbxresume_patent as $patent ) {
				?>
                <li><?php esc_html_e( $patent['title'] ) ?></li>
                <li><?php esc_html_e( $patent['office'] ) ?></li>
                <li><?php esc_html_e( $patent['application_number'] ) ?></li>
                <li><?php esc_html_e( $patent['issue_month'] ) ?></li>
                <li><?php esc_html_e( $patent['issue_day'] ) ?></li>
                <li><?php esc_html_e( $patent['issue_year'] ) ?></li>
                <li><?php esc_html_e( $patent['patent_url'] ) ?></li>
                <li><?php esc_html_e( $patent['description'] ) ?></li>
			<?php } ?>
        </ul>


		<?php
	} // end method displayResumeData


}//end class CBXResumeHelper