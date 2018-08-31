<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 't_alumnos';
    protected $primaryKey = 'id_t_usuarios';

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 't_calificaciones', 'id_t_usuarios', 'id_t_materias')
        ->as('materia')->withPivot('calificacion', 'fecha_registro');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class,'id_t_usuarios');
    }

    public function getPromedioAttribute() {
        return $this->calificaciones()->avg('calificacion');
    }
}
