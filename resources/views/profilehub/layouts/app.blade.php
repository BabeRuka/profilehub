<!doctype html>
<!--
* Be4uBuy - Laravel LMS
* @version v1.0.0-alpha.1
* @link https://be4ubuy.co.za
* Copyright (c) 2020 Solomon Bareebe
-->
<!DOCTYPE html>
<html lang="en">
@php
    //dd(Auth::user());
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel ProfileHub :: Admin @yield('title')</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('addons/bootstrap/5.2.3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fontawesome/4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('fonts/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/profilehub/css/profilehub.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo/Profilehub-Logo.png') }}" alt="Laravel Profilehub Logo">
                
            </a>
            @include('profilehub::layouts.includes.admin-top-nav')
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
    <script src="{{ asset('addons/bootstrap/5.2.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/profilehub/js/profilehub.js') }}"></script>
    <script>

        
        function updateDeleteModal(title, message, formAction, deleteIdName, deleteIdValue, backUrlName, backUrlValue, delMethod = false, delFunction = false) {
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


    </script>

    @yield('javascript')
</body>

</html>