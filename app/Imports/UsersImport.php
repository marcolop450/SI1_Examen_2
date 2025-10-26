<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Docente;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
//Maatwebsite ayuda en la parte de manerjar cosas con excel
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class UsersImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    protected $exitosos = 0;
    protected $errores = 0;
    protected $detalles = [];

    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            $fila = $this->exitosos + $this->errores + 2; 

            $ci = isset($row['ci']) ? trim($row['ci']) : null;
            $correo = isset($row['correo']) ? trim(strtolower($row['correo'])) : null;

            //VERIFICAR DUPLICADOS ANTES DE VALIDAR
            if ($ci && User::where('ci', $ci)->exists()) {
                $this->errores++;
                $usuarioExistente = User::where('ci', $ci)->first();
                $this->detalles[] = "X Fila {$fila}: El CI {$ci} ya existe (Usuario: {$usuarioExistente->username})";
                DB::rollback();
                return null;
            }

            if ($correo && User::where('correo', $correo)->exists()) {
                $this->errores++;
                $usuarioExistente = User::where('correo', $correo)->first();
                $this->detalles[] = "X Fila {$fila}: El correo {$correo} ya existe (Usuario: {$usuarioExistente->username})";
                DB::rollback();
                return null;
            }

            //Validar datos requeridos
            $validator = Validator::make($row, [
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'ci' => 'required|integer',
                'correo' => 'required|email',
                'sexo' => 'required|in:M,F,m,f',
                'rol' => 'required|string',
            ]);

            if ($validator->fails()) {
                $this->errores++;
                $errores = implode(', ', $validator->errors()->all());
                $this->detalles[] = "X Fila {$fila}: {$errores}";
                DB::rollback();
                return null;
            }

            $rol = Rol::where('nombre', 'LIKE', '%' . trim($row['rol']) . '%')->first();
            
            if (!$rol) {
                $this->errores++;
                $this->detalles[] = "X Fila {$fila}: Rol '{$row['rol']}' no existe";
                DB::rollback();
                return null;
            }

            //Generar username automático
            $nombre = strtolower(preg_replace('/[^a-zA-Z]/', '', $row['nombre']));
            $apellido = strtolower(preg_replace('/[^a-zA-Z]/', '', $row['apellido']));
            $username = substr($nombre, 0, 1) . $apellido;
            
            //Verificar username único
            $counter = 1;
            $originalUsername = $username;
            while (User::where('username', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;                
                //Si hay muchos duplicados, agregar parte del CI
                if ($counter > 20) {
                    $username = $originalUsername . substr($ci, -3);
                    break;
                }
            }

            $nextId = DB::table('users')->max('id') + 1;
            DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH {$nextId}");

            //Crear usuario
            $user = User::create([
                'nombre' => ucwords(strtolower(trim($row['nombre']))),
                'apellido' => ucwords(strtolower(trim($row['apellido']))),
                'ci' => $ci,
                'correo' => $correo,
                'telefono' => $row['telefono'] ?? null,
                'sexo' => strtoupper($row['sexo']),
                'domicilio' => $row['domicilio'] ?? null,
                'username' => $username,
                'password' => Hash::make($ci), // Password = CI
                'activo' => true,
                'id_rol' => $rol->id,
            ]);

            //Si el rol es Docente, crear también en tabla docente
            if (strtolower($rol->nombre) === 'docente') {
                $registro = isset($row['registro']) && $row['registro'] ? $row['registro'] : $this->generarRegistroDocente();
                
                $intentos = 0;
                while (Docente::where('registro', $registro)->exists() && $intentos < 10) {
                    $registro = $this->generarRegistroDocente();
                    $intentos++;
                }

                Docente::create([
                    'registro' => $registro,
                    'carrera' => $row['carrera'] ?? 'Ingeniería de Sistemas',
                    'especialidad' => $row['especialidad'] ?? 'Programación',
                    'fecha_ingreso' => isset($row['fecha_ingreso']) ? $row['fecha_ingreso'] : now(),
                    'carga_horaria_maxima' => isset($row['carga_horaria_maxima']) ? $row['carga_horaria_maxima'] : 40,
                    'carga_horaria_actual' => 0,
                    'activo' => true,
                    'id_usuario' => $user->id,
                ]);

                $this->exitosos++;
                $this->detalles[] = "✓ Fila {$fila}: Docente {$username} | Registro: {$registro} | Pass: {$ci}";
            } else {
                $this->exitosos++;
                $this->detalles[] = "✓ Fila {$fila}: Usuario {$username} ({$rol->nombre}) | Pass: {$ci}";
            }

            DB::commit();
            return $user;

        } catch (\Exception $e) {
            DB::rollback();
            $this->errores++;
            $fila = $this->exitosos + $this->errores + 2;
            $mensaje = $e->getMessage();
            
            // etectar errores de duplicados que no se capturaron
            if (strpos($mensaje, 'ci') !== false && strpos($mensaje, 'already been taken') !== false) {
                $this->detalles[] = "X Fila {$fila}: El CI ya existe en la base de datos";
            } elseif (strpos($mensaje, 'correo') !== false && strpos($mensaje, 'already been taken') !== false) {
                $this->detalles[] = "X Fila {$fila}: El correo ya existe en la base de datos";
            } else {
                $this->detalles[] = "X Fila {$fila}: {$mensaje}";
            }
            
            return null;
        }
    }

    public function getResultados()
    {
        return [
            'exitosos' => $this->exitosos,
            'errores' => $this->errores,
            'detalles' => $this->detalles,
        ];
    }

    /**
     * Generar registro único para docente
     */
    private function generarRegistroDocente()
    {
        // Generar número aleatorio de 5 dígitos
        return rand(10000, 99999);
    }

    /**
     * Manejo de errores de validación
     */
    public function onError(\Throwable $e)
    {
        $this->errores++;
        $this->detalles[] = "X Error general: " . $e->getMessage();
    }
}