<?php

namespace Supercluster\Content;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Respect\Data\Collections\Collection;

class ArticleList implements Routable
{
    protected $collection;
    protected $singleArticleRoute;

    public function __construct(
        Collection    $collection,
        AbstractRoute $singleArticleRoute
    ) {
        $this->collection         = $collection;
        $this->singleArticleRoute = $singleArticleRoute;
    }

    public function get()
    {
        $articleList = $this->collection->fetchAll();

        foreach ($articleList as $article) {
            $article->url = $this->singleArticleRoute
                                 ->createUri($article->title);
        }

        return [ 'articleList' => $articleList ];
    }

    public function post()
    {
        return $this->get();
    }
}
