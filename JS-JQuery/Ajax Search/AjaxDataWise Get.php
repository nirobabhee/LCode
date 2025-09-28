//Room-Bed-check-Ajax//
            $('select[name=room_id]').on('change', function() {
                let data = {};
                    data.room_id =  $(this).val();
                $.ajax({
                        url: "{{ route('admin.bed.available.room') }}",
                        method: 'GET',
                        data: data,
                        // data: {id:1000,roomid:room_id},
                        success: function(response){
                            if(response == 'available'){
                                console.log(1000000);
                                $('[name=bed_number]').text('kjhsdkfjskd')
                                // notify('error', 'Assistant is booked for the schedule')
                            }
                        },
                    });

            })





            ////Controller////

            public function bedAvailableAjax(Request $request){
        $room =  Room::where('id',$request->room_id)->first();
        $bedCount = Bed::where('room_id',$room->id)->count();
        if($room->bed_capacity > $bedCount){
        // $message = 'Bed available in the room';
        return 'available';
        }
        // dd($room->bed_capacity - $beds);
        // dd($room->bed_capacity);




        // if($availableBedInRoom){
        //     return 200  ;
        // }
      }




     ///// route//
     Route::get('BedController@bedAvailableAjax')->name('bed.available.room');