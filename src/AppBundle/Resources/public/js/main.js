(function ($) {
    $(document).ready(function(){
        $('.show-message-form').click(function(){
            $('.message-form').slideToggle();
        });

        $('.upload-avatar').click(function(){
            $('.upload-avatar-form').slideToggle();
        });
    });
})(jQuery);