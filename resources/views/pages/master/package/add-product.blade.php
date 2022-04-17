@extends('layouts.app')

@section('title', 'Add Product to Package')


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
            $('#product_id').select2({
                placeholder: {
                    id: '-1',
                    text: 'Select Products'
                },
                allowClear: true,
                theme: 'bootstrap-5'
            });


            // select change check if empty hide quantity form
            $('#product_id').on('change', function() {
                if ($(this).val() == '') {
                    $('#quantity').val('');
                    // $('#quantity').attr('disabled', true);
                    $('#field-quantity').css('display', 'none');
                } else {
                    $('#field-quantity').css('display', 'block');
                    // $('#quantity').attr('disabled', false);
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    + Add Product
                </button>
                <a href="{{ route('package.index') }}" class="btn btn-secondary">Back</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <table class="table table-bordered table-striped" id="package-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($package->products as $key => $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td>
                                        <form action="{{ route('package.deleteProduct', $package->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="id_product" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add --}}
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
                    <form action="{{ route('package.addProduct', $package->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">Product</label>
                            <select name="product_id" id="product_id" class="form-control product-select">
                                @foreach ($products as $key => $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="field-quantity">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
