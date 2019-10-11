var valid = false;

$("#-form").submit(function (e) {
    var $form = $(this);

    if (! $form.valid()) {
        return false;
    }

    as.btn.loading($("#btn-submit"));

    return true;
});