
//->html
<div class="card-body">
<div class="testFieldAdded">

</div>
</div>



//->Script
<script>
        (function($) {
            'use strict';
            $('select[name=prescription_id]').on('change', function() {
                var resources = $(this).find('option:selected').data('resources');
                $('[name=user_name]').val(resources.user.firstname + ' ' + resources.user.lastname);
                $('[name=doctor_name]').val(resources.doctor.name);
                $('.diagnosis').removeClass('d-none');

                //Ajax
                let data = {};
                data.id = $(this).val();


                $.ajax({
                    url: "{{ route('laboratorist.prescription.diagnosis') }}",
                    method: 'GET',
                    data: data,
                    success: function(response) {
                        var html = '';
                        $.each(response.diagnosis, function(index, value) {
                            html += `<div class="row test-data">
                                            <div class="form-group col-md-3">
                                                <input class="form-control" value="${value.name}" rows="1" name="test[]"  required/>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-control" rows="1" placeholder="Enter Result" name="result[]"  required/>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input class="form-control" rows="1" placeholder="Enter Remark" name="remark[]"  required/>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <button class="btn btn--danger btn-lg testFieldRemoveBtn w-100" type="button"> <i class="fa fa-times"></i> </button>
                                            </div>
                                     </div>`;
                        });
                        $(".testFieldAdded").html(html);

                    },
                });

            }); //End



            $(document).on('click', '.testFieldRemoveBtn', function() {
                $(this).closest('.test-data').remove();
            });

        })(jQuery);
    </script>
	
	
	
	
	
	
	
	
	//->Route//Laravel//
	 Route::get('prescription.diagnosis','ReportController@getPrescriptionWiseDiagnosis')->name('prescription.diagnosis');
	 
	 
	 
	 
	 
	 
	 
	 //ReportController//->data//
	 public function getPrescriptionWiseDiagnosis(Request $request){
        $prescriptionDagnosis = Prescription::where('id', $request->id)->firstOrFail();
        return response()->json($prescriptionDagnosis);
    }
	 
	