jQuery(document).ready(function($) {
    $('#submit-name').click(function(e) {
        e.preventDefault();
        var name = $('#name').val();
        var nonce = $('#my_nonce').val();
        $.ajax({
            type: 'POST',
            url: MyAjax.ajaxurl,
            data: {
                action: 'my_action',
                nonce: nonce,
                name: name
            },
            success: function(response) {
                $('#message').html(response);
                return false;
            }
        });
    });
});
