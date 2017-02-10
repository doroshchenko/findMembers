/**
 * Created by dima on 2/10/17.
 */

    var AuthObject = {

        selectors: {
            appendModalTo : '#wrapper',
            modalWindow   : '.auth-modal-window',
            submitLogin   : '#_submit',

            fields: {
                loginUser     : '#username',
                loginPassword : '#password',
                loginToken    : 'input[name="_csrf_token"]',
                loginRemember : '#remember_me'
            }
        },

        init: function() {

            /*$('body').on('click', '.load-login-modal', function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'post',
                    url: '{{ path(/ajax/login) }}',
                    data: {},
                    success: function(response) {
                        $(this.config.selectors.appendModal).append(response);
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            });*/
            this.initRemoveModal();

        },
        loadModal: function(url) {
            var that = this;
            $.ajax({
                method: 'post',
                url: url,
                data: {},
                success: function(response) {
                    $(that.selectors.appendModalTo).append(response);
                    $('.tabs').tabs();
                    that.initRemoveModal();
                    that.initSendLoginForm();
                },
                error: function (response) {
                    console.log(response);
                }
            });
            return false;
        },
        initRemoveModal: function() {
            var that = this;
            $('body').on('click', '.auth-modal', function(e) {
                var clicked = $(e.target);
                if (clicked.closest(that.selectors.modalWindow).length) {
                    return false;
                }
                $(this).remove();
            });
        },
        initSendLoginForm: function() {
            var that = this;
            $(that.selectors.submitLogin).click(function(e){
                e.preventDefault();
                var data = {
                    _username: $(that.selectors.fields.loginUser).val(),
                    _password: $(that.selectors.fields.loginPassword).val(),
                    _csrf_token: $(that.selectors.fields.loginToken).val(),
                    _remember_me: $(that.selectors.fields.loginRemember).val(),
                };
                $.ajax({
                    url: "/web/app_dev.php/login_check",
                    data: data,
                    method: 'post',
                    success: function() {
                        console.log('ok');
                        window.location.reload();
                    },
                    error: function() {
                        console.log('error');
                    }
                });
            });
        }
    };
