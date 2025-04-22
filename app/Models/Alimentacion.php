<?php
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alimentacion extends Model
{
    use HasFactory;

    protected $table = 'alimentacions'; // Nombre de la tabla

    protected $fillable = ['nombre', 'calorias']; // Campos que se pueden llenar
}