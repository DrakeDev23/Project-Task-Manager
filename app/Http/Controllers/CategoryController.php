<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Auth::user()->categories()->withCount('tasks')->latest()->get();

        return view('categories.index', [
            'categories' => $categories,
            'editingCategory' => null,
        ]);
    }

    public function create()
    {
        $categories = Auth::user()->categories()->withCount('tasks')->latest()->get();

        return view('categories.index', [
            'categories' => $categories,
            'editingCategory' => null,
            'showCreateForm' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->categories()->create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);

        $categories = Auth::user()->categories()->withCount('tasks')->latest()->get();

        return view('categories.index', [
            'categories' => $categories,
            'editingCategory' => $category,
            'showCreateForm' => false,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->authorizeCategory($category);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->authorizeCategory($category);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    private function authorizeCategory(Category $category): void
    {
        abort_unless($category->user_id === Auth::id(), 403);
    }
}
