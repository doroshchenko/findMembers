/**
 * Created by dima on 2/27/17.
 */
;(function($) {
    $(document).ready(function() {
        var messages = $('.message span');
        var youtubeTpl = '<embed width="420" height="350px" src="https://youtube.com/embed/$1" frameborder="0" allowfullscreen></embed>',
            youtubeRegexp = /(?:https:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;
            imageTpl = '<img src="$1" width="420" />',
            imageRegexp = /(https?:\/\/.*\.(png|jpg))/g;

        $.each(messages, function(index, block) {
            var text = $(block).text();
            text = text.replace(imageRegexp, imageTpl);
            text = text.replace(youtubeRegexp, youtubeTpl);
            $(block).html(text);

        });

        $('body').on('mouseover', '.message.unread', function() {
            var msgId = parseInt($(this).attr('id').match(/\d+/)[0]);
            var block = $(this);
            $.ajax({
                url: Routing.generate('read-message', {idMessage: msgId}),
                method: 'post',
                success: function(res) {
                    if (res.ok == true) {
                        block.css('background-color','white');
                        block.removeClass('unread');
                    }
                }
            });
        });

    });

})(jQuery);