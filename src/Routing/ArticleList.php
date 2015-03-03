<?php

namespace Supercluster\Content\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Respect\Data\Collections\Collection;

class ArticleList implements Routable
{
    protected $collection;
    protected $singleArticleRoute;
    protected $validator;

    public function __construct(
        Collection    $collection,
        AbstractRoute $singleArticleRoute,
        callable      $validator
    ) {
        $this->collection         = $collection;
        $this->singleArticleRoute = $singleArticleRoute;
        $this->validator          = $validator;
    }

    public function get()
    {
        $articleList = $this->collection->fetchAll();

        foreach ($articleList as $article) {
            $article->url = $this->singleArticleRoute
                                 ->createUri($article->id);
        }

        return [ 'articleList' => $articleList ];
    }

    public function post()
    {
        if (!call_user_func($this->validator, $_POST)) {
            return [
                'error' => [
                    'code' => 400, 'message' => 'Invalid data.'
                ]
            ];
        }

        $newArticle = (object) (['id' => null] + $_POST);
        $this->collection->persist($newArticle);
        $this->collection->flush();

        return [
            'location'      => $this->singleArticleRoute
                                    ->createUri($newArticle->id),
            'singleArticle' => $newArticle
        ];
    }
}
