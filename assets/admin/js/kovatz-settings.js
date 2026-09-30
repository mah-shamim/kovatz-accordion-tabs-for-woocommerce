jQuery(document).ready(function($) {
    jQuery('.kovatz-input-number').on('keydown',function() {
        updateDimensions(this);
    });
    jQuery('.kovatz-input-number').on('keyup',function() {
        updateDimensions(this);
    });
    jQuery('.kovatz-link-input').change(function() {
        if(jQuery(this).prop('checked')){
            let group = jQuery(this).data('group');
            jQuery('.'+group).val(0);
        }
    });
    jQuery('.colorpickpreview').click(function() {
        let tt = jQuery(this).next();
        window.setTimeout(function() {
            jQuery(tt).trigger('click');
        },90);
    });

    jQuery('.kovatz-file-selector').click(function(e) {
        e.preventDefault();
        let wkMedia;
        let id_input = $(this).data('id');
        // Extend the wp.media object
        wkMedia = wp.media.frames.file_frame = wp.media({
            title: 'Select media',
            button: {
                text: 'Select media'
            }, multiple: false });
        // When a file is selected, grab the URL and set it as the text field's value
        wkMedia.on('select', function() {
            var attachment = wkMedia.state().get('selection').first().toJSON();
            $('#'+id_input).val(attachment.url);
            $('#'+id_input).trigger('change');
        });
        // Open the upload dialog
        wkMedia.open();
    });
});

jQuery(document).on("wheel", "input[type=number]", function (e) {
    jQuery(this).blur();
});

function updateDimensions(el){
    let group = jQuery(el).data('group');
    if(jQuery('#'+group).prop('checked'))
        jQuery('.'+group).val(jQuery(el).val());
}