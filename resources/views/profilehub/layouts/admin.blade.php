<!doctype html>
<!--
* profilehub :: Admin
* @author Solomon Bareebe <solomon@tutajua.com>
* @version v1.0.0-alpha.1
* @link https://profilehub.site
* Copyright (c) 2020 Solomon Bareebe
-->
<!DOCTYPE html>
<html lang="en">
@php 
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @hasSection('title')
            @yield('title') |
        @endif
        {{ config('app.name') }}
    </title>
    @include('profilehub::layouts.includes.favicons')
    <meta name="msapplication-TileColor" content="#ffffff"> 
    <meta name="theme-color" content="#ffffff"> 
    @yield('meta')
    @include('profilehub::layouts.includes.fontawesome')
    @include('profilehub::layouts.includes.remixicon')
    <link href="{{ asset('vendor/profilehub/addons/bootstrap/5.2.3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/profilehub/fonts/fontawesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/profilehub/fonts/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/profilehub/css/profilehub.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('vendor/profilehub/images/logo/Profilehub-Logo.png') }}" alt="profilehub Logo">
                
            </a>
            @include('profilehub::layouts.partials.admin-top-nav')
        </div>
    </nav>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        @include('profilehub::layouts.menus.admin-sidebar-menu')
    </div>
    <!-- Sidebar -->
    <!-- Main Content -->
    <div class="content" id="mainContent">
        @include('profilehub::layouts.includes.flash')
        @yield('content')
    </div>
    <!-- end Main Content -->

    <!-- Core JS -->
    <script src="{{ asset('vendor/profilehub/addons/bootstrap/5.2.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/profilehub/js/profilehub.js') }}"></script>
    <script>

        
(function () {
            'use strict';
            window.addEventListener('load', function () {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        function updateDeleteModal(title, message, formAction, deleteIdName, deleteIdValue, backUrlName, backUrlValue,
            delMethod = false, delFunction = false) {
            // Update the modal title _method
            document.getElementById('deleteModalTitle').innerHTML = title;

            // Update the modal message
            document.getElementById('deleteModalMsg').innerHTML = message;

            // Update the form action
            document.getElementById('deleteForm').action = formAction;

            // Update the hidden input for deleteId
            var deleteIdInput = document.getElementById('deleteId');
            deleteIdInput.name = deleteIdName;
            deleteIdInput.value = deleteIdValue;

            // Update the hidden input for back_url
            var backUrlInput = document.getElementById('back_url');
            backUrlInput.name = backUrlName;
            backUrlInput.value = backUrlValue;
            if (delMethod) {
                document.getElementById('_method').value = delMethod;
            }
            if (delFunction) {
                var delInput = document.getElementById('delFunction');
                delInput.name = 'function';
                delInput.value = delFunction;
            }
        }

        function addTextToElement(elementId, text) {
            var element = document.getElementById(elementId);
            if (element) {
                element.innerHTML = text;
            }
        }

        function addInputToElement(elementId, text) {
            var element = document.getElementById(elementId);
            if (element) {
                element.value = text;
            }
        }

        function getElementAddtoElement(elementId, newElementId) {
            var element = document.getElementById(elementId);
            var newTxt = '';
            if (element) {
                newTxt = element.innerHTML;
            }
            addTextToElement(newElementId, newTxt);
        }

        function replaceCssClass(elementId, oldClass, newClass) {
            var element = document.getElementById(elementId);
            element.classList.remove(oldClass);
            element.classList.add(newClass);
        }
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })


    </script>

    @yield('javascript')
</body>

</html>