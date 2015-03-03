<?php

namespace Supercluster\Content;

use Respect\Rest\Routable;
use Respect\Data\Collections\Collection;

class SingleArticle implements Routable
{
    protected $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function get($articleId)
    {
        $article = $this->collection->fetch() ?: new \stdClass;

        return [ 'singleArticle' => $article ];
    }

    public function post($articleId)
    {
        return $this->get($articleId);
    }
}
