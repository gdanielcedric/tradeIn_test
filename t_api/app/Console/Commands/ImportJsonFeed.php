<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use App\Models\Article;
use App\Models\Category;

class ImportJsonFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-json-feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Charger le fichier JSON
        $jsonPath = base_path('feed.json');
        if (!File::exists($jsonPath)) {
            $this->error('Le fichier feed.json est introuvable.');
            return;
        }

        $json = File::get($jsonPath);
        $articles = json_decode($json, true); // Décoder le tableau JSON

        if (!is_array($articles)) {
            $this->error('Le fichier JSON n’est pas au format attendu.');
            return;
        }

        foreach ($articles as $item) {
            $article = Article::create([
                'title' => $item['title'],
                'slug' => $item['slug'],
                'emoji' => $item['emoji'],
                'link' => $item['@link'],
                'content' => $item['content'][0]['content'] ?? '',
                'author_slug' => $item['authors'][0]['slug'] ?? '',
                'author_avatar' => $item['authors'][0]['avatar'] ?? '',
                'featured_media' => $item['media']['media']['attributes']['url'] ?? null,
            ]);

            $categories = collect([$item['categories']['primary']])
                ->merge($item['categories']['additional'] ?? [])
                ->unique();

            foreach ($categories as $categoryName) {
                $category = Category::firstOrCreate(['name' => $categoryName]);
                $article->categories()->attach($category->id);
            }
        }

        $this->info('JSON feed imported successfully.');
    }
}
