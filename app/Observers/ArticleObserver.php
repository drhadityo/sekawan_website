<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleObserver
{
    /**
     * Handle the Article "creating" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function creating(Article $article)
    {
        $article->deleted_at = null;
        $article->contents = $this->contentDecode($article->contents);
        $article->user_id = auth()->id();
    }

    /**
     * Handle the Article "updating" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function updating(Article $article)
    {
        if ($article->isDirty('contents')) $article->contents = $this->contentDecode($article->contents);
    }

    /**
     * Handle the Article "updated" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function updated(Article $article)
    {
        if ($article->isDirty('img')) Storage::delete($article->getOriginal()['img']);
        if ($article->isDirty('contents')) $this->deleteContentImg($article->getOriginal()['contents'], $article->contents);
    }

    /**
     * Handle the Article "deleted" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        $this->deleteContentImg($article->contents);
        Storage::delete($article->img);
    }

    ## Decode contents article image then save image in storage
    private function contentDecode($contents)
    {
        while (str($contents)->contains(';base64,')) {
            $base64 = str(str($contents)->match('/<img[^>]+src="data([^">]+)/'));
            $contents = str($contents)->replace('data' . $base64, '??');
            $ext = str(str($contents)->match('/<img[^>]+src="\?\?"([^>]+)/')->explode('.')->last())->trim('"');
            $base64 = str($base64)->explode(',')[1];
            $img = base64_decode(str($base64));
            do {
                $imgName = 'img/articles/contents/' . Str::random(80) . '.' . $ext;
                $status = Storage::get($imgName);
            } while ($status);
            $status = Storage::put($imgName, $img);
            $contents = str($contents)->replace('??', asset('storage/' . $imgName));
        }

        return $contents;
    }

    private function isContainImg($contents)
    {
        return str($contents)->contains(asset('storage/img/articles/contents/'));
    }

    private function getImgSrc($contents)
    {
        return str($contents)->matchAll('/<img[^>]+src="([^">]+)/')->map(fn ($src) => str($src)->remove(asset('storage/')));
    }

    private function deleteContentImg($contents, $exclude = null)
    {
        if ($exclude) $exclude = $this->getImgSrc($exclude);
        if ($this->isContainImg($contents))
            $this->getImgSrc($contents)->each(fn ($src) => str($src)->contains($exclude) ? '' : Storage::delete($src));
    }
}
