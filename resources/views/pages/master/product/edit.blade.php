@extends('layouts.app')

@section('title', 'Edit Product')

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
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category_id" id="category" class="form-select">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="end_price">Photo Before</label>
                        <div>
                            <img src="{{ asset($product->photo_path) }}" id="image-product" class="img-fluid"
                                alt="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control" id="photo"
                            onchange="document.getElementById('image-product').src = window.URL.createObjectURL(this.files[0])"
                            name="photo">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
