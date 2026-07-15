jQuery(function ($) {

    $(document).on('click', '.acf-map-image', function (e) {

        const image = $(this);
        const offset = image.offset();

        const x = ((e.pageX - offset.left) / image.width()) * 100;
        const y = ((e.pageY - offset.top) / image.height()) * 100;

        const wrapper = image.closest('.acf-map-picker');

        wrapper.find('.map-x').val(x);
        wrapper.find('.map-y').val(y);

        wrapper.find('.acf-map-marker').css({
            left: x + '%',
            top: y + '%'
        });

    });

});