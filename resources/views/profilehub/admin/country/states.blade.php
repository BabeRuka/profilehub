@extends('vendor.profilehub.layouts.admin')
@php
    //$all_categories = $data['all_categories'];
@endphp
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title text-uppercase fw-bold">
                <i class="fa fa-solid fa-align-justify"></i> All Countries
            </h5>

            <div>
                <a href="#" data-bs-toggle="modal"
                    onclick="addTextToElement('addCountryModalTitle', 'Add Country'),addTextToElement('addCountryModalIcon', '<i class=\'ri-add-circle-fill text-primary text-secondary\'></i>')"
                    data-bs-target="#addCountryModal" class="btn btn-primary text-light waves-effect waves-light"
                    title="Add Country">
                    <i class="ri-add-circle-fill ms-1"></i>
                    <span class="ms-1">Add Country</span>
                </a>

            </div>
        </div>


        <hr>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped table-bordered js-exportabl" id="datatables">

                            <thead>
                                <tr class="text-nowrap">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Country Code</th>
                                    <th>Dialing Code</th>
                                    <th>Description</th>
                                    <th>Manage</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('profilehub::admin.countries.modals.add-country-modal')
    @include('profilehub::admin.countries.modals.edit-country-modal')
    @include('profilehub::admin.modals.delete-modal')
@endsection
