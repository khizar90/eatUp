@extends('layouts.master')

@section('title', 'Add Product')

@section('content')

    <main id="main" class="main">


        <div class="pagetitle">
            <h1>Add Product</h1>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">Add Product</h5>
                            @if (session()->has('add'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session()->get('add') }}
                                <button type="button" class="btn-close" data-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                            <form class="form-inline mb-3" action="{{ route('addSubCategories') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="floatingName"
                                                        placeholder="" name="name">
                                                    <label for="floatingName">Product Name</label>

                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="floatingSelect" aria-label="State" name="category_id">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="floatingSelect">Category</label>
                                                    
                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('category_id')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="floatingPassword"
                                                        placeholder="" name="price">
                                                    <label for="floatingPassword">Price</label>

                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('price')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>

                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="floatingPassword"
                                                        placeholder="" name="time">
                                                    <label for="floatingPassword">Time</label>

                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('time')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            
                                            <div class="col-12 mb-4">
                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="" id="floatingTextarea" name="discription" style="height: 100px;"></textarea>
                                                    <label for="floatingTextarea">Discription</label>
                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('discription')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>

                                            <div class="col-md-12 mb-4">
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="file" name="image" class="form-control" id="floatingCity"
                                                            placeholder="">
                                                        <label for="floatingCity">image</label>

                                                    </div>
                                                    <span class="text-danger mt-1">
                                                        @error('image')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
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
