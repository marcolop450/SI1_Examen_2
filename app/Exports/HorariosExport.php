<?php

namespace App\Exports;

use App\Models\Horario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class HorariosExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $filtroDocente;
    protected $filtroGrupo;
    protected $filtroDia;

    public function __construct($filtroDocente = null, $filtroGrupo = null, $filtroDia = null)
    {
        $this->filtroDocente = $filtroDocente;
        $this->filtroGrupo = $filtroGrupo;
        $this->filtroDia = $filtroDia;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Horario::with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->where('activo', true);

        if ($this->filtroDocente) {
            $query->where('id_docente', $this->filtroDocente);
        }

        if ($this->filtroGrupo) {
            $query->where('id_grupo', $this->filtroGrupo);
        }

        if ($this->filtroDia) {
            $query->where('dia', $this->filtroDia);
        }

        return $query->orderBy('dia')->orderBy('hora_inicio')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Día',
            'Hora Inicio',
            'Hora Final',
            'Docente',
            'Registro',
            'Materia',
            'Grupo',
            'Aula',
            'Modalidad',
            'Gestión',
        ];
    }

    /**
     * @var Horario $horario
     */
    public function map($horario): array
    {
        return [
            $horario->dia,
            substr($horario->hora_inicio, 0, 5),
            substr($horario->hora_final, 0, 5),
            $horario->docente->usuario->nombre . ' ' . $horario->docente->usuario->apellido,
            $horario->docente->registro,
            $horario->materia->nombre,
            $horario->grupo->nombre,
            $horario->es_virtual ? 'N/A' : ($horario->aula->nombre ?? 'N/A'),
            $horario->es_virtual ? 'Virtual' : 'Presencial',
            $horario->gestion,
        ];
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8B5CF6'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Horarios';
    }
}