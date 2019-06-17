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
