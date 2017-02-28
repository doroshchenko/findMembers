(function ($) {
    $(document).ready(function(){
        $('.show-message-form').click(function(){
            $('.message-form').slideToggle();
        });

        $('.upload-avatar').click(function(){
            $('.upload-avatar-form').slideToggle();
        });

        $(document).ready(function() {
            $('select').material_select();
        });
    });
})(jQuery);