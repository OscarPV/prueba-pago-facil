<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{

    protected $table = 't_calificaciones';
    protected $primaryKey = 'id_t_calificaciones';
    protected $fillable = ['id_t_materias', 'calificacion'];
    protected $dates = ['fecha_registro'];
    public $timestamps = false;

    public static $validationRules = [
        'calificacion' => 'required|numeric',
        'id_t_materias' => 'required|integer|exists:t_materias,id_t_materias'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_t_materias');
    }
    
}
