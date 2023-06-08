@extends('layouts.master')

@section('title', 'Categories')

@section('content')

<main id="main" class="main">


    <div class="pagetitle">
        <h1>{{ $categoryname->name }} Category</h1>
    </div><!-- End Page Title -->

    <section class="section">

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3">Lsit of  {{ $categoryname->name }}  Categories</h5>

                        @if (session()->has('delete'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session()->get('delete') }}
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if (session()->has('add'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('add') }}
                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Category</th>
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
                                        <img src="{{ asset('storage/sub_cat_images/' . $catgory->image) }}" width="50" height="50" class="image">
                                        @else
                                        No Image
                                        @endif
                                    </td>

                                    <td>{{ $catgory->name }}</td>
                                    <th>{{ $catgory->price }}</th>

                                    <td>
                                        {{ $categoryname->name }}
                                    </td>
                                    <td>
                                        

                                        <a href="{{ route('editSubCategory', $catgory->id) }}"><button type="button" class="btn btn-primary">Edit</button></a>


                                    </td>
                                    <td>
                                        <a href="{{ route('deleteSubCategory', $catgory->id) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $categories->links('vendor.pagination.bootstrap-4') }}
                        </div>
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
