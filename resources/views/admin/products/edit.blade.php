@extends('layout.app')

@section('title', 'Edit Product - Admin')

@section('content')
<div class="min-h-screen py-8" style="background-color: #EEEEEE;">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold" style="color: #B9375D;">Edit Product</h1>
                    <p class="text-gray-600 mt-2">Update {{ $product->name }} information</p>
                </div>
                <a href="{{ route('admin.products') }}"
                   class="px-6 py-3 text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out shadow-lg"
                   style="background-color: #B9375D;">
                    ← Back to Products
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-2xl border-2 overflow-hidden" style="border-color: #E7D3D3;">
            <div class="px-8 py-6 border-b-2" style="background-color: #B9375D; border-color: #E7D3D3;">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    Product Information
                </h2>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')

                    <!-- Product Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-lg font-semibold" style="color: #B9375D;">
                            Product Name *
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $product->name) }}"
                               required
                               class="w-full px-4 py-3 text-lg border-2 rounded-lg transition-all duration-200 focus:outline-none @error('name') border-red-500 @else border-gray-300 @enderror"
                               style="focus:border-color: #B9375D;"
                               placeholder="Enter delicious cookie name...">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-lg font-semibold" style="color: #B9375D;">
                            Description *
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="4"
                                  required
                                  class="w-full px-4 py-3 text-lg border-2 rounded-lg transition-all duration-200 focus:outline-none resize-none @error('description') border-red-500 @else border-gray-300 @enderror"
                                  style="focus:border-color: #B9375D;"
                                  placeholder="Describe your delicious cookie...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="price" class="block text-lg font-semibold" style="color: #B9375D;">
                                Price *
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-xl font-bold text-gray-500">$</span>
                                <input type="number"
                                       id="price"
                                       name="price"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       min="0"
                                       required
                                       class="w-full pl-10 pr-4 py-3 text-lg border-2 rounded-lg transition-all duration-200 focus:outline-none @error('price') border-red-500 @else border-gray-300 @enderror"
                                       style="focus:border-color: #B9375D;"
                                       placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div class="space-y-2">
                            <label for="stock_quantity" class="block text-lg font-semibold" style="color: #B9375D;">
                                Stock Quantity *
                            </label>
                            <input type="number"
                                   id="stock_quantity"
                                   name="stock_quantity"
                                   value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                   min="0"
                                   required
                                   class="w-full px-4 py-3 text-lg border-2 rounded-lg transition-all duration-200 focus:outline-none @error('stock_quantity') border-red-500 @else border-gray-300 @enderror"
                                   style="focus:border-color: #B9375D;"
                                   placeholder="0">
                            @error('stock_quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Image Upload -->
                    <div class="space-y-4">
                        <label for="image" class="block text-lg font-semibold" style="color: #B9375D;">
                            {{ $product->image ? 'Change Image' : 'Add Image' }}
                        </label>
                        <div class="relative">
                            <input type="file"
                                   id="image"
                                   name="image"
                                   accept="image/*"
                                   class="w-full px-4 py-3 text-lg border-2 border-dashed rounded-lg transition-all duration-200 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:text-white hover:border-pink-400 @error('image') border-red-500 @else border-gray-300 @enderror"
                                   style="file:background-color: #B9375D; focus:border-color: #B9375D;">
                        </div>
                    </div>


                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row justify-between items-center  space-y-4 sm:space-y-0 sm:space-x-6 pt-8 border-t-2" style="border-color: #E7D3D3;">
                        <a href="{{ route('admin.products') }}"
                           class="w-full sm:w-auto px-8 py-4 text-lg font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150 ease-in-out text-center">
                            ← Cancel
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-12 py-4 text-lg font-bold text-white rounded-lg hover:opacity-90 transition duration-150 ease-in-out shadow-lg transform hover:scale-105"
                                style="background-color: #B9375D;">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Focus Styles -->
<style>
    input:focus, textarea:focus, select:focus {
        border-color: #B9375D !important;
        box-shadow: 0 0 0 3px rgba(185, 55, 93, 0.1) !important;
    }

    .file-upload-area {
        background: linear-gradient(135deg, #EEEEEE 0%, #E7D3D3 100%);
    }

    .file-upload-area:hover {
        background: linear-gradient(135deg, #E7D3D3 0%, #D25D5D 100%);
    }
</style>
@endsection
