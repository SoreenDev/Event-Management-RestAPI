<?php
namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
trait CanLoadRelationship
{
    public function LoadRelationship(
        Model | QueryBuilder |EloquentBuilder $for,
        ?array $relations = null
    ) : Model | QueryBuilder |EloquentBuilder
    {

        $relations = $relations ?? $this->relations ?? [];
        foreach ($relations as $relation)
        {
            $for->when(
                $this->shoudIncludeRelation($relation),
                fn($q)=> $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }
        return $for;
    }
    protected function shoudIncludeRelation($relation):bool
    {
        $include = Request()->query('include');
        if( !$include) {
            return false;
        }
        $relations = array_map('trim',explode(',',$include));
        return in_array($relation , $relations);

    }
}
