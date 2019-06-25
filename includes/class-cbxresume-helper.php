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
	 * @param int $id
	 *
	 * @return mixed
	 */
	public static function getResumeData( $id, $sections ) {
		global $wpdb;

		$resume_table = $wpdb->prefix . "cbxresumes";

		$resume = null;

		if ( ! empty( $sections ) && is_array( $sections ) ) {

			$resume = $wpdb->get_row( "SELECT * FROM $resume_table", ARRAY_A );

			return $resume;
		}


		if ( $id == 0 & is_user_logged_in() ) {

			$resume = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $resume_table WHERE add_by=%d ORDER BY id DESC
 lIMIT 1", get_current_user_id() ), 'ARRAY_A' );

			return $resume;
		}


		//Get the data for update resume by indivisual id
		$resume = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $resume_table WHERE id=%d", $id ),
			'ARRAY_A' );

		return $resume;

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
	public static function resumeAdd_Education_Field( $last_count_val ) {

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
	public static function resumeAdd_Experience_Field( $last_count_val ) {

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
	public static function resumeAdd_Language_Field( $last_count_val ) {

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
	public static function resumeAdd_License_Field( $last_count_val ) {

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
	public static function resumeAdd_Volunteer_Field( $last_count_val ) {

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
	public static function resumeAdd_Course_Field( $last_count_val ) {

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
	public static function resumeAdd_Project_Field( $last_count_val ) {

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
	public static function resumeAdd_Honors_Awards_Field( $last_count_val ) {


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
	public static function resumeAdd_Test_Score_Field( $last_count_val ) {

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
	public static function resumeAdd_Organization_Field( $last_count_val ) {

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
	public static function resumeAdd_patent_Field( $last_count_val ) {


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
	public static function getLanguageProficiency() {

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
	public static function getResumeMonth() {

		$resume_month = array(
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

		return $resume_month;

	}//end method getLanguageProficiency

	/**
	 * Get cbxresume data for shortcode
	 *
	 * @param $cbxresume_data
	 */
	public static function displayResumeHtml( $resume_data, $sections ) {

		$resume = isset( $resume_data['resume'] ) ? maybe_unserialize( $resume_data['resume'] ) : array();

		$sections = array_filter( $sections );

		?>
        <div class="cbxresume_details_wrap">

			<?php

			if ( ! empty( $sections ) && is_array( $sections ) && sizeof( $sections ) > 0 ) {
				foreach ( $sections as $section ) {
					include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/' . $section . '.php';
				}
			} else {
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/education.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/experience.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/language.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/license.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/volunteer.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/skill.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/publication.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/course.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/project.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/honors_awards.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/test_score.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/organization.php';
				include_once CBXRESUME_ROOT_PATH . 'templates/resume_sections/patents.php';
			}

			?>

        </div>

		<?php
	}// end method displayResumeHtml


	/**
	 * Get the all sections of resume.
	 *
	 * @return array
	 */
	public static function getAllResumeSections() {

		$sections = array(
			'education'     => esc_html__( 'Education', 'cbxresume' ),
			'experience'    => esc_html__( 'Experience', 'cbxresume' ),
			'language'      => esc_html__( 'Language', 'cbxresume' ),
			'license'       => esc_html__( 'License', 'cbxresume' ),
			'volunteer'     => esc_html__( 'Volunteer', 'cbxresume' ),
			'skill'         => esc_html__( 'Skill', 'cbxresume' ),
			'publication'   => esc_html__( 'Publication', 'cbxresume' ),
			'course'        => esc_html__( 'Course', 'cbxresume' ),
			'project'       => esc_html__( 'Project', 'cbxresume' ),
			'honors_awards' => esc_html__( 'Honors & Awards', 'cbxresume' ),
			'test_score'    => esc_html__( 'Test score', 'cbxresume' ),
			'organization'  => esc_html__( 'Organization', 'cbxresume' ),
			'patents'       => esc_html__( 'Patents', 'cbxresume' ),
		);

		return apply_filters( 'cbxresume_sections', $sections );
	}//end method getAllResumeSections


}//end class CBXResumeHelper