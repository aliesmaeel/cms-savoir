<dubizzlepropertyfeed>
    @foreach ($items as $item)
        <property>
            <?php
            $status= [
            "Live"=>"vacant",
            "Archive"=>"deleted",
            ];
            ?>
            @foreach ($status as $key => $value )
                @if ($item->property_status == $key)
                    <status>{{ $value }}</status>
                @endif
            @endforeach
            <?php
            $property_purpose=[
                'RR' => "RP",
                'RS' => "SP"
            ];
            ?>
            @foreach ($property_purpose as $key => $value )
                @if ($item->property_purpose == $key)
                    <type>{{ $value }}</type>
                @endif
            @endforeach
            <?php
            $type=[
             'AP' => "AP",
             'DX' => "AP",
             'FA' => "CO",
             'FF' => "CO",
             'LC' => "CO",
             'LP' => "LA ",
             'OF' => "CO",
             'PH' => "PH",
             'SH' => "CO",
             'TH' => "TH",
             'VH' => "VH",
             'WB' => "CO",
             'WH' => "CO",
            ];
            ?>
            @foreach ($type as $key => $value )
                @if ($item->property_type == $key)
                    <subtype>{{ $value }}</subtype>
                @endif
            @endforeach
            <?php
            $commercial_type=[
             'FA' => "FA",
             'FF' => "FF",
             'LC' => "LC",
             'OF' => "OF",
             'SH' => "SH",
             'WB' => "WB ",
             'WH' => "WH",
             'AP' => "",
             'DX' => "",
             'LP' => "",
             'PH' => "",
             'TH' => "",
             'AP' => "",
            ];
            ?>
            @foreach ($commercial_type as $key => $value )
                @if ($item->property_type == $key)
                    <commercialtype>{{ $value }}</commercialtype>
                @endif
            @endforeach
            <refno>{{ $item->property_ref_no }}</refno>
            <title>{{ $item->property_title }}</title>
            <description><![CDATA[{{ $item->property_description }}]]></description>
            <size>{{ $item->property_size }}</size>
            <sizeunits>{{ $item->property_size_unit }}</sizeunits>
            <price>{{ $item->price }}</price>
            <pricecurrency>AED</pricecurrency>
            <?php
            $rentpriceterm =[
            "Yearly"=>"YR"
            ];
            ?>
            @foreach ($rentpriceterm as $key => $value )
                @if ($item->rent_Frequency == $key)
                    <rentpriceterm>{{ $value }}</rentpriceterm>
                @endif
            @endforeach
            <?php
            $furnished= [
            "Yes"=>"1",
            "No"=>"0",
            "Partly"=>"0",
            ""=>"0",
            ];
            ?>
            @foreach ($furnished as $key => $value )
                @if ($item->furnished == $key)
                    <furnished>{{ $value }}</furnished>
                @endif
            @endforeach
            <bedrooms>{{ $item->bedrooms }}</bedrooms>
            <bathrooms>{{ $item->bathroom }}</bathrooms>
            <developer>{{ $item->developer }}</developer>
            <lastupdated>{{ $item->updated_at }}</lastupdated>
            <contactemail>{{ $item->user_id->email }}</contactemail>
            <contactnumber>{{ $item->user_id->phone }}</contactnumber>
            <building>{{ $item->tower_name }}</building>
            <?php
            $cities= [
            "Dubai"=>"2",
            "Abu Dhabi"=>"3",
            "Umm Al Quwai"=>"15",
            "Ajman"=>"14",
            "Ras Al-Khaimah"=>"11",
            "Sharjah"=>"12",
            "Fujairah"=>"13",
            "Al Ain"=>"39",
            ];
            ?>
            @foreach ($cities as $key => $value )
                @if ($item->city == $key)
                    <city>{{ $value }}</city>
                @endif
            @endforeach
            <locationtext>{{ $item->locality->name }}</locationtext>
            <permit_number>{{ $item->permit_number }}</permit_number>
            <privateamenities>{{ $item->features}}</privateamenities>
            @if($item->images->Pluck('url')->toArray() != [])
            <?php
                $url = $item->images->Pluck('url')->toArray();
                $images = implode('|http://crm.remaxroyalproperties.com/storage/properties/images/', $url);
            ?>
                <photos>http://crm.remaxroyalproperties.com/storage/properties/images/{{ $images }}</photos>
            @else
                <photos></photos>
            @endif
            @if ($item->view360 != '')
                <view360>http://crm.remaxroyalproperties.com/storage/properties/view360/{{ $item->view360}}</view360>
            @else
                <view360></view360>
            @endif
            @if($item->videos->Pluck('url')->toArray() != [])
            <?php
                $url = $item->videos->Pluck('url')->toArray();
                $videos = implode('|http://crm.remaxroyalproperties.com/storage/properties/videos/', $url);
            ?>
            <video_url>http://crm.remaxroyalproperties.com/storage/properties/videos/{{ $videos }}</video_url>
            @else
            <video_url></video_url>
        @endif
        <geopoint>{{ $item->geopoints}}</geopoint>
        </property>
    @endforeach
</dubizzlepropertyfeed>
