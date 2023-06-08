@extends('layouts.master')

@section('title', 'Add Deals')

@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Deals</h1>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">Add  Deals</h5>
                            @if (session()->has('add'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session()->get('add') }}
                                <button type="button" class="btn-close" data-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                            <form class="form-inline mb-3" action="{{ route('adddeals') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                          
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="floatingSelect" aria-label="State" name="sub_category_id">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}">{{ $product->name }} -- price :{{ $product->price }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="floatingSelect">Products</label>
                                                    
                                                </div>

                                                <span class="text-danger mt-1">
                                                    @error('sub_category_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="floatingPassword"
                                                        placeholder="" name="percentage">
                                                    <label for="floatingPassword">Discount Percentage</label>

                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('percentage')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            
                                            

                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">Add</button>
                                                <button type="reset" class="btn btn-secondary">Reset</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>

                            </form>


                            <!-- End Default Table Example -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection
