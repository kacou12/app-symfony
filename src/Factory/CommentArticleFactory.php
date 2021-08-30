<?php

namespace App\Factory;

use App\Entity\CommentArticle;
use App\Repository\CommentArticleRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static CommentArticle|Proxy createOne(array $attributes = [])
 * @method static CommentArticle[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static CommentArticle|Proxy find($criteria)
 * @method static CommentArticle|Proxy findOrCreate(array $attributes)
 * @method static CommentArticle|Proxy first(string $sortedField = 'id')
 * @method static CommentArticle|Proxy last(string $sortedField = 'id')
 * @method static CommentArticle|Proxy random(array $attributes = [])
 * @method static CommentArticle|Proxy randomOrCreate(array $attributes = [])
 * @method static CommentArticle[]|Proxy[] all()
 * @method static CommentArticle[]|Proxy[] findBy(array $attributes)
 * @method static CommentArticle[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CommentArticle[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CommentArticleRepository|RepositoryProxy repository()
 * @method CommentArticle|Proxy create($attributes = [])
 */
final class CommentArticleFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            'message' => self::faker()->text(),
            'author' => self::faker()->name(),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(CommentArticle $commentArticle) {})
        ;
    }

    protected static function getClass(): string
    {
        return CommentArticle::class;
    }
}
