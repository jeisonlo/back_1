<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Libro extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'titulo', 
        'link', 
        'descripcionlibro', 
        'editorial', 
        'autor', 
        'pdf_url',
        'portada_url',
        'user_id',
        'categorialibro_id'
    ];
    
    // Definición de listas blancas para consultas
    protected $allowIncluded = ['promediocalificacion','user','comentarios','comentarios.user','categorialibro','user.calificacion','user.comentarios','calificacions','calificacions.user', 'favoritos']; 
    protected $allowFilter = ['titulo', 'autor', 'editorial', 'categorialibro_id']; // Añadido para filtros
    protected $allowSort = ['titulo', 'autor', 'created_at']; // Añadido para ordenamiento


    

    public function user(){
        return $this->belongsTo('App\Models\user');
    }

    public function calificacions()
    {
        return $this->hasMany('App\Models\Calificacion');
    }

    public function categorialibro()
    {
        return $this->belongsTo('App\Models\Categorialibro');
    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario');
    }

    public function promediocalificacion()
    {
        return $this->hasOne('App\Models\Promediocalificacion');
    }
    
 /**
 * Obtener los favoritos de este libro.
 */
public function favoritos()
{
    return $this->hasMany(Favorito::class, 'libro_id');
}

/**
 * Verificar si el libro está en favoritos.
 */
public function esFavorito()
{
    return $this->favoritos()->exists();
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
    
    // Scope para categoría Arte
    public function scopeArte(Builder $query)
    {
        return $query->where('categorialibro_id', function($q) {
            $q->select('id')->from('categorialibros')->where('nombre', 'Arte');
        });
    }
}