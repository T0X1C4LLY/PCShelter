<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View|Application
    {
        return view('reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Review  $review
     */
    public function show(Review $review): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Review  $review
     */
    public function edit(Review $review): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Review  $review
     */
    public function update(Request $request, Review $review): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Review  $review
     */
    public function destroy(Review $review): void
    {
        //
    }
}
