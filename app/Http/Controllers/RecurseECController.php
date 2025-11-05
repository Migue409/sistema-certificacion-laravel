<?php

namespace App\Http\Controllers;

use App\Models\RecurseEC;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RecurseECController extends Controller
{
    public function rgistroRecurseEC(Request $req){

        $registrado = RecurseEC::where('matricula', $req -> matricula)->exists();

        $mesActual = now()->format('m');
        $añoActual = Carbon::now()->year;

        if($mesActual == 1 || $mesActual == 2 || $mesActual == 3 || $mesActual == 4){
            $cuatrimestre = 'ENERO - ABRIL '.$añoActual;
        }elseif($mesActual == 5 || $mesActual == 6 || $mesActual == 7 || $mesActual == 8){
            $cuatrimestre = 'MAYO - AGOSTO '.$añoActual;
        }elseif($mesActual == 9 || $mesActual == 10 || $mesActual == 11 || $mesActual == 12){
            $cuatrimestre = 'SEPTIEMBRE - DICIEMBRE '.$añoActual;
        }

        if ($registrado) {
            return redirect()->route('estudiantes.RecurseEC')->with('error', "Ya estas registrado, espera información por parte de coordinación de inglés.");
        }
        else{
            $recurseEC = RecurseEC::create([
                'correo' => $req -> correo,
                'matricula' => $req -> matricula,
                'nombre' => $req -> nombre,
                'apellidoP' => $req -> app,
                'apellidoM' => $req -> apm,
                'telefono' => $req -> tel,
                'division' => $req -> divi,
                'grupoDivision' => $req -> GrupoDivi,
                'grupoInglesReg' => $req -> GrupoIngReg,
                'grupoInglesRec' => $req -> recurse,
                'nivel' => $req -> nivel,
                'cuatrimestre' => $cuatrimestre,
            ]);

            return redirect()->route('estudiantes.RecurseEC')->with('success', "Registro exitoso, espera información por medio de correo electrónico.");
        }
    }

    public function listaRegistros()
    {
        $registros = RecurseEC::orderByRaw("RIGHT(cuatrimestre, 4) DESC")->paginate();

        return view('ActExt.administrador.lista_recurseEC', compact('registros'));
    }

    public function exportXLS()
    {
        $reservas = RecurseEC::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir las cabeceras de las columnas
        $headers = ['A1' => 'Nombre', 'B1' => 'Matrícula', 'C1' => 'Correo', 'D1' => 'Teléfono', 'E1' => 'División', 'F1' => 'Grupo División', 'G1' => 'Grupo Inglés Regular', 'H1' => 'Asignatura de Recurse', 'I1' => 'Nivel', 'J1' => 'Cuatrimestre'];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Aplicar estilos a las cabeceras
        $styleArray = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], // Texto blanco y en negrita
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0073e6'] // Fondo azul
            ]
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);

        // Llenar las filas con los datos de las reservas
        $row = 2;
        foreach ($reservas as $reserva) {
            $nombreComp = $reserva->nombre . ' ' . $reserva->apellidoP . ' ' . $reserva->apellidoM;
            $sheet->setCellValue('A' . $row, $nombreComp);
            $sheet->setCellValue('B' . $row, $reserva->matricula);
            $sheet->setCellValue('C' . $row, $reserva->correo);
            $sheet->setCellValue('D' . $row, $reserva->telefono);
            $sheet->setCellValue('E' . $row, $reserva->division);
            $sheet->setCellValue('F' . $row, $reserva->grupoDivision);
            $sheet->setCellValue('G' . $row, $reserva->grupoInglesReg);
            $sheet->setCellValue('H' . $row, $reserva->grupoInglesRec);
            $sheet->setCellValue('I' . $row, $reserva->nivel);
            $sheet->setCellValue('J' . $row, $reserva->cuatrimestre);
            $row++;
        }

        // Ajustar tamaño de las columnas automáticamente
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Crear un archivo Excel (.xlsx)
        $writer = new Xlsx($spreadsheet);

        // Corregir formato de fecha para el nombre del archivo
        $fecha = date("Y-m-d_H-i-s");
        $filename = "RegistrosRecurseEducacionContinua_{$fecha}.xlsx";

        // Forzar la descarga del archivo Excel
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }

    public function exportXLSActual()
    {
        $mesActual = now()->format('m');
        $añoActual = Carbon::now()->year;

        if($mesActual == 1 || $mesActual == 2 || $mesActual == 3 || $mesActual == 4){
            $cuatrimestre = 'ENERO - ABRIL '.$añoActual;
        }elseif($mesActual == 5 || $mesActual == 6 || $mesActual == 7 || $mesActual == 8){
            $cuatrimestre = 'MAYO - AGOSTO '.$añoActual;
        }elseif($mesActual == 9 || $mesActual == 10 || $mesActual == 11 || $mesActual == 12){
            $cuatrimestre = 'SEPTIEMBRE - DICIEMBRE '.$añoActual;
        }

        $reservas = RecurseEC::where('cuatrimestre',$cuatrimestre)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir las cabeceras de las columnas
        $headers = ['A1' => 'Nombre', 'B1' => 'Matrícula', 'C1' => 'Correo', 'D1' => 'Teléfono', 'E1' => 'División', 'F1' => 'Grupo División', 'G1' => 'Grupo Inglés Regular', 'H1' => 'Asignatura de Recurse', 'I1' => 'Nivel', 'J1' => 'Cuatrimestre'];

        foreach ($headers as $cell => $text) {
            $sheet->setCellValue($cell, $text);
        }

        // Aplicar estilos a las cabeceras
        $styleArray = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], // Texto blanco y en negrita
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0073e6'] // Fondo azul
            ]
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($styleArray);

        // Llenar las filas con los datos de las reservas
        $row = 2;
        foreach ($reservas as $reserva) {
            $nombreComp = $reserva->nombre . ' ' . $reserva->apellidoP . ' ' . $reserva->apellidoM;
            $sheet->setCellValue('A' . $row, $nombreComp);
            $sheet->setCellValue('B' . $row, $reserva->matricula);
            $sheet->setCellValue('C' . $row, $reserva->correo);
            $sheet->setCellValue('D' . $row, $reserva->telefono);
            $sheet->setCellValue('E' . $row, $reserva->division);
            $sheet->setCellValue('F' . $row, $reserva->grupoDivision);
            $sheet->setCellValue('G' . $row, $reserva->grupoInglesReg);
            $sheet->setCellValue('H' . $row, $reserva->grupoInglesRec);
            $sheet->setCellValue('I' . $row, $reserva->nivel);
            $sheet->setCellValue('J' . $row, $reserva->cuatrimestre);
            $row++;
        }

        // Ajustar tamaño de las columnas automáticamente
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Crear un archivo Excel (.xlsx)
        $writer = new Xlsx($spreadsheet);

        // Corregir formato de fecha para el nombre del archivo
        $fecha = date("Y-m-d_H-i-s");
        $filename = "RegistrosRecurseEducacionContinua_{$fecha}.xlsx";

        // Forzar la descarga del archivo Excel
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
