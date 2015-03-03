<?php

namespace Supercluster\Content\Routing;

use Respect\Rest\Routable;
use Respect\Rest\Routes\AbstractRoute;
use Respect\Data\Collections\Collection;

class SingleArticle implements Routable
{
    protected $collection;
    protected $validator;

    public function __construct(Collection $collection, callable $validator)
    {
        $this->collection = $collection;
        $this->validator  = $validator;
    }

    public function get($articleId)
    {
        $article = $this->collection[$articleId]->fetch() ?: new \stdClass;

        return [ 'singleArticle' => $article ];
    }


    public function post($articleId)
    {
        $article = $this->collection[$articleId]->fetch();

        if (!$article || !call_user_func($this->validator, $_POST)) {
            return [
                'error' => [
                    'code' => 400, 'message' => 'Invalid data.'
                ]
            ];
        }

        foreach ($_POST as $postKey => $postValue) {
            $article->$postKey = $postValue;
        }

        $this->collection->persist($article);
        $this->collection->flush();

        return [
            'singleArticle' => $article
        ];
    }
}
