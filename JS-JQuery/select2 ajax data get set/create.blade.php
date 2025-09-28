@extends('doctor.layouts.app')
@section('panel')
    <div class="mb-none-30">
        <form action="{{ route('doctor.prescription.store') }}" method="POST">
            <div class="card">
                <div class="card-body">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group" id="patient-wrapper">
                                <label class="font-weight-bold"><b class="patient_name text--primary"></b> @lang('Patient ID') </label>
                                {{-- <select class="select2-basic form-control" name="user_id" id="p" required>
                                    <option value="" disabled selected>@lang('Select Patient ID')</option>
                                    @foreach ($appointedUsers as $appointedUser)
                                        <option data-patient="{{ $appointedUser->user }}"
                                            value="{{ $appointedUser->user->id }}"
                                            {{ $appointedUser->id == $appointment_id ? 'selected' : '' }}
                                            data-name='{{ $appointedUser->user->name }}'
                                            data-appointment='{{ @$appointedUser->user()->appointment }}'
                                            data-appointment-no='{{ $appointedUser->appointment_no }}'>
                                            {{ __($appointedUser->user->username) }} </option>
                                    @endforeach
                                </select> --}}

                                <select name="user_id" class="form-control" id="patient" required>
                                    
                                </select>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Patient Name')</label>
                                <input type="text" name="user_name" value="{{ old('name') }}" class="form-control"
                                    required readonly />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Appointment No.')</label>
                                <input type="text" name="appointment_no" value="{{ old('appointment_no') }}"
                                    class="form-control" required readonly />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Date Of Birth')</label>
                                <input type="text" name="date_of_birth" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Gender')</label>
                                <input type="text" name="gender" value="{{ old('gender') }}" class="form-control"
                                    readonly />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Weight / Kg') </label>
                                <input type="number" name="weight" value="{{ old('weight') }}" class="form-control"
                                    readonly />
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Prime Complain')</label>
                                <textarea name="prime_complain" cols="30" rows="2" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-6 d-flex justify-content-center form-group">
                            <button type="button" class="btn btn--info caseStudyBtn "><span
                                    class="text--white patient_name"></span> @lang('Case Study ') </button>
                        </div>
                    </div>

                    {{-- Add Medicines --}}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="card border--primary">

                                <div class="card-header bg--primary d-flex justify-content-between">
                                    <h5 class="text-white">@lang('Medicine')</h5>
                                    <button type="button" class="btn btn-sm btn-outline-light float-end addMedicine"> <i class="la la-fw la-plus"></i>@lang('Add Medicine ')</button>
                                </div>

                                <div class="card-body">
                                    <div class="addedMedicine">
                                            <div class="row medicine-data">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="medicine_name[]"
                                                        placeholder="Medicine Name">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="medicine_type[]"
                                                            placeholder="Medicine Type">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="medicine_instruction[]"
                                                            placeholder="Enter Medicine Instruction">
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <input class="form-control" type="text" name="days[]"
                                                            placeholder="Days">
                                                    </div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <div class="form-group">
                                                        <button type="button" class="btn btn-lg btn-outline--danger removeBtn">
                                                            <i class="la la-trash"></i> 
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Add Diagnosis --}}
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="card border--primary">
                                <div class="card-header bg--primary d-flex justify-content-between">
                                    <h5 class="text-white">@lang('Diagnosis')</h5>
                                    <button type="button" class="btn btn-sm btn-outline-light float-end addDiagnosis"> <i class="la la-fw la-plus"></i>@lang('Add Diagnosis ')</button>
                                </div>

                                <div class="card-body">
                                    <div class="diagnosisFieldAdded">
                                        <div class="row diagnosis-data">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <select class="form-control select2-basic" name="diagnosis[]"  placeholder="Daignosis|Tests">
                                                            <option value="" disabled selected>@lang('Select One')</option>
                                                            @foreach ($tests as $test)
                                                                <option value="{{ $test->name . '|' . $test->price }}"> {{ __($test->name) }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                                  
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="diagnosis_instruction[]" placeholder="Enter Daignosis Instruction">
                                                </div>
                                            </div>

                                            <div class="col-sm-1">
                                                <div class="form-group">
                                                <button type="button" class="btn btn-lg btn-outline--danger diagnosisRemoveBtn"> <i class="la la-trash"></i>  </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                             <div class="form-group">
                            <label class="font-weight-bold">@lang('Patient Note')</label>
                            <textarea name="patient_notes" rows="1" class="form-control" required></textarea>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block btn-lg">@lang('Submit')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



    {{-- Case Study Modal --}}
    <div class="modal fade" id="caseStudyModal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Case Study Details ') </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Food Allergies')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="food_allergies"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Heart Disease')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="heart_disease"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Tendency Bleed')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="tendency_bleed"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('High Blood Pressure')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="high_blood_pressure"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Diabetic')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="diabetic"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Surgery')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="surgery"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Accident')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="accident"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Current Medication')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="current_medication"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Others')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="others"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Female Pregnancy')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="female_pregnancy"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Breast Feeding')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="breast_feeding"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Health Insurance')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="health_insurance"></p>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <h6>@lang('Family Medical History')</h6>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <p class="family_medical_history"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"> </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    <a href="{{ route('doctor.prescription.index') }}" class="btn btn-lg btn--primary text--small  mr-3 mb-2">
        <i class="fa fa-fw fa-list"></i>@lang('All Prescriptions')
    </a>
@endpush


@push('script')
<script>
    (function($) {
        'use strict';
       
      


            


            $('#patient').select2({
                ajax: {
                    url: '{{ route('doctor.prescription.patient') }}',
                    type: "get",
                    dataType: 'json',
                    delay: 1000,
                    data: function(params) {
                        return {
                            search: params.term,
                            page: params.page, // Page number, page breaks
                        };
                    },
                    processResults: function(response, params) {
                        params.page = params.page || 1;
                        let data = response.patients.data;
                        return {
                            results: $.map(data, function(item) {
                                
                                return {
                                    text: item.username + ' +' + item.mobile,
                                    id: JSON.stringify(item),
                                }
                            }),
                            pagination: {
                                more: response.more
                            }
                        };
                    },
                    cache: false
                },
                dropdownParent: $("#patient-wrapper")
            });




            $('#patient').on('change',function(e){
                let item=$(this).val();
                item=JSON.parse(item)
                if(item){
                    $('#patient-wrapper').find('.select2-selection__rendered').attr('aria-readonly',false)
                    setTimeout(() => {
                        $('#patient-wrapper').find('#select2-patient-container').text(item.username);
                    });
                }
            });





           



















        var modal = $('#caseStudyModal');
        $('.caseStudyBtn').addClass('d-none')
        $('select[name=user_id]').on('change', function() {

            let item = $(this).val();
                item = JSON.parse(item)

                if(item){
                    console.log(item.appointment[0].appointment_no);
                }


            try{
                var text = ' - ';
                var patient = $(this).find('option:selected').data('name');

                if( patient != null){
                    $(".patient_name").text(patient + text);
                }



                //-----------Defendency-
                var patient = $("#patient").find('option:selected').data('patient');

                // console.log(patient);

                $('input[name=user_name]').val(patient.firstname + ' ' + patient.lastname);
                $('input[name=date_of_birth]').val(patient.date_of_birth);
                $('input[name=weight]').val(patient.weight);
                $('input[name=reference]').val(patient.reference);
                if (patient.gender == 1) {
                    $('input[name=gender]').val('Male');
                } else if (patient.gender == 2)
                    $('input[name=gender]').val('Female');
                else {
                    $('input[name=gender]').val('Others');
                }

                var appointment = $(this).find('option:selected').data('appointment');
                var AppNo = $(this).find('option:selected').data('appointment-no');
                $('input[name=appointment_no]').val(AppNo);


                //--------Modal view

                if (patient.case_study.case_studies) {
                    modal.find('.food_allergies').text(`${patient.case_study.case_studies.food_allergies}`);
                    modal.find('.tendency_bleed').text(`${patient.case_study.case_studies.tendency_bleed}`);
                    modal.find('.high_blood_pressure').text(`${patient.case_study.case_studies.high_blood_pressure}`);
                    modal.find('.heart_disease').text(`${patient.case_study.case_studies.heart_disease}`);
                    modal.find('.diabetic').text(`${patient.case_study.case_studies.diabetic}`);
                    modal.find('.surgery').text(`${patient.case_study.case_studies.surgery}`);
                    modal.find('.accident').text(`${patient.case_study.case_studies.accident}`);
                    modal.find('.current_medication').text(`${patient.case_study.case_studies.current_medication}`);
                    modal.find('.others').text(`${patient.case_study.case_studies.others}`);
                    modal.find('.female_pregnancy').text(`${patient.case_study.case_studies.female_pregnancy}`);
                    modal.find('.breast_feeding').text(`${patient.case_study.case_studies.breast_feeding}`);
                    modal.find('.family_medical_history').text(
                        `${patient.case_study.case_studies.family_medical_history}`);
                    modal.find('.health_insurance').text(`${patient.case_study.case_studies.health_insurance}`);
                    $('.caseStudyBtn').removeClass('d-none')
                } else {
                    $('.caseStudyBtn').addClass('d-none')
                }
            }catch(message){

            }

        }).change(); //End



        $('.caseStudyBtn').on('click', function() {
            modal.modal('show');
        })

        //--------Medicines-
        $('.addMedicine ').on('click', function() {

            var html = `<div class="row medicine-data">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="medicine_name[]" placeholder="Medicine Name">
                                </div>
                            </div>
                                                
                            <div class="col-sm-3">
                                <div class="form-group">
                                        <input class="form-control" type="text" name="medicine_type[]" placeholder="Medicine Type">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="medicine_instruction[]" placeholder="Enter Medicine Instruction">
                                </div>
                             </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="days[]" placeholder="Days">
                                </div>
                            </div>
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-lg btn-outline--danger removeBtn"> <i class="la la-trash"></i>  </button>
                                </div>
                            </div>
                     </div>`;

            $('.addedMedicine').append(html);
        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.medicine-data').remove();
        });

    

        //-----------Diagnosis-
        $('.addDiagnosis ').on('click', function() {
            var html = ` <div class="row diagnosis-data">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select class="form-control" name="diagnosis[]"  placeholder="Daignosis|Tests">
                                        <option value="" disabled selected>@lang('Select One')</option>
                                        @foreach ($tests as $test)
                                            <option value="{{ $test->name . '|' . $test->price }}"> {{ __($test->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                                  
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="diagnosis_instruction[]" placeholder="Enter Daignosis Instruction">
                                </div>
                            </div>

                            <div class="col-sm-1">
                                <div class="form-group">
                                    <button type="button" class="btn btn-lg btn-outline--danger diagnosisRemoveBtn"> <i class="la la-trash"></i>  </button>
                                </div>
                            </div>
                        </div>`;

            $('.diagnosisFieldAdded').append(html);
        });

        $(document).on('click', '.diagnosisRemoveBtn', function() {
            $(this).closest('.diagnosis-data').remove();
        });


    })(jQuery);
</script>
@endpush
