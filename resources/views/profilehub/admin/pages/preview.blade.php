@extends('profilehub::layouts.app')
<?php
$url_img = url('files/pages/banners/');
$page_image = $page_data->where('page_key', 'page_image');
$banner_image = $page_image != '' && $page_image->first() ? $url_img . '/' . $page_image->first()->page_data : '';
$banner_image = $banner_image != '' ? '<img src="' . $banner_image . '" class="img-fluid" alt="' . $page_settings->page_name . '">' : '';
$num = 1;
$side_col_class = $page_layout->page_data == 'two_cards_left' ? 'pull-left' : 'pull-right';
$main_col_class = $side_col_class == 'pull-right' ? 'pull-left' : 'pull-left';
$author = $allusers->where('id', $page_settings->page_admin);
$url_img = url('files/user');
$profile_pic = $author->first()->profile_pic != '' ? $url_img . '/' . $author->first()->profile_pic : '';
$profile_pic = $profile_pic != '' ? '<img src="' . $profile_pic . '" class="img-thumbnail rounded-circle" alt="' . $author->first()->firstname . '">' : '';
?>
@inject('UserFunctions', 'BabeRuka\ProfileHub\Repository\UserFunctions')
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col float-left">
                            <strong>{{ $page_settings->page_name }}</strong>
                            <div>By {{ ucwords($author->first()->firstname) }}
                                {{ ucwords($author->first()->lastname) }}
                            </div>
                            <div class="small text-muted"><span><small
                                        class="text-muted">{{ date('l jS \of F Y A', strtotime($page_settings->create_date)) }}</small></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="">
                                <div class="col-9 float-right">
                                    <div class="col-5 float-right">
                                        @php  echo $profile_pic @endphp
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body">

                    @if ($page_layout->page_data == 'two_cards_left')
                        <!-- /.row  g-0 no-gutters-->
                        <div class="row">
                            <div class="col-sm-6 col-lg-3 px-0">

                                @foreach ($active_widgets as $widget)
                                    @if ($widget->page_module != 'DEFAULT')
                                        @php
                                            $widget_filename = strtolower($widget->page_module);
                                            $page_row = $all_page_widgets->where('widget_key',$widget->page_module);
                                            $page_row = $page_row!='' && $page_row->first() ? $page_row->where('page_key','page_row') : null;
                                        @endphp
                                        @include('admin.widgets.' . $widget_filename . '-widget')
                                    @endif
                                @endforeach

                            </div>
                            <div class="col-sm-6 col-lg-9 px-0">
                                <div class="col-12">
                                    @php echo $banner_image @endphp
                                </div>
                            </div>
                        </div>
                        <!-- /.row-->
                    @elseif ($page_layout->page_data == 'two_cards_right')
                        <div class="row">
                            <div class="col-sm-6 col-lg-9">
                                <div class="row mt-1 ">
                                    @foreach ($active_widgets as $widget)
                                        @if ($widget->page_module != 'DEFAULT')
                                            @php
                                                $widget_filename = strtolower($widget->page_module);
                                            @endphp
                                            @include('admin.widgets.' . $widget_filename . '-widget')
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                @include('admin.widgets.default-widget')
                            </div>
                        </div>
                    @elseif ($page_layout->page_data == 'full')
                        <div class="row">
                            <div class="col-12">
                                <div class="row mt-1">
                                    @foreach ($active_widgets as $widget)
                                        @if ($widget->page_module != 'DEFAULT')
                                            @php
                                                $widget_filename = strtolower($widget->page_module);
                                            @endphp
                                            @include('lms.admin.widgets.' . $widget_filename . '-widget')
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="announcementModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="announcementAuthor"></div>
                    <div class="mt-2" id="announcementBody"></div>
                </div>
                <div class="modal-footer mb-3 mr-1">
                    <button type="button" class="btn btn-secondary active ml-2" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

@endsection

@section('javascript')
    <script src="{{ asset('addons/datatables/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('addons/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        function trackAnnouncement(div_id) {
            var mtitle = document.getElementById('anouncement_title_' + div_id + '').innerHTML;
            document.getElementById('announcementModalTitle').innerHTML = mtitle;
            var author_details = document.getElementById('author_details_' + div_id + '').innerHTML;
            var anouncement_body = document.getElementById('anouncement_body_' + div_id + '').innerHTML;
            document.getElementById('announcementAuthor').innerHTML = author_details;
            document.getElementById('announcementBody').innerHTML = anouncement_body;
            sessionStorage.setItem("announcement_id", div_id);
            var tracking_action = document.getElementById('tracking_action_' + div_id + '').value;
            //'read','unread'
            if (tracking_action == 'unread') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ action('AnnouncementController@track') }}",
                    async: false,
                    data: {
                        'announcement_id': sessionStorage.getItem("announcement_id")
                    },
                    success: function(data) {
                        result = data;
                        document.getElementById('action_of_' + sessionStorage.getItem("announcement_id") + '')
                            .className = 'progress-bar bg-success';
                        sessionStorage.clear();
                    }
                });
            }
        }

        function trackNoteAnnouncement(div_id) {
            var mtitle = document.getElementById('note_anouncement_title_' + div_id + '').innerHTML;
            document.getElementById('noteModalTitle').innerHTML = mtitle;
            var author_details = document.getElementById('note_author_details_' + div_id + '').innerHTML;
            var anouncement_body = document.getElementById('note_body_' + div_id + '').innerHTML;
            document.getElementById('noteAnnouncementAuthor').innerHTML = author_details;
            document.getElementById('noteAnnouncementBody').innerHTML = anouncement_body;
            var tracking_action = document.getElementById('note_tracking_action_' + div_id + '').value;
        }
    </script>
@endsection
