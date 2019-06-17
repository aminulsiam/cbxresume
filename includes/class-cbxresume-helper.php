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
	public static function getResumeData( $wpdb, $resume_id ) {

		$resume_table         = $wpdb->prefix . "cbxresumes";
		$data                 = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $resume_table WHERE id=%d", $resume_id ),
			'ARRAY_A' );
		$cbxresume_educations = maybe_unserialize( $data['resume'] );

		return $cbxresume_educations;

	} // end method getCbxresumeData


	/**
	 * Add Skill field is create form here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
	public static function resumeAdd_Skill_Field( $last_count_val ) {

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

	}// end method resumeAddEducationField

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
				   placeholder="' . esc_html__( 'Company name', 'cbxresume' ) . '" />
				   <input type="text" name="cbxresume[experience][' . $last_count_val . '][start_date]" /> 
		           <input type="text" name="cbxresume[experience][' . $last_count_val . '][description]" 
		           placeholder="' . esc_html__( 'Description', 'cbxresume' ) . '"/> 
		           <a href="#" class="button cbxresume_experience_remove">
		           <span class="dashicons dashicons-trash" style="margin-top: 3px;color: red;"></span>'
		          . esc_html__( 'Remove', 'cbxresume' ) . '</a>';

		$field .= '</div>';

		return $field;

	} // end method resumeAddExperienceField


	/**
     * Add Language field is create form here.
     *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
    public static function resumeAdd_Language_Field($last_count_val){

	    $field = '<div class="cbxresume_language">';

	    $field .= '<input type="text" name="cbxresume[language][' . $last_count_val . '][language_name]" 
				   placeholder="' . esc_html__( 'Language', 'cbxresume' ) . '" />';

	    $field .= '</select>';

	    $language_proficiency = array(
		    'elementary'           => esc_html__( 'Elementary proficiency', 'cbxresume' ),
		    'limited_working'      => esc_html__( 'Limited working proficiency', 'cbxresume' ),
		    'professional_working' => esc_html__( 'Professional working proficiency', 'cbxresume' ),
		    'full_professional'    => esc_html__( 'Full professional proficiency', 'cbxresume' ),
		    'native_or_bilingual'  => esc_html__( 'Native or bilingual proficiency', 'cbxresume' ),
	    );

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

    } // end method resumeAddLanguageField


	/**
     * Add License field is create from here.
	 *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
    public static function resumeAdd_License_Field($last_count_val){

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

    } // end method resumeAddVolunteer


	/**
     * Add Volunteer field is create from here.
     *
	 * @param int $last_count_val
	 *
	 * @return string
	 */
    public static function resumeAdd_Volunteer_Field($last_count_val){

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

    } // end method


}//end class CBXResumeHelper