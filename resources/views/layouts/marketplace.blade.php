@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/marketplace.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="marketplace-container">
    <!-- Header Section -->
    <div class="marketplace-header bg-primary text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold">@yield('page-title', 'PREGÃO Marketplace')</h1>
                    <p class="lead">@yield('page-subtitle', 'Encontre os melhores produtos e serviços em Angola')</p>
                </div>
                <div class="col-md-6">
                    @yield('header-content')
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            @hasSection('sidebar')
            <div class="col-lg-3">
                @yield('sidebar')
            </div>
            @endif

            <!-- Main Content Area -->
            <div class="@hasSection('sidebar') col-lg-9 @else col-12 @endif">
                @include('components.alerts')
                @yield('marketplace-content')
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/marketplace.js') }}"></script>
@endsection