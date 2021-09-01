<?php

namespace App\Factory;

use App\Entity\CommentVideo;
use App\Repository\CommentVideoRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static CommentVideo|Proxy createOne(array $attributes = [])
 * @method static CommentVideo[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static CommentVideo|Proxy find($criteria)
 * @method static CommentVideo|Proxy findOrCreate(array $attributes)
 * @method static CommentVideo|Proxy first(string $sortedField = 'id')
 * @method static CommentVideo|Proxy last(string $sortedField = 'id')
 * @method static CommentVideo|Proxy random(array $attributes = [])
 * @method static CommentVideo|Proxy randomOrCreate(array $attributes = [])
 * @method static CommentVideo[]|Proxy[] all()
 * @method static CommentVideo[]|Proxy[] findBy(array $attributes)
 * @method static CommentVideo[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CommentVideo[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CommentVideoRepository|RepositoryProxy repository()
 * @method CommentVideo|Proxy create($attributes = [])
 */
final class CommentVideoFactory extends ModelFactory
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
            // ->afterInstantiate(function(CommentVideo $commentVideo) {})
        ;
    }

    protected static function getClass(): string
    {
        return CommentVideo::class;
    }
}