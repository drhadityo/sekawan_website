<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index'        => 'viewAny',
            'show'         => 'view',
            'create'       => 'create',
            'store'        => 'create',
            'edit'         => 'update',
            'update'       => 'update',
            'destroy'      => 'delete',
            'restore'      => 'restore',
            'forceDelete'  => 'forceDelete',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = request()->segments()[1];
        if ($category == "infos") {
            $articles = Article::latest()->category(1);
            $title = 'Info TBC';
            $createRoute = 'admin.infotbc.create';
            $showRoute = 'admin.infotbc.show';
            $editRoute = 'admin.infotbc.edit';
        } else if ($category == "articles") {
            $articles = Article::latest()->category(2);
            $title = 'Artikel';
            $createRoute = 'admin.articles.create';
            $showRoute = 'admin.articles.show';
            $editRoute = 'admin.articles.edit';
        } else if ($category == "actions") {
            $articles = Article::latest()->category(3);
            $title = 'Kegiatan';
            $createRoute = 'admin.kegiatan.create';
            $showRoute = 'admin.kegiatan.show';
            $editRoute = 'admin.kegiatan.edit';
        } else {
            abort(404);
        };

        if (!auth()->user()->role) $articles->user();
        $articles = $articles->get();
        if (request()->ajax()) {
            return json_encode(['articles' => $articles]);
        }
        return view('admin.article.index', [
            'title' => $title,
            'articles' => $articles,
            'createRoute' => $createRoute,
            'showRoute' => $showRoute,
            'editRoute' => $editRoute
        ]);
    }

    public function trashed($path)
    {
        $this->authorize('superAdmin');
        $articles = match ($path) {
            'infos' => Article::onlyTrashed()->category(1)->get(),
            'articles' => Article::onlyTrashed()->category(2)->get(),
            'actions' => Article::onlyTrashed()->category(3)->get(),
        };
        return json_encode(['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = request()->segments()[1];
        if ($category == "infos") {
            $category = 1;
            $title = 'Info TBC';
        } else if ($category == "articles") {
            $category = 2;
            $title = 'Artikel';
        } else if ($category == "actions") {
            $category = 3;
            $title = 'Kegiatan';
        } else {
            abort(404);
        }

        return view('admin.article.create', [
            'category' => $category,
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $request = $request->validated();
        $request['img'] = $request['img']->store('img/articles');
        $route = match ($request['category_id']) {
            '1' => 'admin.infotbc.show',
            '2' => 'admin.articles.show',
            '3' => 'admin.kegiatan.show'
        };
        $article = Article::create($request);
        if (!$article) Storage::delete($request['img']);
        return to_route($route, $article)->withSuccess('Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        if (request()->routeIs('admin.infotbc.show')) {
            $editRoute = 'admin.infotbc.edit';
            $indexRoute = 'admin.infotbc.index';
        } else if (request()->routeIs('admin.articles.show')) {
            $editRoute = 'admin.articles.edit';
            $indexRoute = 'admin.articles.index';
        } else if (request()->routeIs('admin.kegiatan.show')) {
            $editRoute = 'admin.kegiatan.edit';
            $indexRoute = 'admin.kegiatan.index';
        } else {
            abort(404);
        }
        return view('admin.article.show', compact('article', 'editRoute', 'indexRoute'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        match ($article->category_id) {
            1   => [$title = 'Info TBC',    $route = 'admin.infotbc.update'],
            2   => [$title = 'Artikel',     $route = 'admin.articles.update'],
            3   => [$title = 'Kegiatan',    $route = 'admin.kegiatan.update'],
            default     => abort(404)
        };
        return view('admin.article.edit', compact('article', 'title', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $validated = $request->validated();
        if (isset($validated['img'])) $validated['img'] = $validated['img']->store('img/articles');
        $article->update($validated);

        $category = (request()->segments()[1]);
        $category == "infos" ? $route = 'admin.infotbc.show'
            : ($category == "articles" ? $route = 'admin.articles.show'
                : ($category == "actions" ? $route = 'admin.kegiatan.show' : $route = null));

        return to_route($route, $article)->withSuccess('Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        activity()->disableLogging();
        $article->delete();
        activity()->enableLogging();
        return $article->wasChanged();
    }

    public function restore(Article $article)
    {
        activity()->disableLogging();
        if ($article->trashed()) $article->restore();
        activity()->enableLogging();
        return $article->wasChanged();
    }

    public function forceDelete(Article $article)
    {
        return $article->forceDelete();
    }
}
