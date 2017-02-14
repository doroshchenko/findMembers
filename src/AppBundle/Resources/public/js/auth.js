/**
 * Created by dima on 2/10/17.
 */

    var AuthObject = {

        selectors: {
            appendModalTo : '#wrapper',
            modalWindow   : '.auth-modal-window',
            submitLogin   : '#_submit',
            submitRegister: '#register-form input[type="submit"]',

            fields: {
                loginUser     : '#username',
                loginPassword : '#password',
                loginToken    : 'input[name="_csrf_token"]',
                loginRemember : '#remember_me',

                registerEmail          : '#fos_user_registration_form_email',
                registerUser           : '#fos_user_registration_form_username',
                registerPassword       : '#fos_user_registration_form_plainPassword_first',
                registerPasswordRepeat : '#fos_user_registration_form_plainPassword_second',
                registerToken          : '#fos_user_registration_form__token'
            },
            blocks: {
                loginFormBlock: '#login-form form',
                registerFormBlock: '#register-form form',

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
                    that.initSendRegistrationForm();
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
                var url = $(that.selectors.blocks.loginFormBlock).attr('action');

                $.ajax({
                    url: url,
                    data: data,
                    method: 'post',
                    success: function(response) {
                        var node = document.createElement('div');
                        node.innerHTML = response;
                        if ($(node).children().first().text() == 'Invalid credentials.') {
                            $(that.selectors.blocks.loginFormBlock).html(response);
                            that.initSendLoginForm();
                            return;
                        }

                        window.location.reload();
                    },
                    error: function() {
                        $(that.selectors.blocks.loginFormBlock).html('server error');
                        console.log('error');
                    }
                });
            });
        },
        initSendRegistrationForm: function() {
            var that = this;
            $(that.selectors.submitRegister).click(function(e){
                e.preventDefault();
                var data = {
                    fos_user_registration_form: {
                        email        : $(that.selectors.fields.registerEmail).val(),
                        username     : $(that.selectors.fields.registerUser).val(),
                        plainPassword: {
                            first  : $(that.selectors.fields.registerPassword).val(),
                            second : $(that.selectors.fields.registerPasswordRepeat).val()
                        },
                        _token     : $(that.selectors.fields.registerToken).val(),
                    }
                };
                var url = $(that.selectors.blocks.registerFormBlock).attr('action');

                $.ajax({
                    url: url,
                    data: data,
                    method: 'post',
                    success: function(response) {
                        var resp = document.createElement('div');
                        resp.innerHTML = response;
                        if ($(resp).children('.register-errors').length) {
                            $(that.selectors.blocks.registerFormBlock).html(response);
                            that.initSendRegistrationForm();
                            return;
                        }
                        window.location.reload();
                    },
                    error: function() {
                        $(that.selectors.blocks.registerFormBlock).html('server error');
                        console.log('error');
                    }
                });
            });
        }
    };
