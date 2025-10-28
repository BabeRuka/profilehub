@extends('vendor.profilehub.layouts.admin')
@inject('userdetails', 'BabeRuka\ProfileHub\Models\UserFieldDetails')
@section('css')
<link rel="stylesheet" href="{{ asset('vendor/profilehub/addons/datatables/bootstrap5/css/datatables.min.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-xs-12	col-sm-12	col-md-12	col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title text-uppercase fw-bold">
                                <i class="fa fa-solid fa-align-justify"></i> Dashboard
                            </h5>
                            <div>

                            
                            </div>
                        </div> 
                        <div class="card-body">
                            <div class="body">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
 
    @endsection


    @section('javascript')
        <script src="{{ asset('vendor/profilehub/addons/datatables/bootstrap5/js/datatables.min.js') }}"></script>
        <script>
            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             
 
        </script>
    @endsection
