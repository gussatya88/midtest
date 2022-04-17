@extends('layouts.app')

@section('title', 'Package')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#package-table').DataTable();
            $('.product-select').select2({
                placeholder: 'Select Products',
                theme: 'bootstrap-5',
                multiple: true,
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Add Package
                </button>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped" id="package-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Normal Price</th>
                            <th>End Price</th>
                            <th>Product</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $key => $package)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $package->name }}</td>
                                <td>{{ $package->normal_price }}</td>
                                <td>{{ $package->end_price }}</td>
                                @if ($package->products->isNotEmpty())
                                    <td>{{ $package->products->implode('name', ',') }}</td>
                                @else
                                    <td>No Product</td>
                                @endif
                                <td>
                                    {{-- <div class="d-flex flex-column align-items-center"> --}}
                                    <a href="{{ route('package.addProduct', $package->id) }}"
                                        class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></a>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#imageModal{{ $package->id }}">
                                        <i class="fa-solid fa-image"></i></button>
                                    <a href="{{ route('package.edit', $package->id) }}" class="btn btn-info btn-sm"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                    <form action="{{ route('package.destroy', $package->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash"></i></button>
                                    </form>
                                    {{-- </div> --}}
                                </td>
                            </tr>

                            {{-- Image modal --}}
                            <div class="modal fade" id="imageModal{{ $package->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Image Package</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="{{ $package->photo_path }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('package.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="name">Normal Price</label>
                            <input type="number" class="form-control" name="normal_price">
                        </div>
                        <div class="form-group">
                            <label for="name">End Price</label>
                            <input type="number" class="form-control" name="end_price">
                        </div>
                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
