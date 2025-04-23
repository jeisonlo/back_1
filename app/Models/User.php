<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Builder;

use App\Traits\ApiTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements CanResetPassword

{
    use HasApiTokens, HasFactory, Notifiable, ApiTrait;
    protected $table = 'users';

     //Listas Blancas
     protected $allowIncluded = ['likes', 'histories', 'playlists'];
     protected $allowFilter = ['id', 'name'];
     protected $allowSort = ['id', 'name'];



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'usuarios';
    protected $fillable = [

        'nombre',
        'apellidos',

        'name',
        'birthdate',

        'email',
        'password',
        'fecha_nacimiento',
        'genero',
        'codigo_recuperacion',
        'vive_en',
        'de_donde_es',
        'estudios',
        'acerca_de_mi',
        'foto'
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    public function mapadesuenos (){
        return $this->hasMany('App\Models\mapadesueno');
    }

    public function libros (){
        return $this->hasMany('App\Models\libro');
    }

    public function comentarios (){
        return $this->hasMany('App\Models\comentario');
    }

    public function calificacion (){
        return $this->hasOne('App\Models\calificacion');
    }


    protected $allowIncluded = ['comentario','historial','rutina','tarea']; //las posibles Querys que se pueden realizar
    
    protected $allowFilter = ['id', 'name'];
    protected $allowSort = ['id', 'name'];



    public function comentario(){
        return $this->hasmany('App\Models\comment');
    }
    public function historial(){
        return $this->hasmany('App\Models\record');
    }
    public function rutina(){
        return $this->hasmany('App\Models\rutina');
    }
    public function tarea(){
        return $this->hasmany('App\Models\tarea');
    }
    public function calendario(){
        return $this->hasmany('App\Models\calendar');
    }



    public function scopeIncluded(Builder $query)
    {
       
        if(empty($this->allowIncluded)||empty(request('included'))){// validamos que la lista blanca y la variable included enviada a travez de HTTP no este en vacia.
            return;
        }

        
        $relations = explode(',', request('included')); //['posts','relation2']//recuperamos el valor de la variable included y separa sus valores por una coma

        //return $relations;

        $allowIncluded = collect($this->allowIncluded); //colocamos en una colecion lo que tiene $allowIncluded en este caso = ['posts','posts.user']

        foreach ($relations as $key => $relationship) { //recorremos el array de relaciones

            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }
        $query->with($relations); //se ejecuta el query con lo que tiene $relations en ultimas es el valor en la url de included

        //http://api.codersfree1.test/v1/categories?included=posts


    }

    

    /**
     * Relación de uno a muchos con el modelo Playlist.
     */
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    /**
     * Relación de uno a muchos con el modelo Like.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relación de uno a muchos con el modelo History.
     */
    public function histories()
    {
        return $this->hasMany(History::class);
    }



}
