        $(document).ready(function(){
            console.log("Document ready");
            $('.toggle').click(function(){
                console.log("Toggle clicked");
                // Switches the Icon
                $(this).children('i').toggleClass('fa-pencil');
                // Switches the forms
                $('.form').animate({
                    height: "toggle",
                    'padding-top': 'toggle',
                    'padding-bottom': 'toggle',
                    opacity: "toggle"
                }, "slow");
            });
        });
