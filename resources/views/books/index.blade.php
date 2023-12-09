@extends('layouts.app')

@section('content')
    <h1 class="text-2x1">Books</h1>
    
    <form method="GET" action="{{ route('books.index') }}" class="mb-4">
        <div class="grid grid-cols-5 gap-4">
            <input class="col-span-4" type="text" name="title" placeholder="Search for a book"
            value="{{ request('title') }}" />
            <input type="hidden" value="{{ request('filter') }}" name="filter" />
            <button class="col-span-1 bg-green-500" type="submit">Search</button>
        </div>
    </form>

    <div class="filter-container flex">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Months',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6months' => 'Highest Rated Last 6 Months'
            ];
        @endphp

        @foreach($filters as $key => $label)
            <a href="{{ route('books.index', ['filter'=>$key, 'title'=>request('title')]) }}" class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <ul>
        @forelse($books as $book)
            <li class="flex flex-wrap items-center justify-between w-full mt-5 border border-gray-200 p-2 rounded-md">
                <div class="w-full flex-grow sm:w-auto">
                    <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                    <div>by {{ $book->author }}</div>
                </div>

                <div>
                    <div class="book-rating">Avg Review {{ number_format($book->reviews_avg_rating, 1) }}</div> 
                    <div class="book-review-count">out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}</div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div  class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
                
            </li>
        @endforelse
    </ul>

@endsection