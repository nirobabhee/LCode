<script>
        (function($) {
                "use strict";

                $(".available-time").on('click', function() {
                    $(this).parent('.time-serial-parent').find('.btn--success').removeClass(
                        'btn--success disabled').addClass('btn--primary');

                    $('[name=time_serial]').val($(this).data('value'));
                    $(this).removeClass('btn--primary');
                    $(this).addClass('btn--success disabled');
                })

                function slug(text) {
                    return text.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                }

                $("select[name=booking_date]").on('change', function() {

                        $('.available-time').removeClass('btn--success disabled').addClass('btn--primary');

                        let url = "{{ route('doctor.appointment.available.date') }}";
                        let data = {
                            date: $(this).val(),
                            doctor_id: '{{ $doctor->id }}'
                        }

                        $.get(url, data, function(response) {
                                if (!response.length) {
                                    $('.available-time').removeClass('btn--danger disabled');
                                } else {
                                    $('.available-time').removeClass('btn--danger disabled');
                                    $.each(response, function(key, value) {
                                            let dv = $('.available-time').data('value');
                                            var demo = slug(value);
                                            $(`.demo-${demo}`).addClass('btn--danger disabled');
                                        }
                                    });
                            }
                        });
                });


            // $("[name=mobile]").on('input', function () {
            //     let timeSerial = $('[name=time_serial]').val();
            //     let bookingDate =  $("select[name=booking_date]").val();
            //     if(!timeSerial || !bookingDate){
            //        $(":submit").prop("disabled", true);
            //     }else{
            //         $(":submit").prop("disabled", false);
            //     }
            // })

        })(jQuery);
    </script>