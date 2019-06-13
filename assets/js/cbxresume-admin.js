(function ($) {
    'use strict';

    //console.log('resume edit-admin')

    $(document).ready(function () {

        // add education event and ajax request
        $(".cbxresume_section_education").on('click', '.cbxresume_education_add', function (e) {
            e.preventDefault();

            var $this = $(this);
            var $busy = parseInt($this.data('busy'));

            var $last_count = $('.cbxresume_last_count');

            var $last_count_val = parseInt($last_count.val());

            $last_count_val++;

            $last_count.val($last_count_val);

            if ($busy == 0) {
                $this.data('busy', 1);

                // This does the ajax request
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: cbxresume_admin.ajaxurl,
                    data: {
                        'action': 'cbxresume_resume_edit_add_education',
                        'last_count' : $last_count_val
                    },
                    success: function (data) {
                        $(".cbxresume_educations").append(data.field);

                        $this.data('busy', 0);
                    }
                });
            }



        }); // end of education add functionality


        // remove education field
        $('.cbxresume_section_education').on('click', '.cbxresume_education_remove', function (e) {
            e.preventDefault();

            $(this).closest('.cbxresume_education').remove();

        });



    });
})(jQuery);
