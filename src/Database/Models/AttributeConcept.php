<?php

declare(strict_types=1);

namespace LaraStrict\Database\Models;

use Illuminate\Database\Eloquent\Model;
use LaraStrict\Database\Attributes\StringAttribute;

class AttributeConcept extends Model
{
    public static function name(): StringAttribute
    {
        // TODO: try to get $this if this method was called from object context
        return new StringAttribute();
    }

    public static function name2(Model $model = null): StringAttribute
    {
        return new StringAttribute($model);
    }
}
/*
 * 
$type = new AttributeConcept();

$test = $type->name()->get();

// Not preffered :(
$test2 = $type->name2($type)->get();

$attributeNameUsedStatically = AttributeConcept::name()->name; // or __toString?
 */
