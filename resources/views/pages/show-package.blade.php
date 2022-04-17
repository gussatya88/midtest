@extends('layouts.app')

@section('title', 'List Products')

@section('content')
    <section class="row">

        @forelse ($package->products as $product)
            <div class="col-4">
                <div class="card shadow-lg">
                    <img class="card-img-top" src="{{ asset($product->photo_path) }}" alt="Card image cap">
                    <div class="card-body text-center ">
                        <h5>{{ $product->name }}</h5>
                        <div>
                            <i class="fa-solid fa-tags"></i>
                            <p class="badge bg-warning">{{ $product->category->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    <h4 class="alert-heading">Oops!</h4>
                    <p>Tidak ada Product yang tersedia.</p>
                </div>
            </div>
        @endforelse
    </section>
@endsection
