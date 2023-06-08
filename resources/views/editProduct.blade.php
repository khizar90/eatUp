@extends('layouts.master')

@section('title', 'Edit Sub Categories')

@section('content')


    <main id="main" class="main">


        <div class="pagetitle">
            <h1>Edit Category</h1>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('listSubCategories', $subcat->category_id) }}"><button type="button" class="btn btn-primary mt-3">back</button></a>

                            <h5 class="card-title text-center mb-3">Edit Sub Categories</h5>
                            @if (session()->has('add'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session()->get('add') }}
                                <button type="button" class="btn-close" data-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                            <form class="form-inline mb-3" action="{{ route('updateSubCategory') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value={{ $subcat->id }}>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-6">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="floatingName"
                                                        placeholder="" name="name" value="{{ $subcat->name }}">
                                                    <label for="floatingName">Sub Category Name</label>

                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('name')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="floatingSelect" aria-label="State" name="category_id" value="{{ $subcat->category_id }}">
                                                        @foreach ($categories as $category)
                                                            <option  {{ isset($subcat->category_id) && $subcat->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
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
                                                        placeholder="" name="price" value="{{ $subcat->price }}">
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
                                                        placeholder="" name="time" value="{{ $subcat->time }}">
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
                                                    <textarea class="form-control" id="floatingTextarea" name="discription" style="height: 100px;">{{ $subcat->discription }}</textarea>
                                                    <label for="floatingTextarea">Discription</label>
                                                </div>
                                                <span class="text-danger mt-1">
                                                    @error('discription')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="catimage" id="catimage{{ $subcat->id}}">
                                                    @if ($subcat->image)
                                                    <input type="hidden" id="category-id" value="{{ $subcat->id }}"/>
                                                        <img src="{{ asset('storage/sub_cat_images/' . $subcat->image) }}" width="200" height="200" class="image">
                                                        <button type="button" class="close closeButton" id="closeButtons{{ $subcat->id}}" onclick="testfunc({{ $subcat->id}})" >&times;</button>
                                                    @else
                                                        No Image
                                                    @endif
                                                </div>
                                                
                                                <div class="catname mb-5" id="catname{{ $subcat->id }}" style="display: none;">
                                                    <input class="form-control form-control-lg" id="formFileLg" name="category_image" type="file" value="{{ $subcat->image }}">
                                                    <span class="text-danger mt-1">
                                                        @error('category_image')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-12 mb-4">
                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="file" name="image" value="{{ $subcat->rupees }}" class="form-control" id="floatingCity"
                                                            placeholder="">
                                                        <label for="floatingCity">image</label>

                                                    </div>
                                                    <span class="text-danger mt-1">
                                                        @error('image')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div> --}}
                                            

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
@section('script')
<script>
    // $(document).ready(function() {
    //     var id = $('#category-id').val();
    //     $("#closeButton"+id).click(function() {
    //         console.log('hi');
    //         $("#catimage").hide();
    //         $("#catname").show();
    //     });
    // });
    function testfunc(id){
        console.log("Hiee");
        console.log(id);
        $("#catimage"+id).hide();
        $("#catname"+id).show();
    }
</script>
@endsection