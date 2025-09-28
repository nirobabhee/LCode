(function ($) {
    "use strict";
    $('.loanBtn').on('click', (e) => {
        var modal = $('#loanModal');
        let data = e.currentTarget.dataset;
        modal.find('.min-limit').text(`Minimum Amount ${data.minimum}`);
        modal.find('.max-limit').text(`Maximum Amount ${data.maximum}`);
        modal.find('.loan-name').text(`${data.planname}`);
        let form = modal.find('form')[0];
        form.action = `{{ route('user.loan.apply', '') }}/${data.id}`;
        modal.modal('show');
    });
})(jQuery);
</script >