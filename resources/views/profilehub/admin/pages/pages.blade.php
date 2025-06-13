@extends('vendor.profilehub.layouts.admin')
@inject('admin', 'BabeRuka\ProfileHub\Repository\UserAdmin')
@php 
$widget_types = $admin->widget_types();
@endphp
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-uppercase fw-bold"><i class="fa fa-align-justify"></i> {{ __('Pages') }}</h5>
                            <div>
                                <button data-bs-toggle="modal" data-bs-target="#managePageModal"
                                    class="btn btn-primary active float-right">Add Page</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-condensed table-striped js-exportable"
                                id="datatables">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Slug</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Author</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_pages as $page)
                                        <?php
                                        $admin = $all_users->where('id', $page->page_admin);
                                        ?>
                                        <tr>
                                            <td class="text-center">{{ $page->page_id }}</td>
                                            <td class="text-center">{{ $page->page_slug }}</td>
                                            <td class="text-center">{{ $page->page_name }}</td>
                                            <td class="text-center">@php
                                                if ($page->page_type == 1) {
                                                    echo 'LMS Page';
                                                } elseif ($page->page_type == 2) {
                                                    echo 'Course Page';
                                                } elseif ($page->page_type == 3) {
                                                    echo 'Public Page';
                                                } else {
                                                    echo 'NA';
                                                }
                                            @endphp</td>
                                            <td class="text-center">{{ $admin[0]->firstname }} {{ $admin[0]->lastname }}
                                            </td>
                                            <td class="text-center">
                                                @if ($page->page_settings == 'public_page')
                                                    <a href="{{ route('profilehub.admin.layout.pages.preview',['page_id' => $page->page_id, 'type' => $page->page_settings])}}"
                                                        data-tooltip="tooltip" data-placement="top" title="Preview {{ $page->page_name }} Page"
                                                        class="btn btn-success" href="#">
                                                        <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                                                    </a>
                                                @endif
                                                <a class=""
                                                    href="{{ route('profilehub.admin.layout.pages.edit', ['page' => $page->page_id, 'page_name' => $page->page_name]) }}"
                                                    data-tooltip="tooltip" data-placement="top" title="Edit {{ $page->page_name }} Page">
                                                    <i class="ri-edit-circle-fill text-primary" aria-hidden="true"></i>
                                                </a>
                                                @if ($page->page_type == 3)
                                                    <a onClick="popDelModal({{ $page->page_id }},{{ $page->page_admin }},'{{ addslashes($page->page_name) }}')"
                                                        data-toggle="modal" data-target="#delPageModal"
                                                        data-tooltip="tooltip" data-placement="top" title="Delete {{ $page->page_name }} Page"
                                                        class=" btn-danger" href="#">
                                                        <i class="ri-delete-bin-5-fill text-danger"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="delPageModal" tabindex="-1" role="dialog" aria-labelledby="delPageModalModalLabel"
        aria-modal="true">
        <form action="{{ route('profilehub.admin.layout.createrecord') }}" id="delPageModalModalForm" method="POST"
            novalidate="">
            <input type="hidden" name="function" value="del-page" />
            <input type="hidden" name="page_id" id="page_id_del" value="0" />
            <input type="hidden" name="page_admin" id="page_admin_del" value="0" />
            @csrf
            @method('POST')
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <h5 class="modal-title" id="asasas">Delete Page</h5>
                        </div>
                        <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <hr />
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <label for="event_title" id="title_of_del"></label>
                                    <div class="form-group">
                                        <div class="form-line">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="event_edit_settings">
                                    <button class="btn btn-danger float-right active ml-3" type="submit">delete</button>
                                    <button type="button" class="btn btn-secondary mr-3 float-right"
                                        data-dismiss="modal">Close </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('profilehub::admin.pages.modals.manage-page-modal') 
@endsection


@section('javascript')
    
    <script type="text/javascript">
        $(function () {
            $('[data-tooltip="tooltip"]').tooltip()
        })
        function popDelModal(page_id, page_admin, title_of) {
            document.getElementById('page_id_del').value = page_id;
            document.getElementById('page_admin_del').value = page_admin;
            document.getElementById('title_del').innerHTML = 'Please confirm delete of - ' + title_of + '!';
            // Delete Announcement
        }
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            if ($('input[type=checkbox]:checked').length > 0) {
                                $('input[type=checkbox]').prop('required', false);
                            } else {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        $(document).ready(function() {
            $('#datatables').DataTable({
                serverSide: false,
                processing: false,
                orderable: false,

            });
        })
    </script>
@endsection
