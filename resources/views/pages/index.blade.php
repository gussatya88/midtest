@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet" />
    <style>
        .card-img-top {
            width: 100%;
            height: 20vw;
            object-fit: cover;
        }

    </style>
@endpush

@section('content')
    <section class="row">
        @forelse ($packages as $package)
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card">
                    <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                        data-mdb-ripple-color="light">
                        <img src="{{ asset($package->photo_path) }}" class="card-img-top" />
                        <a href="#!">
                            <div class="hover-overlay">
                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <a href="" class="text-reset">
                            <h5 class="card-title mb-3">{{ $package->name }}</h5>
                        </a>
                        <s>Rp {{ $package->normal_price }}</s><strong class="ms-2 text-danger">Rp
                            {{ $package->end_price }}</strong>
                    </div>
                    <a href="{{ route('show.product', $package->id) }}" class="btn btn-primary">View Package</a>
                </div>
            </div>

            {{-- <div class="col-4">
                <div class="card shadow-lg">
                    <img class="card-img-top" src="{{ asset($package->photo_path) }}" alt="Card image cap">
                    <div class="card-body text-center ">
                        <h4>
                            Rp {{ $package->end_price }}
                        </h4>
                        <p>
                            <span style="text-decoration: line-through"
                                class="mr-4">{{ $package->normal_price }}</span>
                        </p>
                        <p class="card-text">
                        </p>
                        <a href="{{ route('show.product', $package->id) }}" class="btn btn-primary">Lihat
                            Paket</a>
                    </div>
                </div>
            </div> --}}
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    <h4 class="alert-heading">Oops!</h4>
                    <p>Tidak ada paket yang tersedia.</p>
                </div>
            </div>
        @endforelse
    </section>
@endsection
