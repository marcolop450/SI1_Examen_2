<?php

namespace App\Exports;

use App\Models\Aula;
use App\Models\Horario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class AulasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Aula::where('activo', true)
            ->withCount(['horarios' => function ($query) {
                $query->where('activo', true);
            }])
            ->get()
            ->map(function ($aula) {
                $horariosDetallados = Horario::where('id_aula', $aula->id)
                    ->where('activo', true)
                    ->get();

                $totalMinutos = 0;
                foreach ($horariosDetallados as $horario) {
                    $inicio = Carbon::parse($horario->hora_inicio);
                    $fin = Carbon::parse($horario->hora_final);
                    $totalMinutos += $inicio->diffInMinutes($fin);
                }
                $horasSemanales = round($totalMinutos / 60, 2);

                $horasDisponibles = 72; // 6 días x 12 horas
                $porcentajeOcupacion = $horasDisponibles > 0 
                    ? round(($horasSemanales / $horasDisponibles) * 100, 2) 
                    : 0;

                $aula->total_horarios = $aula->horarios_count;
                $aula->horas_semanales = $horasSemanales;
                $aula->porcentaje_ocupacion = $porcentajeOcupacion;

                return $aula;
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Aula',
            'Tipo',
            'Capacidad',
            'Piso',
            'Total Horarios',
            'Horas Semanales',
            '% Ocupación',
            'Equipamiento',
            'Estado',
        ];
    }

    /**
     * @var Aula $aula
     */
    public function map($aula): array
    {
        return [
            $aula->nombre,
            $aula->tipo,
            $aula->capacidad,
            $aula->piso,
            $aula->total_horarios,
            $aula->horas_semanales,
            $aula->porcentaje_ocupacion . '%',
            $aula->equipamiento ?? 'N/A',
            $aula->activo ? 'Activo' : 'Inactivo',
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Estilo del encabezado
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A855F7'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // Auto-ajustar ancho de columnas
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Aulas';
    }
}