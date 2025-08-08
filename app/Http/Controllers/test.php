
<?php
$reference_number1 = NewProperty::find($id);
        if(isset($request->checkbox)){
            $request->validate(
                [
                    'reference_number' =>'required|unique:new_properties,reference_number,' . $reference_number1->id,
                    'permit_number' => 'required',
                    'offering_type' => 'required',
                    'property_type' => 'required',
                    'price' => 'required|numeric',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'property_name' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required',
                    'bedroom' =>  'required|numeric|min:0|max:10',
                    'bathroom' =>  'numeric|min:0|max:10',
                    'cheques' =>  'numeric|min:1|max:12',
                    'parking' =>  'numeric|min:0|max:999',
                    'user_id' => 'required',
                    'property_purpose' => 'required',
                    'property_status' => 'required',
                    'property_size_unit' => 'required',
                    'off_plan' => 'required',
                    'rent_Frequency' => 'required',
                    'tower_name' => 'required',
            ],
            [
                'required'  => 'The :attribute field is required.',
                'user_id.required'  => 'The Agent field is required.',
                'bedroom.max'  => 'The :attribute area should be less than 11.',
                'bathroom.max'  => 'The :attribute area should be less than 11.',
                'parking.max'  => 'The :attribute area should be less than 1000.',
                'cheques.max'  => 'The :attribute area should be less than 13.',
                'cheques.min'  => 'The :attribute area should be more than 0.',

            ]
        );
        }
        $request->validate(
            [
                'reference_number' =>'required|unique:new_properties,reference_number,' . $reference_number1->id,
                'permit_number' => 'required',
                'offering_type' => 'required',
                'property_type' => 'required',
                'price' => 'required|numeric',
                'city' => 'required',
                'community' => 'required',
                'sub_community' => 'required',
                'property_name' => 'required',
                'title_en' => 'required',
                'description_en' => 'required',
                'size' => 'required',
                'bedroom' =>  'required|numeric|min:0|max:10',
                'bathroom' =>  'numeric|min:0|max:10',
                'cheques' =>  'numeric|min:1|max:12',
                'parking' =>  'numeric|min:0|max:999',
                'user_id' => 'required',
            ],
            [
                'required'  => 'The :attribute field is required.',
                'user_id.required'  => 'The Agent field is required.',
                'bedroom.max'  => 'The :attribute area should be less than 11.',
                'bathroom.max'  => 'The :attribute area should be less than 11.',
                'parking.max'  => 'The :attribute area should be less than 1000.',
                'cheques.max'  => 'The :attribute area should be less than 13.',
                'cheques.min'  => 'The :attribute area should be more than 0.',
            ]
        );

        if( $request->private_amenities==""){
            $private_amenities ="";
            }
            else{
        $private_amenities= implode(',', $request->private_amenities);

            }

        $property = NewProperty::find($id);
        $bayut_property = BayutProperty::where('property_ref_no',$property->reference_number)->first();
        // dd($private_amenities);
        $property->update([
            'reference_number' => $request->reference_number,
            'permit_number' => $request->permit_number,
            'offering_type' => $request->offering_type,
            'property_type' => $request->property_type,
            'price' => $request->price,
            'service_charge' => $request->service_charge,
            'cheques' => $request->cheques,
            'city' => $request->city,
            'community' => $request->community,
            'sub_community' => $request->sub_community,
            'property_name' => $request->property_name,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'private_amenities' => $private_amenities,
            'plot_size' => $request->plot_size,
            'size' => $request->size,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'developer' => $request->developer,
            'build_year' => $request->build_year,
            'completion_status' => $request->completion_status,
            'floor' => $request->floor,
            'stories' => $request->stories,
            'parking' => $request->parking,
            'furnished' => $request->furnished,
            'furnished' => $request->furnished,
            'geopoints' => $request->geopoints,
            'title_deed' => $request->title_deed,
            'availability_date' => $request->availability_date,
            'user_id' => $request->user_id,
        ]);
        if(isset($request->checkbox)){
            if($bayut_property){
                $bayut_property->update([
                    'property_ref_no' => $request->reference_number,
                    'permit_number' => $request->permit_number,
                    'property_type' => $request->property_type,
                    'price' => $request->price,
                    'city' => $request->city,
                    'locality' => $request->community,
                    'sub_locality' => $request->sub_community,
                    'property_title' => $request->title_en,
                    'property_title_ar' => $request->title_ar,
                    'property_description' => $request->description_en,
                    'property_description_ar' => $request->description_ar,
                    'features' => $private_amenities,
                    'property_size' => $request->size,
                    'bedrooms' => $request->bedroom,
                    'bathroom' => $request->bathroom,
                    // 'floor_plan' => $request->floor_plan,
                    'user_id' => $request->user_id,
                    'property_purpose' => $request->property_purpose,
                    'property_status' => $request->property_status,
                    'property_size_unit' => $request->property_size_unit,
                    'rent_Frequency' => $request->rent_Frequency,
                    'off_plan' => $request->off_plan,
                    'tower_name' => $request->tower_name,
                    
                ]);
            }else{
                $bayut_property = BayutProperty::create([
                    'property_ref_no' => $request->reference_number,
                    'permit_number' => $request->permit_number,
                    'property_type' => $request->property_type,
                    'price' => $request->price,
                    'city' => $request->city,
                    'locality' => $request->community,
                    'sub_locality' => $request->sub_community,
                    'property_title' => $request->title_en,
                    'property_title_ar' => $request->title_ar,
                    'property_description' => $request->description_en,
                    'property_description_ar' => $request->description_ar,
                    'features' => $private_amenities,
                    'property_size' => $request->size,
                    'bedrooms' => $request->bedroom,
                    'bathroom' => $request->bathroom,
                    // 'floor_plan' => $request->floor_plan,
                    'user_id' => $request->user_id,
                    'property_purpose' => $request->property_purpose,
                    'property_status' => $request->property_status,
                    'property_size_unit' => $request->property_size_unit,
                    'rent_Frequency' => $request->rent_Frequency,
                    'off_plan' => $request->off_plan,
                    'tower_name' => $request->tower_name,
                    
                ]);
            }
            if($request->bedroom == '0'){
                $bayut_property->update([
                    'bedrooms' => '-1',
                ]);
            }
        }else{
            if(isset($bayut_property)){
                DB::table('bayut_properties')->where('id', $bayut_property->id)->delete();
                DB::table('bayut_property_videos')->where('bayutProperty_id', $bayut_property->id)->delete();
                DB::table('bayut_property_images')->where('bayutProperty_id', $bayut_property->id)->delete();
                DB::table('bayut_property_floor_plans')->where('bayutProperty_id', $bayut_property->id)->delete();
            }
        }
        if($request->TotalFiles > 0) {
        DB::table('property_images')->where('newProperty_id', $property->id)->delete();
        DB::table('bayut_property_images')->where('bayutProperty_id', $bayut_property->id)->delete();
            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $file = $request->file('files' . $x);
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public/properties/images/',$name);
                }
                DB::table('property_images')->insert(
                    array(
                        'url' => $name,
                        'newProperty_id'=> $property->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
                DB::table('bayut_property_images')->insert([
                    'url' => $name,
                    'bayutProperty_id'=> $bayut_property->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        if($request->FloorPlan > 0) {
        DB::table('property_floor_plans')->where('newflooProperty_id', $property->id)->delete();
        DB::table('bayut_property_floor_plans')->where('bayutProperty_id', $bayut_property->id)->delete();
            for ($x = 0; $x < $request->FloorPlan; $x++) {
                if ($request->hasFile('floorplans' . $x)) {
                    $file = $request->file('floorplans' . $x);
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public/properties/FloorPrperty/',$name);
                }
                DB::table('property_floor_plans')->insert(
                    array( 'url' => $name,
                    'newflooProperty_id'=> $property->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    )
                    );
                DB::table('bayut_property_floor_plans')->insert(
                    array( 'url' => $name,
                    'bayutProperty_id'=> $bayut_property->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    )
                    );
            }
        }
        if($request->TotalVideos > 0) {
            DB::table('bayut_property_videos')->where('bayutProperty_id', $bayut_property->id)->delete();
            for ($x = 0; $x < $request->TotalVideos; $x++) {
                if ($request->hasFile('videos' . $x)) {
                    $file = $request->file('videos' . $x);
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public/properties/videos/',$name);
                }
                DB::table('bayut_property_videos')->insert([
                    'url' => $name,
                    'bayutProperty_id'=> $bayut_property->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        if($request->VideoPlan > 0) {
        $fadel= DB::table('new_properties')->where('id', $property->id)->delete('view360');
            for ($x = 0; $x < $request->VideoPlan; $x++) {
                if ($request->hasFile('video' . $x)) {
                    $file = $request->file('video' . $x);
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public/properties/video',$name);
                }

                $property->update([
                    'view360' => $name]);

            }
        }
        if ($property != null)
        return response()->json(['success' => true, 'message' => 'Property created successfully']);
    else
        return response()->json(['success' => false, 'message' => 'Error in creating new property']);