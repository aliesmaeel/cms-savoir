<properties>
    @foreach ($items as $item)
        <property>
            <property_ref_no><![CDATA[{{ $item->property_ref_no }}]]></property_ref_no>
            <?php
            $property_purpose=[
                'RR' => "Residential Rent",
                'RS' => "Residential Sale"
            ];
            ?>
            @foreach ($property_purpose as $key => $value )
                @if ($item->property_purpose == $key)
                    <property_purpose><![CDATA[{{ $value }}]]></property_purpose>
                @endif
            @endforeach
            <?php
            $property_type=[
                "AP"=>"Apartment Flat",
                "DX"=>"Duplex",
                "FA"=>"Factory",
                "FF"=>"Commercial Floor",
                "LC"=>"Labor Camp",
                "LP"=>"Commercial Land",
                "OF"=>"Office Space",
                "PH"=>"Penthouse",
                "SH"=>"Shop",
                "TH"=>"Townhouse",
                "VH"=>"Villa/House",
                "WB"=>"Commercial Building",
                "WH"=>"Warehouse",
            ];
            ?>
            @foreach ($property_type as $key => $value )
                @if ($item->property_type == $key)
                 <property_type><![CDATA[{{ $value  }}]]></property_type>
                @endif
            @endforeach
            <property_status><![CDATA[{{ $item->property_status }}]]></property_status>
            <city><![CDATA[{{ $item->city }}]]></city>
            <locality><![CDATA[{{ $item->locality->name }}]]></locality>
            <sub_locality><![CDATA[{{ $item->sub_locality->name }}]]></sub_locality>
            <tower_name><![CDATA[{{ $item->tower_name }}]]></tower_name>
            <property_title><![CDATA[{{ $item->property_title }}]]></property_title>
            <property_title_ar><![CDATA[{{ $item->property_title_ar }}]]></property_title_ar>
            <property_description><![CDATA[{{ $item->property_description }}]]></property_description>
            <property_description_ar><![CDATA[ {{ $item->property_description_ar }}]]> </property_description_ar>
            <property_size><![CDATA[{{ $item->property_size }}]]></property_size>
            <property_size_unit><![CDATA[{{ $item->property_size_unit }}]]></property_size_unit>
            <?php
            if($item->bedrooms == '0')
            {
                $bedrooms = '-1';
            }else{
                $bedrooms =$item->bedrooms;
            }
            ?>
            <bedrooms><![CDATA[{{ $bedrooms }}]]></bedrooms>
            <bathroom><![CDATA[{{ $item->bathroom }}]]></bathroom>
            <price><![CDATA[{{ $item->price }}]]></price>
            <listing_agent><![CDATA[{{ $item->user_id->name }}]]></listing_agent>
            <listing_agent_phone><![CDATA[{{ $item->user_id->phone }}]]></listing_agent_phone>
            <listing_agent_email><![CDATA[{{ $item->user_id->email }}]]></listing_agent_email>
            <?php
             $private_amenities=[
                'AC' => "CentralA/C&Heating",
                'BA' => "Balcony",
                'BK' => "Built in Kitchen Appliances",
                'BL' => "View of Landmark",
                'BW' => "Built in Wardrobes",
                'CP' => "Covered Parking",
                'CS' => "Concierge Service",
                'LB' => "Lobby in Building",
                'MR' => "Maid's Room",
                'MS' => "Maid Servicee",
                'PA' => "Pets Allowed",
                'PG' => "Private Garden",
                'PY' => "Private GYM",
                'PJ' => "Private Jacuzzi",
                'PP' => "Private Pool",
                'VC' => "Vastu compliant",
                'SE' => "Security",
                'SP' => "Shared Pool",
                'SS' => "Shared Spa",
                'ST' => "Study",
                'SY' => "Shared Gym",
                'SY' => "Shared Gym",
                'VW' => "View of Water",
                'WC' => "Walk in Closet",
                'CO' => "Children's Pool",
                'PR' => "Children's Play Area",
                'BR' => "Barbecue Area"
            ];
            ?>
            <features>
                @foreach ($private_amenities as $key => $value )
                    @foreach ($item->features as $feature)
                    @if ($feature == $key)
                        <feature> <![CDATA[{{ $value}}]]></feature>
                    @endif
                    @endforeach
                @endforeach

            </features>
            <images>
                @foreach ($item->images as $image)
                    <image><![CDATA[http://crm.remaxroyalproperties.com/storage/properties/images/{{ $image->url }}]]></image>
                @endforeach
            </images>
            <videos>
                @foreach ($item->videos as $video)
                    <video><![CDATA[http://crm.remaxroyalproperties.com/storage/properties/videos/{{ $video->url }}]]></video>
                @endforeach
            </videos>
            <floor_plans>
                @foreach ($item->floor_plans as $floor_plan)
                    <floor_plan><![CDATA[http://crm.remaxroyalproperties.com/storage/properties/FloorPrperty/{{ $floor_plan->url }}]]></floor_plan>
                @endforeach
            </floor_plans>
            <last_updated><![CDATA[{{ $item->updated_at }}]]></last_updated>
            <permit_number><![CDATA[{{ $item->permit_number }}]]></permit_number>
            <rent_Frequency><![CDATA[{{ $item->rent_Frequency }}]]></rent_Frequency>
            <off_plan><![CDATA[{{ $item->off_plan }}]]></off_plan>
        </property>
    @endforeach
</properties>
