<?php

namespace App\Http\Controllers;
use App\Models\Category as CategoryModel;

use Illuminate\Http\Request;

class Category extends Controller
{
    public function addCat(Request $request){
    $request->validate([
         'category' => 'required|string|max:255',
    ]);

    try {
        CategoryModel::create([
            'category' => $request->category,
        ]);

        return redirect(URL('admin/category'))->with('success', 'Added Successfully');

    } catch (\Illuminate\Database\QueryException $e) {
        // Check for duplicate entry error (MySQL error code 1062)
        if($e->errorInfo[1] == 1062){
            return redirect(URL('admin/category'))->with('error', 'This category already exists!');
        }

        // Any other database error
        return redirect(URL('admin/category'))->with('error', 'Something went wrong!');
        }
    }

    public function getAllCategories(){
        $categories = CategoryModel::all();

        return view('admin.category', compact('categories'));
    }

    public function editCat(Request $request){
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        try {
            $category = CategoryModel::findOrFail($request->id);
            $category->update(['category' => $request->category]);

            return redirect(URL('admin/category'))->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return redirect(URL('admin/category'))->with('error', 'Something went wrong!');
        }
    } 
   public function delete($id)
{
    $category = CategoryModel::find($id);

    if(!$category){
        return response()->json(['error' => 'Category not found'], 404);
    }

    $category->delete();

    // Return a JSON response
    return response()->json(['success' => true]);
}

}
