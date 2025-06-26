<?php

namespace App\Exports;

use App\Models\Ganado;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithColumnWidths,
    ShouldAutoSize,
    WithMapping,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class GanadosExport implements FromCollection, WithHeadings, WithColumnWidths, ShouldAutoSize, WithMapping, WithEvents
{
    protected $destino;

    public function __construct($destino = null)
    {
        $this->destino = $destino;
    }

    public function collection()
    {
        $query = Ganado::query()->select([
            'arete', 'sexo', 'subasta', 'numero_subasta',
            'peso_total', 'precio_kg', 'monto', 'lote', 'destino',
            'rev1', 'rev2', 'rev3', 'estado'
        ]);

        if ($this->destino) {
            $query->where('destino', $this->destino);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Arete', 'Sexo', 'Subasta', 'N° Subasta',
            'Peso Total', 'Precio por Kg', 'Monto', 'Lote', 'Antigüedad',
            'Destino', 'Revisión 1', 'Revisión 2', 'Revisión 3', 'Estado'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,   // Arete
            'B' => 10,   // Sexo
            'C' => 14,   // Subasta
            'D' => 12,   // N° Subasta
            'E' => 14,   // Peso Total
            'F' => 14,   // Precio por Kg
            'G' => 16,   // Monto
            'H' => 14,   // Lote
            'I' => 18,   // Antigüedad
            'J' => 14,   // Destino
            'K' => 14,   // Rev 1
            'L' => 14,   // Rev 2
            'M' => 14,   // Rev 3
            'N' => 12    // Estado
        ];
    }

    public function map($ganado): array
    {
        $fechaLote = Carbon::parse($ganado->lote);
        $hoy = Carbon::now();
        $antiguedad = $fechaLote->diff($hoy);
        $antiguedadStr = $antiguedad->y . ' años - ' . $antiguedad->m . ' meses - ' . $antiguedad->d . ' días';

        return [
            $ganado->arete,
            $ganado->sexo === 'masculino' ? 'Macho' : 'Hembra',
            $ganado->subasta,
            $ganado->numero_subasta,
            number_format($ganado->peso_total, 2) . ' kg',
            '₡' . number_format($ganado->precio_kg, 0),
            '₡' . number_format($ganado->monto, 0),
            $ganado->lote,
            $antiguedadStr,
            $ganado->destino,
            $ganado->rev1,
            $ganado->rev2,
            $ganado->rev3,
            ucfirst($ganado->estado)
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Estilo encabezado
                $sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '087282']],
                    'alignment' => ['horizontal' => 'center'],
                ]);

                // Filtros automáticos en encabezado
                $sheet->setAutoFilter('A1:N1');

                // Congelar primera fila
                $sheet->freezePane('A2');

                // Bordes en toda la tabla
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
    }
}
