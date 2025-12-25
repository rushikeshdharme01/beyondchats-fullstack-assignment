<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ArticleController extends Controller
{
    /**
     * Scrape the 5 oldest BeyondChats blog articles
     * and store them safely without duplication
     */
    public function scrapeAndStore()
    {
        $response = Http::get('https://beyondchats.com/blogs/');
        $html = $response->body();

        $crawler = new Crawler($html);

        // Collect all links
        $links = $crawler->filter('a')->each(function ($node) {
            return $node->attr('href');
        });

        // Filter blog URLs
        $blogLinks = array_values(array_filter($links, function ($link) {
            return $link && str_contains($link, '/blogs/');
        }));

        // Take last 5 unique blog URLs
        $oldestBlogs = array_slice(array_unique($blogLinks), -5);

        foreach ($oldestBlogs as $url) {

            // Convert relative URL to absolute
            if (str_starts_with($url, '/')) {
                $url = 'https://beyondchats.com' . $url;
            }

            // ❗ Prevent duplicate inserts
            if (Article::where('source_url', $url)->exists()) {
                continue;
            }

            $articleResponse = Http::get($url);
            $articleHtml = $articleResponse->body();

            $articleCrawler = new Crawler($articleHtml);

            /**
             * Robust title extraction
             */
            $title = '';

            // Try <h1>
            if ($articleCrawler->filter('h1')->count()) {
                $title = trim($articleCrawler->filter('h1')->first()->text());
            }

            // Fallback to <title>
            if (!$title && $articleCrawler->filter('title')->count()) {
                $title = trim($articleCrawler->filter('title')->first()->text());
            }

            if (!$title) {
                $title = 'BeyondChats Blog Article';
            }

            /**
             * Extract content
             */
            $content = $articleCrawler->filter('article')->count()
                ? trim($articleCrawler->filter('article')->text())
                : 'No content extracted';

            Article::create([
                'title' => $title,
                'content' => $content,
                'source_url' => $url,
                'source_type' => 'original',
            ]);
        }

        return response()->json([
            'message' => 'Articles scraped and stored successfully (duplicates avoided)'
        ]);
    }

    /**
     * List all articles
     */
    public function index()
    {
        return response()->json(
            Article::orderBy('created_at', 'desc')->get()
        );
    }

    /**
     * Show a single article
     */
    public function show($id)
    {
        return response()->json(
            Article::findOrFail($id)
        );
    }

    /**
     * Create article (used by AI Node service)
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // ❗ Prevent stacking "(Updated)"
        if (isset($data['title'])) {
            $data['title'] = str_contains($data['title'], '(Updated)')
                ? $data['title']
                : $data['title'] . ' (Updated)';
        }

        $article = Article::create($data);

        return response()->json($article, 201);
    }

    /**
     * Update article safely
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());

        return response()->json($article);
    }

    /**
     * Delete article
     */
    public function destroy($id)
    {
        Article::destroy($id);

        return response()->json([
            'message' => 'Article deleted'
        ]);
    }
}
