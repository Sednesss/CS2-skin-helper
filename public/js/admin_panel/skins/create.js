$(document).ready(function () {
    // page alerts
    let pageAlerts = $('#page_alerts');

    pageAlerts.on('click', '.alert-error .close', closeAlertHandler);

    // close alert handler
    function closeAlertHandler() {
        $(this).closest('.alert-error').fadeOut('slow', function () {
            $(this).remove();
        });
    }
});