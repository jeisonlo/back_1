<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Mapadesueno extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre','imagenes','texto','sticker','figuras','descripcion'  ];

         // Definición de listas blancas para consultas
    protected $allowIncluded = ['seguimiento','user']; // Ejemplo de posibles relaciones
    protected $allowFilter = ['id', 'nombre','imagenes','texto','sticker','figuras','descripcion'];
    protected $allowSort = ['id', 'nombre','imagenes','texto','sticker','figuras','descripcion' ];



    public function user (){
        return $this->belongsTo('App\Models\user');
    }


    public function seguimiento (){

        return $this->hasOne('App\Models\seguimiento');
    

    }

    public function comentarios()
    {
        return $this->hasMany('App\Models\Comentario');
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
        
           //http://api.codersfree.com/v1/mapadesueños?included=seguimiento
           //http://api.codersfree.com/v1/mapadesueños?included=user
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
           //http://api.codersfree.com/v1/mapadesueños?filter[nombre]=Arte
           //http://api.codersfree.com/v1/mapadesueños?filter[nombre]=naturaleza&filter[id]=1
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
           //ASENDENTE   http://api.codersfree.com/v1/mapadesueños?sort=nombre
           //DESENDENTE   http://api.codersfree.com/v1/mapadesueños?sort=-nombre
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
       //http://api.codersfree.com/v1/mapadesueños?perPage=10
   }
 
 
 