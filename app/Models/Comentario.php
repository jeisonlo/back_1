<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Comentario extends Model
{

    use HasFactory;
    protected $fillable = [
        'comentario','fechacreacion','libro_id'  ];

         // Definición de listas blancas para consultas
    protected $allowIncluded = ['libro','libro.user','libro.categorialibro','user','user.calificacion','user.libros','libro.calificacions','libro.promediocalificacion']; // Ejemplo de posibles relaciones
    protected $allowFilter = ['id', 'comentario','fechacreacion'];
    protected $allowSort = ['id', 'comentario','fechacreacion'];



    public function user (){
        return $this->belongsTo('App\Models\user');
    }


    public function libro (){
        return $this->belongsTo('App\Models\libro');
    }
    // Scope para manejar relaciones incluidas
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
     
        //http://api.codersfree.com/v1/comentarios?included=libros
        //http://api.codersfree.com/v1/comentarios?included=libro.calificacions
    }

    // Scope para manejar filtros
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }

        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
                
            }
        }
        //http://api.codersfree.com/v1/comentarios?filter[Comentario]=bueno
        //http://api.codersfree.com/v1/comentarios?filter[comentario]=malo&filter[id]=1
    }
    
    // Scope para manejar la ordenación
    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';

            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }

            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
        //ASENDENTE  http://api.codersfree.com/v1/comentarios?sort=comentario
        //DESENDENTE   http://api.codersfree.com/v1/comentarios?sort=-comentario
    }

    // Scope para manejar la paginación o obtener todos los resultados
    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {
            $perPage = intval(request('perPage'));
            if ($perPage) {
                return $query->paginate($perPage);
            }
        }

        return $query->get();
    }
    //http://api.codersfree.com/v1/comentarios?perPage=10
}







