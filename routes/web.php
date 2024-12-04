<?php

use App\Livewire\AdminComponent;
use App\Livewire\CategoryComponent;
use App\Livewire\DavomatComponent;
use App\Livewire\PostComponent;
use Illuminate\Support\Facades\Route;


Route::get('/', AdminComponent::class);
Route::get('/category', CategoryComponent::class);
Route::get('/post', PostComponent::class);
Route::get('/davomat', DavomatComponent::class);