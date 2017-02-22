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
    delete: function(eventId, url) {
        if (confirm('Are you sure?')) {
            $.ajax({
                url: url,
                method: 'post',
                data: { eventId : eventId },
                success: function(res) {
                    if (res.ok == true) {
                        document.location.reload();
                    } else {
                        alert(res.error);
                    }
                },
                error: function() {
                    alert('server_error');
                }
            })
        }
    }
};