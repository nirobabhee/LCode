
            //ajax
            // $('select[name=available_day]').val(day).select2();


            // $('select[name=department]').on('change', function() {
            //     var id = $(this).val();
            //     if (id) {
            //         var url = "{{ url('admin/appointment/doctor') }}/" + id;

            //         $.ajax({
            //             url: url,
            //             type: "GET",
            //             dataType: "json",
            //             success: function(data) {
            //                 if (data) {
            //                     $('select[name=doctor]').empty();
            //                     $('select[name=doctor]').focus;
            //                     $('select[name=doctor]').append(
            //                         '<option value=""> Select Doctor </option>');
            //                     $.each(data, function(key, value) {
            //                         $('select[name="doctor"]').append(
            //                             '<option  value="' + value.id + '" data-id="' + value.id +'"  >' + value.name + '</option>');
            //                     });
            //                 } else {
            //                     $('select[name=doctor]').empty();
            //                 }
            //             }


            //         });
            //     } else {
            //         $('select[name=doctor]').empty();
            //     }
            //     // console.log($('selected[name=doctor] options').data(id));

            //     var s = $('select[name=doctor]').find(':selected').data('id');
            //     // console.log($('select[name=doctor]').find(':selected').data('id'));
            //     // console.log($('selected[name=doctor]').find(":selected").data(id));


            // });

            controller//
            // public function getDoctorAjax($id)
    // {
    //     $doctors = Doctor::where('department_id', $id)->get();
    //     return response()->json($doctors);
    // }