<?php

namespace App\Exports;

use App\Models\Asistencia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class AsistenciasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $filtroDocente;
    protected $filtroGrupo;

    public function __construct($fechaInicio, $fechaFin, $filtroDocente = null, $filtroGrupo = null)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->filtroDocente = $filtroDocente;
        $this->filtroGrupo = $filtroGrupo;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Asistencia::with(['docente.usuario', 'horario.materia', 'horario.grupo', 'horario.aula'])
            ->whereBetween('fecha', [$this->fechaInicio, $this->fechaFin]);

        if ($this->filtroDocente) {
            $query->where('id_docente', $this->filtroDocente);
        }

        if ($this->filtroGrupo) {
            $query->whereHas('horario', fn($q) => $q->where('id_grupo', $this->filtroGrupo));
        }

        return $query->orderBy('fecha', 'desc')->orderBy('hora_llegada', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Fecha',
            'Docente',
            'Registro',
            'Materia',
            'Grupo',
            'Hora Llegada',
            'Estado',
            'Aula/Modalidad',
            'Justificada',
            'Observaciones',
        ];
    }

    /**
     * @var Asistencia $asistencia
     */
    public function map($asistencia): array
    {
        return [
            Carbon::parse($asistencia->fecha)->format('d/m/Y'),
            $asistencia->docente->usuario->nombre . ' ' . $asistencia->docente->usuario->apellido,
            $asistencia->docente->registro,
            $asistencia->horario->materia->nombre,
            $asistencia->horario->grupo->nombre,
            Carbon::parse($asistencia->hora_llegada)->format('H:i:s'),
            $asistencia->estado,
            $asistencia->horario->es_virtual ? 'Virtual' : ($asistencia->horario->aula->nombre ?? 'N/A'),
            $asistencia->justificada ? 'Sí' : 'No',
            $asistencia->observaciones ?? '',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3B82F6'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Asistencias';
    }
}