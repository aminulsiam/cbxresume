(function ($) {
    'use strict';

    //console.log('resume edit-admin')

    $(document).ready(function () {

        // add education event and ajax request
        $(".cbxresume_section_education").on('click', '.cbxresume_education_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "education";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of education add functionality


        // remove education field
        $('.cbxresume_section_education').on('click', '.cbxresume_education_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_education').remove();
        });
        //-------------  end of experience section ---------------- //


        // Add Experience by Ajax Request
        $(".cbxresume_section_experience").on('click', '.cbxresume_experience_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "experience";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of experience add functionality


        // remove experience field
        $('.cbxresume_section_experience').on('click', '.cbxresume_experience_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_experience').remove();
        });
        // end of experience section ------------------------------ //


        // Add language by Ajax Request
        $(".cbxresume_section_language").on('click', '.cbxresume_language_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "language";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of experience add functionality


        // remove language field
        $('.cbxresume_section_language').on('click', '.cbxresume_language_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_language').remove();
        });
        // end of language section -----------------------------//


        // Add license by Ajax Request
        $(".cbxresume_section_license").on('click', '.cbxresume_license_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "license";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of experience add functionality


        // remove language field
        $('.cbxresume_section_license').on('click', '.cbxresume_license_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_license').remove();
        });
        // end of license section -----------------------------//


        // Add volunteer by Ajax Request
        $(".cbxresume_section_volunteer").on('click', '.cbxresume_volunteer_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "volunteer";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of experience add functionality


        // remove language field
        $('.cbxresume_section_volunteer').on('click', '.cbxresume_volunteer_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_volunteer').remove();
        });
        // end of license section -----------------------------//


        // Add skill by Ajax Request
        $(".cbxresume_section_skill").on('click', '.cbxresume_skill_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "skill";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of experience add functionality


        // remove language field
        $('.cbxresume_section_skill').on('click', '.cbxresume_skill_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_skill').remove();
        });
        // end of skill section -----------------------------//


        // Add skill by Ajax Request
        $(".cbxresume_section_publication").on('click', '.cbxresume_publication_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "publication";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove publication field
        $('.cbxresume_section_publication').on('click', '.cbxresume_publication_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_publication').remove();
        });
        // end of publication section -----------------------------//


        // Add skill by Ajax Request
        $(".cbxresume_section_course").on('click', '.cbxresume_course_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "course";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove publication field
        $('.cbxresume_section_course').on('click', '.cbxresume_course_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_course').remove();
        });
        // end of publication section -----------------------------//


        // Add project by Ajax Request
        $(".cbxresume_section_project").on('click', '.cbxresume_project_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "project";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove publication field
        $('.cbxresume_section_project').on('click', '.cbxresume_project_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_project').remove();
        });

        // end of project section -----------------------------//


        // Add honors & awards by Ajax Request
        $(".cbxresume_section_honor_award").on('click', '.cbxresume_honor_award_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "honor_award";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove publication field
        $('.cbxresume_section_honor_award').on('click', '.cbxresume_honor_award_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_honor_award').remove();
        });

        // end of honor & awards section -----------------------------//


        // Add test score by Ajax Request
        $(".cbxresume_section_test_score").on('click', '.cbxresume_test_score_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "test_score";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove organization field
        $('.cbxresume_section_test_score').on('click', '.cbxresume_test_score_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_test_score').remove();
        });

        // end of test_score section -----------------------------//


        // Add test score by Ajax Request
        $(".cbxresume_section_organization").on('click', '.cbxresume_organization_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "organization";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove publication field
        $('.cbxresume_section_organization').on('click', '.cbxresume_organization_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_organization').remove();
        });

        // end of test_score section -----------------------------//

        // Add test score by Ajax Request
        $(".cbxresume_section_patent").on('click', '.cbxresume_patent_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $class = "patent";

            var $last_count_val = cbxresumeSectionLastCount($class);

            getFieldByAjaxReq($this, $class, $last_count_val, $busy);

        }); // end of publication add functionality


        // remove publication field
        $('.cbxresume_section_patent').on('click', '.cbxresume_patent_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_patent').remove();
        });

        // end of test_score section -----------------------------//


        /**
         * Sending Ajax Request to making all kind of resume fields.
         *
         * @param $this
         * @param $class
         * @param $last_count_val
         * @param $busy
         *
         * @return resume fields
         */
        function getFieldByAjaxReq($this, $class, $last_count_val, $busy) {

            if ($busy == 0) {
                $this.data('busy', 1);

                // This does the ajax request
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: cbxresume_admin.ajaxurl,
                    data: {
                        'action': 'cbxresume_resume_edit_add_' + $class + '',
                        'last_count': $last_count_val
                    },
                    success: function (data) {
                        $('.cbxresume_' + $class + 's').append(data.field);

                        $this.data('busy', 0);
                    }
                });
            }

        } // end method getFieldByAjaxReq


        /**
         * Find the last count of every resume section.
         *
         * @param $class_last_count
         * @returns {number}
         */
        function cbxresumeSectionLastCount($class_last_count) {

            var $last_count = $('.cbxresume_' + $class_last_count + '_last_count');

            var $last_count_val = parseInt($last_count.val());

            $last_count_val++;

            $last_count.val($last_count_val);

            return $last_count_val;

        } // end method cbxresumeSectionLastCount


    });
})(jQuery);
