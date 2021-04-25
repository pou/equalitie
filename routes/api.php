<?php

use App\Http\Resources\DocumentCollection;
use App\Models\Document;
use App\Http\Resources\Document as DocumentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::put('/documents', function (Request $request) {
    $document = Document::create([
        'title' => '',
        'author' => '',
    ]);

    return new DocumentCollection(Document::all());
});

Route::get('/documents', function (Request $request) {
    return new DocumentCollection(Document::all());
});

Route::get('/document/{id}', function (Request $request, int $id) {
    $document = Document::find($id);
    if ($document === null) {
        abort(404);
    }

    return new DocumentResource($document);
});
