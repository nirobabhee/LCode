//select2-search
   public function searchPatient()
   {

    $request = request()->search;
       $patients = User::select('id', 'username', 'mobile')->where('name', 'LIKE', "%" . $request . "%")->orWhere('mobile', 'LIKE', "%" . $request . "%")->whereHas('appointment', function ($q) use($request){
            $q->where('mobile', 'LIKE', "%" . $request . "%");
       })->with('appointment')->paginate(request()->rows ?? 5);
       return response()->json([
           'success'   => true,
           'patients' => $patients,
           'more'      => $patients->hasMorePages()
       ]);
   }