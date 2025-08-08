<list last_updated="{{ $items[0]->updated_at }}" listings_count="{{ $items->count() }}">
    @foreach ($items as $item)
        <property last_updated="{{ $item->updated_at }}">
            <reference_number>{{ $item->reference_number}}</reference_number>
            <permit_number>{{ $item->permit_number }}</permit_number>
            <offering_type>{{ $item->offering_type }}</offering_type>
            <property_type>{{ $item->property_type }}</property_type>
            @if ($item->offering_type == 'RR')
                <price>
                    <yearly> {{ $item->price }}</yearly>
                    <monthly></monthly>
                    <weekly></weekly>
                    <daily></daily>
                </price>
            @elseif ($item->offering_type == 'RS')
                <price>
                    {{ $item->price }}
                </price>
            @endif
            <service_charge>{{ $item->service_charge }}</service_charge>
            <cheques>{{ $item->cheques }}</cheques>
            <city>{{ $item->city }}</city>
            <community>{{ $item->community->name }}</community>
            <sub_community>{{ $item->sub_community->name }}</sub_community>
            <property_name>{{ $item->property_name }}</property_name>
            <title_en>{{ $item->title_en }}</title_en>
            <title_ar>{{ $item->title_ar }}</title_ar>
            <description_en> {{ $item->description_en }} </description_en>
            <description_ar>{{ $item->description_ar }}</description_ar>
            <private_amenities>
                {{ $item->private_amenities}}
                {{-- @foreach ($item->private_amenities as $private_amenity)
                    <private_amenity>{{ $private_amenity}}</private_amenity>
                @endforeach --}}
            </private_amenities>
            <plot_size>{{ $item->plot_size }}</plot_size>
            <size>{{ $item->size }}</size>
            <bedroom>{{ $item->bedroom }}</bedroom>
            <bathroom>{{ $item->bathroom }}</bathroom>
            @if ($item->user_id == null)
                <agent>
                    <id> </id>
                    <name></name>
                    <email> </email>
                    <phone> </phone>
                    <photo> </photo>
                    <license_no> </license_no>
                    <info> </info>
                </agent>
            @else
                <agent>
                    <id> {{ $item->user_id->id }}</id>
                    <name>{{ $item->user_id->name }}</name>
                    <email> {{ $item->user_id->email }}</email>
                    <phone> {{ $item->user_id->phone }}</phone>
                    <photo> {{ $item->user_id->photo }}</photo>
                    <license_no> {{ $item->user_id->license_no }}</license_no>
                    <info> {{ $item->user_id->info }}</info>
                </agent>
            @endif
            <developer>{{ $item->developer }}</developer>
            <build_year>{{ $item->build_year }}</build_year>
            <completion_status>{{ $item->completion_status }}</completion_status>
            <floor>{{ $item->floor }}</floor>
            <stories>{{ $item->stories }}</stories>
            <parking>{{ $item->parking }}</parking>
            <furnished>{{ $item->furnished }}</furnished>
            @if($item->view360 != "")
            <view360>http://crm.remaxroyalproperties.com/storage/properties/view360/{{ $item->view360 }}</view360>
            @else
            <view360></view360>
            @endif
            <photo>
                @foreach ($item->photo as $photo)
                    <url last_updated="{{ $photo->updated_at }}">http://crm.remaxroyalproperties.com/storage/properties/images/{{ $photo->url }}</url>
                @endforeach
            </photo>
            <floor_plan>
                @foreach ($item->floor_plan as $floor_plan_item)
                    <url last_updated="{{ $floor_plan_item->updated_at }}">http://crm.remaxroyalproperties.com/storage/properties/FloorPrperty/{{ $floor_plan_item->url }}</url>
                @endforeach
            </floor_plan>
            <geopoints>{{ $item->geopoints }}</geopoints>
            <title_deed>{{ $item->title_deed }}</title_deed>
            <availability_date>{{ $item->availability_date }}</availability_date>
        </property>
    @endforeach

</list>
