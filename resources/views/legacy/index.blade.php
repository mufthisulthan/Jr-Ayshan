<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="JR Marketing (Pvt) Ltd - POS, ERP, Stock Management & Invoicing Application. Login to your account.">
    <meta name="author" content="JR Marketing (Pvt) Ltd">
    <meta name="theme-color" content="#0a5c2e">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>JR Marketing (Pvt) Ltd &mdash; Login</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">

    <!-- CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>

    <!-- LOGIN PAGE WRAPPER -->
    <main class="login-page" role="main" aria-label="Login Page">

        <!-- ===================== COMPONENT: Login Logo ===================== -->
        <div id="login-logo-placeholder">
            <div class="login-logo-area" role="banner">
                <div class="login-logo-circle" aria-label="JR Marketing (Pvt) Ltd Logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="JR Marketing (Pvt) Ltd Logo" class="login-logo-img-circle">
                </div>
                <h2 class="login-brand-name">JR Marketing (Pvt) Ltd</h2>
            </div>
        </div>        <!-- ===================== COMPONENT: Login Card ===================== -->
        <livewire:login-form />
        <!-- ===================== COMPONENT: Login Footer ===================== -->
        <footer id="login-footer-placeholder" class="login-footer" role="contentinfo">
            <p>JR Marketing (Pvt) Ltd &mdash; V6.3 &nbsp;|&nbsp; Copyright &copy; 2025 All rights reserved.</p>
            <p>Design and Developed by JR Marketing (Pvt) Ltd</p>
        </footer>

    </main>
    @livewireScripts
</body>
</html>



