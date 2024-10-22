<?php declare( strict_types = 1 );
namespace App\Model;

use System\Core\Database\Voile\Model;
use Zpheur\Databases\Voile\Schema\{ Collection, Field };
use Zpheur\Databases\Voile\Schema\AbstractionType as Type;
use MongoDB\BSON\{ ObjectId, UTCDateTime, Decimal128, Regex };
use stdClass, DateTime, Exception;

#[Collection('BlogPosts')]
class BlogPosts extends Model
{   
    #[Field(default: null)]
    protected Type\AObjectId|ObjectId|string|null
    $_id;

    #[Field(default: null)]
    protected Type\AString|string|null
    $title;

    #[Field(default: null)]
    protected Type\AString|string|null
    $slug;

    #[Field(default: null)]
    protected Type\ANumber|int|null
    $views;

    #[Field(default: null)]
    protected Type\AString|string|null
    $post;
};