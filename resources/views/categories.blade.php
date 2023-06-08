@extends('layouts.master')

@section('title', 'Categories')

@section('content')

    <main id="main" class="main">


        <div class="pagetitle">
            <h1>Categories</h1>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">Lsit of All Categories</h5>

                            <form class="form-inline mb-3" action="{{ route('addCategory') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <h5 class="card-title ">Add catgory</h5>

                                <div class="form-group mx-sm-3 mb-2">
                                    <div class="conatiner">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-control-lg" id="Catgory"
                                                    name="category" placeholder="Name category">
                                                <span class="text-danger mt-1">
                                                    @error('category')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control form-control-lg" id="formFileLg" name="image"
                                                    type="file">
                                                <span class="text-danger mt-1">
                                                    @error('image')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mb-3 mt-3">add category</button>
                                    </div>
                                </div>


                            </form>

                            @if (session()->has('delete'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session()->get('delete') }}
                                    <button type="button" class="btn-close" data-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session()->has('add'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session()->get('add') }}
                                    <button type="button" class="btn-close" data-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <!-- Default Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">See Sub Categories</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $catgory)
                                        <tr>
                                            <th>{{ $catgory->id }}</th>
                                            <td>
                                                @if ($catgory->image)
                                                    <img src="{{ asset('storage/cat_images/' . $catgory->image) }}"
                                                        width="50" height="50" class="image">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                           
                                            <td>{{ $catgory->name }}</td>
                                            <td>
                                                <a href="{{ route('listSubCategories', $catgory->id) }}"><button
                                                        type="button" class="btn btn-primary">See All</button></a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editCatgoryModal{{ $catgory->id }}">
                                                    Edit
                                                </button>
                                                <!-- Edit Catgory Modal -->
                                                <div class="modal fade" id="editCatgoryModal{{ $catgory->id }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="editCatgoryModal{{ $catgory->id }}Label"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialogs">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editCatgoryModal{{ $catgory->id }}Label">Edit
                                                                    Catgory</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-inline"
                                                                    action="{{ route('updateCategory', $catgory->id) }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group mx-sm-3 mb-2">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <input type="text"
                                                                                        class="form-control form-control-lg"
                                                                                        id="category" name="category_name"
                                                                                        value="{{ $catgory->name }}">
                                                                                        <span class="text-danger mt-1">
                                                                                            @error('category_name')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="catimage" id="catimage{{ $catgory->id}}">
                                                                                        @if ($catgory->image)
                                                                                        <input type="hidden" id="category-id" value="{{ $catgory->id }}"/>
                                                                                            <img src="{{ asset('storage/cat_images/' . $catgory->image) }}" width="200" height="200" class="image">
                                                                                            <button type="button" class="close closeButton" id="closeButtons{{ $catgory->id}}" onclick="testfunc({{ $catgory->id}})" >&times;</button>
                                                                                        @else
                                                                                            No Image
                                                                                        @endif
                                                                                    </div>
                                                                                    
                                                                                    <div class="catname" id="catname{{ $catgory->id }}" style="display: none;">
                                                                                        <input class="form-control form-control-lg" id="formFileLg" name="category_image" type="file" value="{{ $catgory->image }}">
                                                                                        <span class="text-danger mt-1">
                                                                                            @error('category_image')
                                                                                                {{ $message }}
                                                                                            @enderror
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <button type="submit"
                                                                                class="btn btn-primary mb-2 mt-2">Save</button>
                                                                        </div>



                                                                    </div>

                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </td>
                                            <td>
                                                <a href="{{ route('deleteCategory', $catgory->id) }}"><button
                                                        type="button" class="btn btn-danger">Delete</button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Default Table Example -->
                            <div class="pagination justify-content-center">
                                {{ $categories->links('vendor.pagination.bootstrap-4') }}
                            </div>
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