$('document').ready(function () {

    $('.order_by input[type=radio]').on('change', function () {
        $(this).closest('form').submit();
    });

    $('.form_tags button').click(function (e) {

        var checkedBoxes = $('.form_tags input:checked').length;

        if (checkedBoxes < 1) {
            e.preventDefault();
            if ($('.form_tags .message').length < 1) {
                $('.form_tags').append('<small class="message">Please, choose an option</small>');
            }
        }
    });
});
