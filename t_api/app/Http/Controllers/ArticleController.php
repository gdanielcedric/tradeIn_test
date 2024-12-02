<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Recherche par mot-clé
        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        // Filtrage par catégorie
        //if ($request->has('category')) {
            //$category = $request->query('category');
            //$query->where('category', $category);
        //}

        // Pagination
        $perPage = $request->query('per_page', 10);
        $articles = $query->paginate($perPage);

        return response()->json($articles);
    }

}
