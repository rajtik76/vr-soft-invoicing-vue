<?php

declare(strict_types=1);

namespace App\Services;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Pipeline;
use JsonSerializable;

class GridComponentHandler implements JsonSerializable
{
    protected int $page;
    protected int $perPage = 10;
    protected array $sort = [];
    protected array $filter = [];
    protected string|null $search;
    protected Builder $builder;
    protected string|null $resource = null;
    protected array $sortClosure = [];
    protected array $searchClosure = [];
    protected array $filterClosure = [];

    public function __construct(protected Request $request)
    {
    }

    /**
     * @param string $resource
     * @return GridComponentHandler
     */
    public function setResource(string $resource): GridComponentHandler
    {
        $this->resource = $resource;

        return $this;
    }

    public function setBuilder(Builder $builder): GridComponentHandler
    {
        $this->builder = $builder;

        return $this;
    }

    public function setSortClosure(string $column, Closure $closure): GridComponentHandler
    {
        $this->sortClosure[$column] = $closure;

        return $this;
    }

    public function setSearchClosure(string $column, Closure $closure): GridComponentHandler
    {
        $this->searchClosure[$column] = $closure;

        return $this;
    }

    public function setFilterClosure(string $column, Closure $closure): GridComponentHandler
    {
        $this->filterClosure[$column] = $closure;

        return $this;
    }


    public function jsonSerialize(): array
    {
        // store data from request
        $this->page = intval(request()->get('page', 1));
        $this->perPage = intval(request()->get('perPage', 15));
        $this->sort = request()->get('sort', []);
        $this->filter = request()->get('filter', []);
        $this->search = request()->get('search');

        $this->builder = Pipeline::send($this->builder)->through([
            // Sort
            function (Builder $builder, Closure $next) {
                if ($this->sort) {
                    collect($this->sort)->each(
                        fn (string $order, string $column) => Arr::has($this->sortClosure, $column)
                            ? call_user_func_array($this->sortClosure[$column], ['builder' => $builder, 'order' => $order])
                            : $builder->orderBy($column, $order)
                    );
                }

                return $next($builder);
            },
            // Search
            function (Builder $builder, Closure $next) {
                if ($this->searchClosure && $this->search) {
                    collect($this->searchClosure)->each(fn (Closure $sort, string $column) => call_user_func_array($sort, ['search' => $this->search, 'builder' => $builder]));
                }

                return $next($builder);
            },
            // Filter
            function (Builder $builder, Closure $next) {
                if ($this->filter) {
                    collect($this->filter)
                        ->filter(
                            fn ($filter) => !(is_null($filter) || $filter === '')
                        )
                        ->each(
                            fn (string $value, string $column) => Arr::has($this->filterClosure, $column)
                                ? call_user_func_array($this->filterClosure[$column], ['builder' => $builder, 'value' => $value])
                                : $builder->where($column, $value)
                        );
                }

                return $next($builder);
            },
        ])->thenReturn();

        // get paginator and set current page + per page
        $paginator = $this->builder->paginate(perPage: $this->perPage, page: $this->page);
        $output = $paginator->toArray();

        // wrap data with Json resource otherwise return raw data
        if ($this->resource) {
            Arr::set($output, 'data', $this->resource::collection($paginator));
        }

        return $output;
    }
}
