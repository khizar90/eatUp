@extends('layouts.master')

@section('title', 'Categories')

@section('content')

    <main id="main" class="main">

        {{-- @php
            var_dump($categories);
            exit();
        @endphp --}}

        <div class="pagetitle">
            <h1>Deals</h1>
        </div><!-- End Page Title -->

        <section class="section">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">Lsit of Deals</h5>

                            @if (session()->has('delete'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session()->get('delete') }}
                                    <button type="button" class="btn-close" data-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session()->has('edit'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session()->get('edit') }}
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
                                        <th scope="col">Original Price</th>
                                        <th scope="col">Discount Percentage</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i =1;
                                    @endphp
                                    @foreach ($categories as $catgory)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <td>
                                                @if ($catgory->product->image )
                                                    <img src="{{ asset('storage/sub_cat_images/' . $catgory->product->image) }}"
                                                        width="50" height="50" class="image">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td>{{ $catgory->product->name ?? 'no name' }}</td>
                                            <td>{{ $catgory->product->price ?? 'no price' }}</td>

                                            <td>{{ $catgory->discount_percentage  ?? 'no old'}} %</td>



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
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editCatgoryModal{{ $catgory->id }}Label">Edit
                                                                    Discount Percentage</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-inline"
                                                                    action="{{ route('updateDeals', $catgory->id) }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group mx-sm-3 mb-2">
                                                                        <div class="container">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text"
                                                                                        class="form-control form-control-lg"
                                                                                        id="category" name="percentage"
                                                                                        value="{{ $catgory->discount_percentage }}">
                                                                                    <span class="text-danger mt-1">
                                                                                        @error('percentage')
                                                                                            {{ $message }}
                                                                                        @enderror
                                                                                    </span>
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
                                                <a href="{{ route('deleteDeal', $catgory->id) }}"><button type="button"
                                                        class="btn btn-danger">Delete</button></a>
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
