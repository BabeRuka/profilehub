@extends('profilehub::layouts.app')
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

@section('javascript')
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#datatables').DataTable({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            ajax: ({
                type: "POST",
                url: '{{ route('profilehub::admin.countries.data') }}'
            }),
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: 'Blfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            serverSide: true,
            processing: true,
            orderable: false,
            columns: [
                {
                    data: 'country_id',
                    name: 'country_id'
                },
                {
                    data: 'country_name',
                    name: 'country_name'
                },
                {
                    data: 'country_code',
                    name: 'country_code'
                },
                {
                    data: 'dialing_code',
                    name: 'dialing_code'
                },
                {
                    data: 'country_desc',
                    name: 'country_desc'
                },
                {
                    data: 'manage',
                    name: 'manage',
                    render: function(data, type, row){
                        return '<a href="#editCountryModal" type="button" data-bs-toggle="modal" data-bs-target="#editCountryModal" class="table-cell"> <i class="ri-cursor-fill text-primary"></i> </a>';
                    }
                },
                
                {
                    data: 'edit',
                    name: 'edit',
                    render: function(data, type, row) {
                        //deleteModalTitle
                        var del_url = '{{ route('profilehub::admin.countries.delete') }}';
                        var deleteIdName = 'id';
                        var deleteIdValue = row.country_id;
                        var backUrlName = 'backUrl';
                        var backUrlValue = '{{ route('profilehub::admin.countries') }}';
                        const encodedcountry_name = encodeURIComponent(row.country_name);
                        const encodedcountry_code = encodeURIComponent(row.country_code);
                        const encodeddialing_code = encodeURIComponent(row.dialing_code);
                        const encodedcountry_desc = encodeURIComponent(row.country_desc); 
                        return '<a href="#editCountryModal" onClick="editCountry(\'' +
                            parseInt(country_id) + '\', \'' + encodedcountry_name + '\', \'' + encodedcountry_code + '\', \'' + encodeddialing_code + '\', \'' + encodedcountry_desc + '\' )" type="button" data-bs-toggle="modal" data-bs-target="#editCountryModal" class="table-cell"> <i class="ri-edit-circle-fill text-primary"></i> </a>';
                    }
                },

                {
                    data: 'delete',
                    name: 'delete',
                    render: function(data, type, row) {
                        //deleteModalTitle
                        var del_url = '{{ route('profilehub::admin.countries.delete') }}';
                        var deleteIdName = 'id';
                        var deleteIdValue = row.country_id;
                        var backUrlName = 'backUrl';
                        var backUrlValue = '{{ route('profilehub::admin.countries.index') }}';
                        return '<a href="#deleteModal" onClick="updateDeleteModal(\'Delete ' +
                            row.country_name + '\', \'Are you sure you want to delete this country? ' + row
                            .country_name + '\', \'' + del_url + '\', \'' + deleteIdName + '\', \'' +
                            deleteIdValue + '\', \'' + backUrlName + '\', \'' + backUrlValue +
                            '\')" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="table-cell"> <i class="ri-delete-bin-5-fill text-danger"></i> </a>';
                    }
                }
            ]
        });
    });

    function editCountry(country_id, country_name, country_code, dialing_code, country_desc) {

        const decodedcountry_name = decodeURIComponent(country_name);
        const decodedcountry_desc = decodeURIComponent(country_desc);
        const decodeddialing_code = decodeURIComponent(dialing_code);
        document.getElementById('editCountryModalHeading').innerHTML = 'Edit Country Details - ' + decodedcountry_name;

        const new_country_id = parseInt(country_id);
        console.log(new_country_id);
        if (isZeroOrLess(new_country_id)) {
            document.getElementById('country_id').value = '';
            document.getElementById('country_name').value = '';
            document.getElementById('country_code').value = '';
            document.getElementById('dialing_code').value = '';
            document.getElementById('country_desc').value = '';
            return true;
        }else{
            document.getElementById('country_id').value = country_id; 
            document.getElementById('country_name').value = decodedcountry_name;
            document.getElementById('country_code').value = country_code;
            document.getElementById('dialing_code').value = decodeddialing_code;
            document.getElementById('country_desc').value = decodedcountry_desc;
            return true;
        }
    }
    function isZeroOrLess(number) {
        return number <= 0;
    }
</script> 
 
@endsection