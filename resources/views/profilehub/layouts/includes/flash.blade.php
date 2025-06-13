@if (session('success') || session('error') || session('warning') || session('info'))
<div class="body flex-grow-1">
    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('message'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @else
                    {{ session()->forget('success') }}
                    {{ session()->forget('error') }}
                    {{ session()->forget('warning') }}
                    {{ session()->forget('info') }}
                    {{ session()->forget('message') }}
                @endif
                <!-- end Flash Messages -->
            </div>
        </div>
    </div>
</div>
@endif