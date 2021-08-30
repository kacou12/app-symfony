<?php

namespace App\Factory;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Categorie|Proxy createOne(array $attributes = [])
 * @method static Categorie[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Categorie|Proxy find($criteria)
 * @method static Categorie|Proxy findOrCreate(array $attributes)
 * @method static Categorie|Proxy first(string $sortedField = 'id')
 * @method static Categorie|Proxy last(string $sortedField = 'id')
 * @method static Categorie|Proxy random(array $attributes = [])
 * @method static Categorie|Proxy randomOrCreate(array $attributes = [])
 * @method static Categorie[]|Proxy[] all()
 * @method static Categorie[]|Proxy[] findBy(array $attributes)
 * @method static Categorie[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Categorie[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CategorieRepository|RepositoryProxy repository()
 * @method Categorie|Proxy create($attributes = [])
 */
final class CategorieFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        $test = self::faker()->text();
        return [
            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
            'libelle' => self::faker()->name(),
            'image' => self::faker()->imageUrl($width = 640, $height = 480),
            // 'slug' => self::faker()->text(),
            // 'createdAt' => null, // TODO add DATETIME ORM type manually
            // 'updatedAt' => null, // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Categorie $categorie) {})
        ;
    }

    protected static function getClass(): string
    {
        return Categorie::class;
    }
}
