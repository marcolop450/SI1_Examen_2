<?php

namespace App\Exports;

use App\Models\Docente;
use App\Models\Horario;
use App\Models\Asistencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class CargaHorariaDocenteExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths
{
    protected $idDocente;

    public function __construct($idDocente)
    {
        $this->idDocente = $idDocente;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $docente = Docente::with('usuario')->findOrFail($this->idDocente);
        
        $horarios = Horario::where('id_docente', $docente->registro)
            ->where('activo', true)
            ->with(['materia', 'grupo', 'aula'])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        $data = collect();

        // Información del docente
        $data->push([
            'INFORMACIÓN DEL DOCENTE',
            '',
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Nombre Completo:',
            $docente->usuario->nombre . ' ' . $docente->usuario->apellido,
            '',
            '',
            '',
            ''
        ]);
        
        $data->push([
            'Registro:',
            $docente->registro,
            'Carrera:',
            $docente->carrera,
            '',
            ''
        ]);
        
        $data->push([
            'Especialidad:',
            $docente->especialidad,
            'Email:',
            $docente->usuario->correo,
            '',
            ''
        ]);
        
        $data->push([
            'Carga Actual:',
            $docente->carga_horaria_actual . ' hrs',
            'Carga Máxima:',
            $docente->carga_horaria_maxima . ' hrs',
            'Porcentaje:',
            round(($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100, 2) . '%'
        ]);

        $data->push(['', '', '', '', '', '']); // Fila vacía

        $data->push([
            'RESUMEN DE HORAS POR DÍA',
            '',
            '',
            '',
            '',
            ''
        ]);

        $horasPorDia = $horarios->groupBy('dia')->map(function($grupo) {
            return $grupo->sum(function($horario) {
                $inicio = Carbon::parse($horario->hora_inicio);
                $fin = Carbon::parse($horario->hora_final);
                return round($inicio->diffInMinutes($fin) / 60, 2);
            });
        });

        foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia) {
            $horas = $horasPorDia[$dia] ?? 0;
            $data->push([
                $dia,
                $horas . ' horas',
                '',
                '',
                '',
                ''
            ]);
        }

        $data->push([
            'TOTAL SEMANAL:',
            $horasPorDia->sum() . ' horas',
            '',
            '',
            '',
            ''
        ]);

        $data->push(['', '', '', '', '', '']); // Fila vacía

        $asistenciasMes = Asistencia::where('id_docente', $docente->registro)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->get();

        $data->push([
            'ESTADÍSTICAS DE ASISTENCIA - ' . strtoupper(now()->format('F Y')),
            '',
            '',
            '',
            '',
            ''
        ]);

        $data->push([
            'Total Asistencias:',
            $asistenciasMes->count(),
            'A Tiempo:',
            $asistenciasMes->where('estado', 'A tiempo')->count(),
            'Tardanzas:',
            $asistenciasMes->where('estado', 'Tardanza')->count()
        ]);

        $data->push([
            'Faltas:',
            $asistenciasMes->where('estado', 'Falta')->count(),
            '',
            '',
            '',
            ''
        ]);

        $data->push(['', '', '', '', '', '']); // Fila vacía

        // Horarios detallados
        $data->push([
            'HORARIO DETALLADO',
            '',
            '',
            '',
            '',
            ''
        ]);

        // Encabezados de la tabla de horarios
        $data->push([
            'Día',
            'Hora Inicio',
            'Hora Fin',
            'Materia',
            'Grupo',
            'Aula/Modalidad'
        ]);

        // Datos de horarios
        foreach ($horarios as $horario) {
            $data->push([
                $horario->dia,
                substr($horario->hora_inicio, 0, 5),
                substr($horario->hora_final, 0, 5),
                $horario->materia->nombre,
                $horario->grupo->nombre,
                $horario->es_virtual ? 'VIRTUAL' : $horario->aula->nombre
            ]);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Carga Horaria';
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 30,
            'E' => 20,
            'F' => 20,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Estilo para encabezados principales (azul oscuro)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4A5568']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        ];

        // Aplicar estilos a secciones específicas
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        
        // Resaltar filas importantes
        $sheet->getStyle('A7:F7')->applyFromArray($headerStyle);
        
        return [];
    }
}