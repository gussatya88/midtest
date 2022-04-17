@extends('layouts.app')

@section('title', 'Edit Package');

@section('content')
    <div class="container">
        <div class="card">
            {{-- error section --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- error section --}}
            <div class="card-body">
                <form action="{{ route('package.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="normal_price">Normal Price</label>
                        <input type="number" name="normal_price" id="normal_price" class="form-control"
                            value="{{ $package->normal_price }}">
                    </div>
                    <div class="form-group">
                        <label for="end_price">End Price</label>
                        <input type="number" name="end_price" id="end_price" class="form-control"
                            value="{{ $package->end_price }}">
                    </div>
                    <div class="form-group">
                        <label for="end_price">Photo Before</label>
                        <div>
                            <img src="{{ asset($package->photo_path) }}" id="image-package" class="img-fluid">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo"
                            onchange="document.getElementById('image-package').src = window.URL.createObjectURL(this.files[0])"
                            id="photo" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
