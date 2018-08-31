<?php

namespace App\Http\Controllers;

use App\Alumno;
use App\Calificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalificacionesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['crea', 'actualiza', 'destruye']]);
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function lista($idAlumno)
    {
		$alumno = Alumno::find($idAlumno)->with(['calificaciones' => function ($query) {
			$query->with('materia');
		}])->first();

		$respuesta = [];
		foreach ($alumno->calificaciones as $calificacion) {
			$elmento = [];
			$elmento['nombre'] = $alumno->nombre;
			$elmento['ap_paterno'] = $alumno->ap_paterno;
			$elmento['ap_materno'] = $alumno->ap_materno;
			$elmento['calificacion'] = $calificacion->calificacion;
			$elmento['calificacion'] = $calificacion->calificacion;
			$elmento['fecha_registro'] = $calificacion->fecha_registro->format('d/m/Y');
			$elmento['materia'] = $calificacion->materia->nombre;
			$respuesta[] = $elmento;
		}

		$respuesta[]['promedio'] = $alumno->promedio;
		
        return response()->json($respuesta, 200);
    }

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function crea(Request $request, $idAlumno)
	{
		$this->validate($request, Calificacion::$validationRules);

		$alumno = Alumno::find($idAlumno);
		if (is_null($alumno)) {
			return response()->json(['success' => 'no', 'msg' => 'Alumno no existente'], 404);
		}

		$calificacion = $alumno->calificaciones()->where('id_t_materias', $request->get('id_t_materias'))->get();
		if (!$calificacion->isEmpty()) {
			return response()->json(['success' => 'no', 'msg' => 'Calificacion ya asignada'], 409);
		}

		$nuevaCalificacion = new Calificacion($request->all());
		$nuevaCalificacion->fecha_registro = Carbon::now();

		$alumno->calificaciones()->save($nuevaCalificacion);

		return response()->json(['success' => 'ok', 'msg' => 'Calificacion registrada'], 201);
    }
    
    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function actualiza(Request $request, $idAlumno, $idMateria)
	{
		$this->validate($request, Calificacion::$validationRules);

		$alumno = Alumno::find($idAlumno);
		if (is_null($alumno)) {
			return response()->json(['success' => 'no', 'msg' => 'Alumno no existente'], 404);
		}

		$calificacion = $alumno->calificaciones()->where('id_t_materias', $idMateria)->first();
		if (is_null($calificacion)) {
			return response()->json(['success' => 'no', 'msg' => 'Calificacion no existente'], 404);
		}

		$calificacion->calificacion = $request->get('calificacion');
		$calificacion->save();

		return response()->json(['success' => 'ok', 'msg' => 'Calificacion actualizada'], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destruye($idAlumno, $idMateria)
	{
		Calificacion::where('id_t_usuarios', $idAlumno)->where('id_t_materias', $idMateria)->delete();

		return response()->json(['success' => 'ok', 'msg' => 'Calificacion eliminada'], 200);
	}

}