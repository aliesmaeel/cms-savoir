<nav class="sidebar">

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <div id="role" hidden>{{ Auth::user()->role_id }}</div>
    <ul>
        <li>
            <div class="text">
                @if (Auth::user()->isagent())
                    <span><i class="fa fa-bell mt-3" id="bell" style="color:#fff;"></i></span>
                    <div class="dropdown-content-length"></div>
                    <div class="dropdown-content"></div>
                @endif
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand align-items-center " href="{{ url('/createlead') }}">
                    <div class="sidebar-brand-icon">
                        <img src="{{ asset('img/savoir.png') }}" style="width: 4.4rem;"
                             class="user-img img-responsive" alt="">

                    </div>
                </a>
                <div style="text-align: center" class="mb-2">
                    <span class="user-name" style="">{{ Auth::user()->name }}</span>
                </div>

            </div>
        </li>

        {{-- Leads Section --}}
        @if (Auth::user()->isagent() ||
            Auth::user()->isadmin() ||
            Auth::user()->isconsultant() ||
            Auth::user()->iscustomer() ||
            Auth::user()->issuperAdmin())
            <li id="sbitem1">
                <a href="#" class="link-content leads-btn"><span class="left-title">Leads</span><span
                        class="fas fa-caret-down first"></span></a>
                <ul class="leads-show">
                    <li id="sbitem1_16">
                        <a href="{{ route('createlead') }}"><i class="fas fa-fw fa-table"></i>
                            Create a Lead
                        </a>
                    </li>
                    {{-- @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                        <li id="sbitem1_17"><a href="{{ route('import_index') }}"><i class="fas fa-ad"></i>
                                Import Data</a></li>
                    @endif --}}
                    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                        <li id="sbitem1_1"><a href="{{ route('leads_pool_index') }}"><i class="fas fa-fw fa-table"></i>
                                Your Leads</a></li>
                        <li id="sbitem1_5"><a href="{{ route('follow_up_index') }}"><i class="fas fa-fw fa-table"></i>
                                Follow Up</a></li>
                        <li id="sbitem1_4"><a href="{{ route('qualified_leads_index') }}"><i
                                    class="fas fa-fw fa-table"></i>
                                Qualified</a></li>
                        <li id="sbitem1_19"><a href="{{ route('proceeded_leads_index') }}"><i
                                    class="fas fa-fw fa-table"></i> Proceeded</a></li>
                        <li id="sbitem1_2"><a href="{{ route('won_leads_index') }}"><i class="fas fa-fw fa-table"></i>
                                Won</a>
                        </li>
                        <li id="sbitem1_3"><a href="{{ route('dead_leads_index') }}"><i class="fas fa-fw fa-table"></i>
                                Dead</a>
                        </li>
                    @endif

                    {{-- @if (Auth::user()->isagent() || Auth::user()->isadmin())
                        <li id="sbitem1_6"><a href="{{ route('create_customer_index') }}"><i class="fas fa-ad"></i>
                                Customer enquiry</a></li>
                    @endif --}}
                    @if (Auth::user()->isagent() || Auth::user()->isconsultant())
                        <li id="sbitem1_12"><a href="{{ route('leads_pool_user_home_index') }}"><i
                                    class="fas fa-fw fa-table"></i>
                                Your Leads</a>
                        </li>
                        {{-- <li id="sbitem1_13"><a href="{{ route('show_leads_pool_data_comments_index') }}"><i
                                    class="fas fa-fw fa-table"></i>
                                    Your Leads Comments</a>
                        </li> --}}
                        <li id="sbitem1_14"><a href="{{ route('follow_up_user_home_index') }}">
                                <i class="fas fa-fw fa-table"></i> Follow up </a>
                        </li>
                        {{-- <li id="sbitem1_15"><a href="{{ route('show_follow_up_data_comments_index') }}">
                                <i class="fas fa-fw fa-table"></i> Follow up comments</a>
                        </li> --}}
                        <li id="sbitem1_10"><a href="{{ route('qualified_user_home_index') }}">
                                <i class="fas fa-fw fa-table"></i> Qualified </a>
                        </li>
                        {{-- <li id="sbitem1_11"><a href="{{ route('show_qualified_data_comments_index') }}">
                                <i class="fas fa-fw fa-table"></i> Qualified comments</a>
                        </li> --}}
                        <li id="sbitem1_17_1"><a href="{{ route('proceeded_user_home_index') }}">
                                <i class="fas fa-fw fa-table"></i> Proceeded</a>
                        </li>
                        {{-- <li id="sbitem1_18"><a href="{{ route('show_proceeded_data_comments_index') }}">
                                <i class="fas fa-fw fa-table"></i> Proceeded comments</a>
                        </li> --}}
                    @endif
                    {{-- @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                        <li id="sbitem1_8"><a href="{{ route('agent_data') }}"><i class="fas fa-fw fa-table"></i> Agent
                                data</a></li>
                        <li id="sbitem1_9"><a href="{{ route('map') }}"><i class="fas fa-fw fa-table"></i>
                                Map</a>
                        </li>
                    @endif --}}
                </ul>
            </li>
        @endif

        @if (Auth::user()->isagent() || Auth::user()->isconsultant())
            {{-- Comments Section --}}
            <li id="sbitem17">
                <a href="#" class="link-content comments-btn"><span class="left-title">Comments</span><span
                        class="fas fa-caret-down twelve"></span></a>
                <ul class="comments-show">
                    <li id="sbitem17_1"><a href="{{ route('show_leads_pool_data_comments_index') }}"><i
                                class="fas fa-fw fa-table"></i>
                            Leads Comments</a></li>
                    <li id="sbitem17_2"><a href="{{ route('show_follow_up_data_comments_index') }}"><i
                                class="fas fa-fw fa-table"></i> Follow Up Comments</a>
                    </li>
                    <li id="sbitem17_3"><a href="{{ route('show_qualified_data_comments_index') }}"><i
                                class="fas fa-fw fa-table"></i> Qualified Comments</a>
                    </li>
                    <li id="sbitem17_4"><a href="{{ route('show_proceeded_data_comments_index') }}"><i
                                class="fas fa-fw fa-table"></i> Proceeded Comments</a>
                    </li>
                    <li id="sbitem17_5"><a href="{{ route('index1') }}"><i class="fas fa-fw fa-table"></i> Data
                            Comments</a>
                    </li>
                </ul>
            </li>
    </ul>
    @endif



    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin() || Auth::user()->isagent())
        {{-- Data Section --}}
        <li id="sbitem8">
            <a href="#" class="link-content data-btn"><span class="left-title">Data</span><span
                    class="fas fa-caret-down eight"></span></a>
            <ul class="data-show">
                @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                    <li id="sbitem8_1"><a href="{{ route('home') }}"><i class="fas fa-fw fa-table"></i>
                            Imported Data</a></li>
                @elseif(Auth::user()->isagent())
                    <li id="sbitem8_1"><a href="{{ route('home') }}"><i class="fas fa-fw fa-table"></i>
                            Your Data</a></li>
                @endif
                @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                    <li id="sbitem8_2"><a href="{{ route('get_assigned_data_index') }}"><i
                                class="fas fa-fw fa-table"></i>
                            Assigned Data</a>
                    </li>
                    <li id="sbitem8_3"><a href="{{ route('show_assigned_agent_leads_pool_index') }}"><i
                                class="fas fa-ad"></i> Assigned Leads</a>
                    </li>
                    <li id="sbitem8_4"><a href="{{ route('show_comments_admin_index') }}"><i
                                class="fas fa-fw fa-table"></i> Commented data </a>
                    </li>
                @endif
            </ul>
        </li>

        {{-- Assign Section --}}
        @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
            <li id="sbitem2">
                <a href="#" class="link-content  asd-btn"><span class="left-title">Assign</span>
                    <span class="fas fa-caret-down second"></span></a>
                <ul class="asd-show">
                    <li id="sbitem2_1"><a href="{{ route('assign_agent_data_index') }}"><i class="fas fa-ad"></i>
                            Data</a>
                    </li>
                    <li id="sbitem2_3"><a href="{{ route('assign_agent_leads_pool_index') }}">
                            <i class="fas fa-ad"></i> Leads</a>
                    </li>
                    <li id="sbitem4_2"><a href="{{ route('assign_agent_for_landing') }}">
                            <i class="fas fa-fw fa-table"></i> Assign agent to landing page</a>
                    </li>
                </ul>
            </li>
        @endif
    @endif

    @if (Auth::user()->isadmin() ||
        Auth::user()->issuperAdmin() ||
        Auth::user()->isagent() ||
        Auth::user()->iscustomer())
        <li id="sbitem5">
            <a href="#" class="link-content pm-btn"><span class="left-title">Property
                    Management</span><span class="fas fa-caret-down fifth"></span></a>
            <ul class="pm-show">
                @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin() || Auth::user()->isagent())
                    <li id="sbitem5_1"><a href="{{ route('create_property_index') }}"><i class="fas fa-ad"></i>
                            Create</a>
                    </li>
                    {{-- <li id="sbitem5_2"><a href="{{ route('create_payment_index') }}"><i class="fas fa-ad"></i>
                            Create payment</a></li> --}}
                    <li id="sbitem5_3"><a href="{{ route('list_properties_index') }}"><i
                                class="fas fa-fw fa-table"></i> Live</a>
                    </li>
                    <li id="sbitem5_12"><a href="{{ route('list_archived_properties_index') }}"><i
                                class="fas fa-ad"></i>
                            Archive</a>
                    </li>
                    <li id="sbitem5_9"><a href="{{ route('list_communities') }}"><i class="fas fa-ad"></i>
                            Communities</a>
                    </li>

                    {{-- <li id="sbitem5_10"><a href="{{ route('create_new_subcommunity') }}"><i class="fas fa-ad"></i>
                                Create SubCommunity</a>
                        </li> --}}
                    <li id="sbitem5_11"><a href="{{ route('list_subcommunities') }}"><i class="fas fa-ad"></i>
                            Sub-Communities</a>
                    </li>
                    <li id="sbitem5_14"><a href="{{ route('list_countries') }}"><i class="fas fa-ad"></i>
                            countries</a>
                    </li>
                    <li id="sbitem5_13"><a href="{{ route('list_cities') }}"><i class="fas fa-ad"></i>
                            cities</a>
                    </li>
                    {{-- <li id="sbitem5_2"><a href="{{ route('create_payment_index') }}"><i class="fas fa-ad"></i>
                        Create payment</a></li> --}}
                    {{-- <li id="sbitem5_3"><a href="{{ route('list_properties_index') }}"><i
                                    class="fas fa-fw fa-table"></i> Properties List</a>
                        </li> --}}
                @endif
                {{-- @if (Auth::user()->isagent())
                        <li id="sbitem5_1"><a href="{{ route('create_property_index') }}"><i class="fas fa-ad"></i>
                                Create property</a>
                        </li>
                        <li id="sbitem5_3"><a href="{{ route('list_properties_index') }}"><i
                                    class="fas fa-fw fa-table"></i> Properties List</a>
                        </li>
                    @endif --}}
                {{-- @if (Auth::user()->iscustomer() || Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                    <li id="sbitem5_4"><a href="{{ route('list_payments_index') }}"><i
                                class="fas fa-fw fa-table"></i> List payments</a></li>
                @endif --}}
                {{-- @if (Auth::user()->isagent() || Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                    <li id="sbitem5_5"><a href="{{ route('create_inventory_index') }}"><i class="fas fa-ad"></i>
                            Create inventory</a>
                    </li>
                    <li id="sbitem5_6"><a href="{{ route('get_inventories_index') }}"><i
                                class="fas fa-fw fa-table"></i> Show inventories</a>
                    </li>
                @endif --}}
            </ul>
        </li>
    @endif

    @if (Auth::user()->isadmin() ||
        Auth::user()->issuperAdmin() ||
        Auth::user()->isagent() ||
        Auth::user()->isPhotographer())
        <li id="sbitem7">
            <a href="#" class="link-content pmeventa"><span class="left-title">Events</span><span
                    class="fas fa-caret-down pm-events"></span></a>
            <ul class="pm-event">

                <li id="sbitem7_1"><a href="{{ route('create_event') }}"><i class="fas fa-ad"></i>
                        Create Event</a>
                </li>
                <li id="sbitem7_2"><a href="{{ route('list_event') }}"><i class="fas fa-ad"></i>
                        Events List</a></li>


            </ul>
        </li>
        <li id="sbitem6">
            <a href="#" class="link-content ap-btn"><span class="left-title">Photographers
                    Schedule</span><span class="fas fa-caret-down sixth"></span></a>
            <ul class="ap-show">
                @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin() || Auth::user()->isagent())
                    <li id="sbitem6_1"><a href="{{ route('create_appointment_index') }}"><i class="fas fa-ad"></i>
                            Book Appointment</a>
                    </li>
                @endif
                @if (Auth::user()->isadmin() ||
                    Auth::user()->issuperAdmin() ||
                    Auth::user()->isagent() ||
                    Auth::user()->isPhotographer())
                    <li id="sbitem6_2"><a href="{{ route('show_appointment_index') }}"><i
                                class="fas fa-fw fa-table"></i>
                            Appointments List</a></li>
                @endif
            </ul>
        </li>
        @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
            <li id="sbitem12">
                <a href="#" class="link-content meet-btn"><span class="left-title">Meetings</span><span
                        class="fas fa-caret-down nine"></span></a>
                <ul class="meet-show">
                    <li id="sbitem12_1"><a href="{{ route('create.meeting') }}"><i class="fas fa-ad"></i>
                            Create Meeting</a>
                    </li>
                    <li id="sbitem12_2"><a href="{{ route('list.meetings') }}"><i class="fas fa-fw fa-table"></i>
                            Meetigns List</a></li>
                </ul>
            </li>
        @endif
    @endif

    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
        <li id="sbitem4">
            <a href="#" class="link-content au-btn"><span class="left-title">Admin & Users</span><span
                    class="fas fa-caret-down fourth"></span></a>
            <ul class="au-show">
                @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                    {{-- <li id="sbitem4_1_1"><a href="{{ route('create_buyer_index') }}"><i class="fas fa-ad"></i>
                            Create buyer</a></li> --}}
                    <li id="sbitem4_1"><a href="{{ route('create_user_index') }}"><i class="fas fa-ad"></i>
                            Create User</a></li>
                    <li id="sbitem4_3"><a href="{{ route('list_users_index') }}"><i class="fas fa-fw fa-table"></i>
                            Users List</a></li>

                    <li id="sbitem4_5"><a href="{{ route('uploadedFiles') }}"><i class="fas fa-ad"></i>
                            Export & Uploaded Files</a>
                    </li>

                    <li id="sbitem4_88"><a href="{{ route('signature.index') }}"><i class="fas fa-ad"></i>
                            Create Signature</a>
                    </li>

                @endif
                @if (Auth::user()->issuperAdmin())
                    <li id="sbitem4_6"><a href="{{ route('create_super_Admin') }}"><i class="fas fa-ad"></i>
                            Create Admin</a></li>
                @endif
                {{-- <li id="sbitem4_6"><a href="{{ route('create_user_index') }}">Create users & admins</a>
            </li> --}}
                {{-- <li id="sbitem4_7"><a href="{{ route('update_user_index') }}">Profile</a></li> --}}
            </ul>
        </li>
    @endif

    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
        {{-- Buildings --}}
        <li id="sbitem16">
            <a href="#" class="link-content data-btn3"><span class="left-title">Buildings
                    Management</span><span class="fas fa-caret-down building"></span></a>
            <ul class="data-show3">
                <li id="sbitem16_1"><a href="{{ route('create_building') }}"><i class="fas fa-fw fa-table"></i>
                        Create Building</a></li>
                <li id="sbitem16_2"><a href="{{ route('listbuildingindex') }}"><i class="fas fa-fw fa-table"></i>
                        Buildings List</a>
                </li>

            </ul>
        </li>
    @endif

    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
        {{-- Data Section --}}
        <li id="sbitem20">
            <a href="#" class="link-content data-btn20"><span class="left-title">Developer</span><span
                    class="fas fa-caret-down twenty"></span></a>
            <ul class="data-show20">
                <li id="sbitem20_1"><a href="{{ route('create_developer') }}"><i class="fas fa-fw fa-table"></i>
                        Create Developer</a></li>
                <li id="sbitem20_2"><a href="{{ route('listdeveloperindex') }}"><i class="fas fa-fw fa-table"></i>
                        Developer List</a>
                </li>

            </ul>
        </li>
    @endif

    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
        {{-- Blog Section --}}
        <li id="sbitem15">
            <a href="#" class="link-content data-btn2"><span class="left-title">Blog Management</span><span
                    class="fas fa-caret-down five-five"></span></a>
            <ul class="data-show2">
                <li id="sbitem15_1"><a href="{{ route('create_blog') }}"><i class="fas fa-fw fa-table"></i>
                        Create Blog</a></li>
                <li id="sbitem15_2"><a href="{{ route('listblogindex') }}"><i class="fas fa-fw fa-table"></i> Blog
                        List</a>
                </li>

            </ul>
        </li>
    @endif

    @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
        <li id="sbitem3">
            <a href="#" class="link-content report-btn"><span class="left-title">Reports</span><span
                    class="fas fa-caret-down third"></span></a>
            <ul class="report-show">
                @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
                    <li id="sbitem3_1"><a href="{{ route('getcharts') }}"><i class="fas fa-chart-pie"></i>
                            Charts</a></li>

                    {{-- <li id="sbitem3_2"><a href="{{ route('geochart') }}"><i class="fas fa-chart-pie"></i>
                            Geo
                            chart</a></li> --}}
                    <li id="sbitem3_5"><a href="{{ route('leader_board_index') }}"><i
                                class="fas fa-fw fa-table"></i>
                            Calls</a></li>
                @endif
                @if (Auth::user()->isadmin())
                    <li id="sbitem3_8"><a href="{{ route('officetime') }}"><i class="fas fa-fw fa-table"></i>
                            Office Time</a></li>
                    <li id="sbitem3_9"><a href="{{ route('Success') }}"><i class="fas fa-fw fa-table"></i>
                            Success</a></li>
                    <li id="sbitem3_10"><a href="{{ route('reportassignedagentsleads') }}"><i
                                class="fas fa-fw fa-table"></i>
                            Assigned Agents For Lead</a></li>
                @endif
            </ul>
        </li>

        <li id="sbitem13">
            <a href="#" class="link-content setting-btn"><span class="left-title">Setting</span><span
                    class="fas fa-caret-down ten"></span></a>
            <ul class="setting-show">
                <li id="sbitem13_1"><a href="{{ route('setting.logo') }}"><i class="fas fa-ad"></i> Logo</a>
                </li>
            </ul>
        </li>
        <li id="sbitem22">
            <a href="#" class="link-content subscriptions-btn"><span class="left-title">Subscriptions</span><span
                    class="fas fa-caret-down subscriptions-span"></span></a>
            <ul class="subscriptions-show">
                <li id="sbitem22_1"><a href="{{ route('subscriptions') }}"><i class="fas fa-ad"></i>Subscriptions List
                    </a>
                </li>
            </ul>
        </li>
        {{-- Off-Plan Projects Section --}}
        <li id="sbitem30">
            <a href="#" class="link-content data-btn30"><span class="left-title">Off-Plan Projects</span><span
                    class="fas fa-caret-down off-plan30"></span></a>
            <ul class="off-plan-show30">
                <li id="sbitem30_1"><a href="{{ route('off_plan_project_create') }}"><i class="fas fa-ad"></i>
                        Create Off-Plan Project</a></li>
                <li id="sbitem30_2"><a href="{{ route('off_plan_project_list') }}"><i class="fas fa-fw fa-table"></i>
                        Off-Plan Projects List</a>
                </li>

                <li id="sbitem30_2"><a href="{{ route('pop-up-update') }}"><i class="fas fa-fw fa-table"></i>
                        Popup Update</a>
                </li>
            </ul>
        </li>


        <li id="sbitem63">
            <a href="#" class="link-content data-btn63"><span class="left-title">Home Page</span><span
                    class="fas fa-caret-down off-plan63"></span></a>
            <ul class="off-plan-show63">
                <li id="sbitem63_1"><a href="{{ route('create_testimonial') }}"><i class="fas fa-ad"></i>
                        Create Testimonial</a></li>
                <li id="sbitem63_2"><a href="{{ route('list_testimonials') }}"><i class="fas fa-fw fa-table"></i>
                         List Testimonial</a>
                </li>
                <li id="sbitem63_3"><a href="{{ route('create_marketing') }}"><i class="fas fa-ad"></i>
                        Create Marketing Channel</a></li>
                <li id="sbitem63_4"><a href="{{ route('list_marketing') }}"><i class="fas fa-fw fa-table"></i>
                         List Marketing Channels</a>
                </li>
                <li id="sbitem63_3"><a href="{{ route('create_listing') }}"><i class="fas fa-ad"></i>
                        Create Listing Syndication</a></li>
                <li id="sbitem63_4"><a href="{{ route('list_listing') }}"><i class="fas fa-fw fa-table"></i>
                         List Listing Syndications</a>
            </ul>
        </li>


        <li id="sbitem56">
            <a href="#" class="link-content data-btn56"><span class="left-title">Insights</span><span
                    class="fas fa-caret-down off-plan56"></span></a>
            <ul class="off-plan-show56">
                <li id="sbitem56_1"><a href="{{ route('insight_create') }}"><i class="fas fa-ad"></i>
                        Create Insight</a></li>
                <li id="sbitem56_2"><a href="{{ route('insight_list') }}"><i class="fas fa-fw fa-table"></i>
                        Insights List</a>
                </li>
            </ul>
        </li>


        <li id="sbitem32">
            <a href="#" class="link-content data-btn32">
                <span class="left-title">Emails</span>
                <span class="fas fa-caret-down off-plan32"></span>
            </a>
            <ul class="off-plan-show32" style="display: none;">
                <li id="sbitem32_2">
                    <a href="{{ route('emails.show') }}">
                        <i class="fas fa-fw fa-table"></i> Show Emails
                    </a>
                </li>
            </ul>
        </li>


        <li id="sbitem55">
            <a href="#" class="link-content data-btn55"><span class="left-title">real estate guides</span><span
                    class="fas fa-caret-down off-plan55"></span></a>
            <ul class="off-plan-show55">
                <li id="sbitem55_1"><a href="{{ route('real_estate_guides_create') }}"><i class="fas fa-ad"></i>
                        Real Estate Create </a></li>
                <li id="sbitem55_2"><a href="{{ route('real_estate_list') }}"><i class="fas fa-fw fa-table"></i>
                        Real Estate List </a>
                </li>
            </ul>
        </li>

        <li id="sbitem14">
            <a href="#" class="link-content sync-btn"><span class="left-title">Sync</span><span
                    class="fas fa-caret-down fourteen"></span></a>
            <ul class="sync-show">
                <li id="sbitem14_1"><a href="{{ route('sync') }}"><i class="fas fa-ad"></i> Sync Properties</a>
                <li id="sbitem14_2"><a href="{{ route('sync_communities') }}"><i class="fas fa-ad"></i> Sync Communities</a>
                <li id="sbitem14_3"><a href="{{ route('sync_sub_communities') }}"><i class="fas fa-ad"></i> Sync
                        SubCommunities</a>
                <li id="sbitem14_4"><a href="{{ route('sync_buildings') }}"><i class="fas fa-ad"></i> Sync Buildings</a>
                </li>
            </ul>
        </li>
    @endif
    {{-- Contact Us Section --}}
    {{-- @if (Auth::user()->isadmin() || Auth::user()->issuperAdmin())
        <li id="sbitem21">
            <a href="#" class="link-content data-btn21"><span class="left-title">Contact Us</span><span
                    class="fas fa-caret-down contact_us21"></span></a>
            <ul class="data-show21">
                <li id="sbitem21_1"><a href="{{ route('contact_us_list') }}"><i class="fas fa-fw fa-table"></i>
                        Contact Us List</a></li>
            </ul>
        </li>
    @endif --}}
    {{-- @if (Auth::user()->isPhotographer() || Auth::user()->isagent() || Auth::user()->isadmin())
        <li id="sbitem11"><a href="{{ route('get_calender') }}"><span class="left-title">Calender</span></a>
        </li>
    @endif --}}

    {{-- Log Out --}}
    <li>
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <span class="left-title"> {{ __('Logout') }}</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>

    </ul>
</nav>
