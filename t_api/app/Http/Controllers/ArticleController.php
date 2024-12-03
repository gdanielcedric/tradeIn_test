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

        // Pagination
        $perPage = $request->query('per_page', 10);
        $articles = $query->paginate($perPage);

        return response()->json($articles);
    }

    /**
     * Retourner les articles d'une catégorie spécifique.
     *
     * @param  int  $categoryId
     * @return \Illuminate\Http\Response
     */
    public function getArticlesByCategory($categoryId)
    {
        // Récupérer la catégorie par son ID
        $category = Category::find($categoryId);

        // Vérifier si la catégorie existe
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Récupérer les articles associés à cette catégorie
        $articles = $category->articles;

        // Retourner les articles associés à la catégorie
        return response()->json($articles);
    }

}
