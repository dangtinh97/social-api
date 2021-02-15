<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data){
        return $this->model::create($data);
    }

    public function findFirst($column,$value){
        return $this->model::where($column,'=',$value)->first();
    }

    public function find(array $data){
        $query = $this->model::query();
        foreach ($data as $column=>$value){
            $query->where($column,$value);
        }
        return $query->get();
    }
}
