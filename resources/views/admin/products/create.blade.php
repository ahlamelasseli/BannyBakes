@extends('layout.app')

@section('title', 'Add New Product - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Add New Product</h1>
            <p class="text-gray-600 mt-2">Create a new product for your bakery</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Product Information</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name *
                        </label>
                        <input type="text"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:border-transparent @error('name') border-red-500 focus:ring-red-500 @else focus:ring-pink-500 @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               placeholder="e.g., Classic Chocolate Chip Cookie">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description *
                        </label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:border-transparent @error('description') border-red-500 focus:ring-red-500 @else focus:ring-pink-500 @enderror"
                                  id="description"
                                  name="description"
                                  rows="4"
                                  required
                                  placeholder="Describe your delicious cookie...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Stock Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number"
                                       class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:border-transparent @error('price') border-red-500 focus:ring-red-500 @else focus:ring-pink-500 @enderror"
                                       id="price"
                                       name="price"
                                       value="{{ old('price') }}"
                                       step="0.01"
                                       min="0"
                                       required
                                       placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Stock Quantity *
                            </label>
                            <input type="number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:border-transparent @error('stock_quantity') border-red-500 focus:ring-red-500 @else focus:ring-pink-500 @enderror"
                                   id="stock_quantity"
                                   name="stock_quantity"
                                   value="{{ old('stock_quantity') }}"
                                   min="0"
                                   required
                                   placeholder="0">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Image
                        </label>
                        <input type="file"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:border-transparent @error('image') border-red-500 focus:ring-red-500 @else focus:ring-pink-500 @enderror"
                               id="image"
                               name="image"
                               accept="image/*">
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Upload a high-quality image of your cookie. Supported formats: JPG, PNG, GIF (max 2MB)
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-between pt-6">
                        <a href="{{ route('admin.products') }}"
                           class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-8 py-2 text-white font-semibold rounded-md shadow-lg hover:shadow-xl transition duration-300 ease-in-out transform hover:scale-105"
                                style="background-color: #B9375D;">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
