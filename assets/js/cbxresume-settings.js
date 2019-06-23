(function ($) {
    'use strict';

    $(document).ready(function () {
        //Initiate Color Picker
        $('.wp-color-picker-field').wpColorPicker();


        //add chooser
        //$(".chosen-select").chosen();
        $(".selecttwo-select").select2({
            placeholder: cbxresume_setting.please_select,
            allowClear: true
        });


        // Switches option sections
        $('.cbxresume_group').hide();
        var activetab = '';
        if (typeof(localStorage) != 'undefined') {
            //get
            activetab = localStorage.getItem("cbxresumeactivetab");
        }
        if (activetab != '' && $(activetab).length) {
            $(activetab).fadeIn();
        } else {
            $('.cbxresume_group:first').fadeIn();
        }
        $('.cbxresume_group .collapsed').each(function () {
            $(this).find('input:checked').parent().parent().parent().nextAll().each(
                function () {
                    if ($(this).hasClass('last')) {
                        $(this).removeClass('hidden');
                        return false;
                    }
                    $(this).filter('.hidden').removeClass('hidden');
                });
        });

        if (activetab != '' && $(activetab + '-tab').length) {
            $(activetab + '-tab').addClass('nav-tab-active');
        }
        else {
            $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
        }

        $('.nav-tab-wrapper a').on('click', function (evt) {
            evt.preventDefault();

            $('.nav-tab-wrapper a').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active').blur();
            var clicked_group = $(this).attr('href');
            if (typeof(localStorage) != 'undefined') {
                //set
                localStorage.setItem("cbxresumeactivetab", $(this).attr('href'));
            }
            $('.cbxresume_group').hide();
            $(clicked_group).fadeIn();

        });


        $('.wpsa-browse').on('click', function (event) {
            event.preventDefault();

            var self = $(this);

            // Create the media frame.
            var file_frame = wp.media.frames.file_frame = wp.media({
                title: self.data('uploader_title'),
                button: {
                    text: self.data('uploader_button_text')
                },
                multiple: false
            });

            file_frame.on('select', function () {
                var attachment = file_frame.state().get('selection').first().toJSON();

                self.prev('.wpsa-url').val(attachment.url);
            });

            // Finally, open the modal
            file_frame.open();
        });

        //make the subheading single row
        $('.setting_subheading').each(function (index, element) {
            var $element = $(element);
            var $element_parent = $element.parent('td');
            $element_parent.attr('colspan', 2);
            $element_parent.prev('th').remove();
        });

        //make the subheading single row
        $('.setting_heading').each(function (index, element) {
            var $element = $(element);
            var $element_parent = $element.parent('td');
            $element_parent.attr('colspan', 2);
            $element_parent.prev('th').remove();
        });

        $('.cbxresume_group').each(function (index, element) {
            var $element = $(element);
            var $form_table = $element.find('.form-table');
            $form_table.prev('h2').remove();
        });


    });

})(jQuery);