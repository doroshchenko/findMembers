/**
 * Created by dima on 2/9/17.
 */

var Event = {
    join: function(url, event, user) {
        var data = {
            event: event,
            user: user
        };

        $.ajax({
            method: 'post',
            url: url,
            data: data,
            success: function(res) {
                if (res.ok) {
                    window.location.reload();
                }
            },
            error: function(res) {
                console.log(res);
            }
        });
    },
    delete: function(url, event) {
        $.ajax({
            url: url,
            method: 'post',
            success: function(res) {

            },
            error: function() {

            }
        })
    }
};