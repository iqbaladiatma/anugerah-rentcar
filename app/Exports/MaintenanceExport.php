<?php

namespace App\Exports;

use App\Models\Maintenance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class MaintenanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Maintenance::with(['car'])
            ->whereBetween('service_date', [$this->startDate, $this->endDate])
            ->orderBy('service_date', 'desc')
            ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Service Date',
            'Vehicle',
            'License Plate',
            'Maintenance Type',
            'Description',
            'Service Provider',
            'Cost (IDR)',
            'Odometer (km)',
            'Next Service Date',
            'Days Until Next Service',
            'Cost per KM',
        ];
    }

    /**
     * @param Maintenance $maintenance
     * @return array
     */
    public function map($maintenance): array
    {
        return [
            $maintenance->service_date->format('Y-m-d'),
            $maintenance->car->brand . ' ' . $maintenance->car->model,
            $maintenance->car->license_plate,
            ucfirst($maintenance->maintenance_type),
            $maintenance->description,
            $maintenance->service_provider,
            number_format($maintenance->cost, 0, ',', '.'),
            number_format($maintenance->odometer_at_service, 0, ',', '.'),
            $maintenance->next_service_date ? $maintenance->next_service_date->format('Y-m-d') : '-',
            $maintenance->getDaysUntilNextService() ?? '-',
            $maintenance->getCostPerKilometer() ? number_format($maintenance->getCostPerKilometer(), 2, ',', '.') : '-',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}