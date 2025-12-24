<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ArticleController extends Controller
{
    public function scrapeAndStore()
    {
        $response = Http::get('https://beyondchats.com/blogs/');
        $html = $response->body();

        $crawler = new Crawler($html);

        // Fetch all blog links
        $links = $crawler->filter('a')->each(function ($node) {
            return $node->attr('href');
        });

        // Filter blog URLs only
        $blogLinks = array_values(array_filter($links, function ($link) {
            return $link && str_contains($link, '/blogs/');
        }));

        // Take last 5 (oldest)
        $oldestBlogs = array_slice(array_unique($blogLinks), -5);

        foreach ($oldestBlogs as $url) {

    // Convert relative URL to full URL
    if (str_starts_with($url, '/')) {
        $url = 'https://beyondchats.com' . $url;
    }

    $articleResponse = Http::get($url);

            $articleHtml = $articleResponse->body();
            $articleCrawler = new Crawler($articleHtml);

            $title = $articleCrawler->filter('h1')->first()->text('');
            $content = $articleCrawler->filter('article')->text('');

            Article::create([
                'title' => $title ?: 'Untitled',
                'content' => $content ?: 'No content extracted',
                'source_url' => $url,
                'source_type' => 'original',
            ]);
        }

        return response()->json([
            'message' => 'Oldest articles scraped and stored successfully'
        ]);

        

    }


    // Get all articles
public function index()
{
    return response()->json(Article::orderBy('created_at', 'desc')->get());
}

// Get single article
public function show($id)
{
    return response()->json(Article::findOrFail($id));
}

// Create article
public function store(Request $request)
{
    $article = Article::create($request->all());
    return response()->json($article, 201);
}

// Update article
public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);
    $article->update($request->all());
    return response()->json($article);
}

// Delete article
public function destroy($id)
{
    Article::destroy($id);
    return response()->json(['message' => 'Article deleted']);
}



}


