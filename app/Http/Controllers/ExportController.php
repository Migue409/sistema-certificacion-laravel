<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Cita;
use App\Models\Reserva;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Notifications\Action;

class ExportController extends Controller
{

    public function exportPDF($id_actividad)
    {
        $asistencias = Actividad::join('citas', 'citas.id_actividad', '=', 'actividades.id_actividad')
            ->join('asistencias', 'citas.id', '=', 'asistencias.id_cita')
            ->join('usuarios', 'usuarios.id_usuario', '=', 'asistencias.id_usuario')
            ->where('actividades.id_actividad', $id_actividad)
            ->select('actividades.*', 'asistencias.asistencia', 'usuarios.*')
            ->get(); // Aquí ejecutamos la consulta
           

        $nombreProf=Actividad::join('usuarios','actividades.id_usuario', '=', 'usuarios.id_usuario')
        ->where('actividades.id_actividad', $id_actividad)
        ->select('usuarios.nombre')->get();

        $citas = Cita::where('id_actividad',$id_actividad)->get();
        $totalAlumnos = $citas->count();
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Courier'); // Puedes cambiar la fuente
        $options->setIsHtml5ParserEnabled(true);

        $dompdf = new Dompdf($options);
        $logoPath = public_path('images/logoCoordinacion.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        $filas = "";
        foreach ($asistencias as $asist) {
            if ($asist->asistencia === 1) {
                $filas .= '<tr>
                    <td>2522160002</td>
                    <td>Alan Adair Vazquez Cruz</td>
                    <td class="asistencia-verde">Asistió</td>
                    <td class="celda">No asistió</td>
                 
                </tr>';
            }else{
                 $filas .= '<tr>
                    <td>2522160003</td>
                    <td>Alan Adair Vazquez Cruz</td>
                    <td >Asistió</td>
                    <td class="asistencia-roja">No asistió</td>
                    
                </tr>';
            }
        }

        // Contenido HTML del PDF con estilos CSS
        $html = '
    <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lista de Asistencias</title>
            <style>
                /* Estilos generales */
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }

                /* Contenedor principal */
                .container {
                    width: 100%;
                    max-width: 1200px;
                    margin: auto;
                }

                /* Encabezado */
                .header {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    margin-bottom: 20px;
                }

                .logo {
                    width: 100px;
                    height: auto;
                    margin-right: 20px;
                }

                h1 {
                    font-size: 22px;
                    font-weight: bold;
                    margin: 0;
                }

                /* Estilos para la tabla */
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }


                th {
                    background-color: #f2f2f2;
                }

                /* Estilos para las asistencias */
                .asistencia-verde, .asistencia-roja {
                    width: 92%;
                    height: 20px;
                    display: block;
                    color:  #f2f2f2;
                }
                .asistencia-verde {
                    background-color: green;
                }
                .asistencia-roja {
                    background-color: red;
                }

                /* Asegurar que las celdas sean del mismo tamaño */
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center; /* Centrar contenido */
                    width: 100%; /* Ajusta el ancho según sea necesario */
                }

                
            </style>
        </head>
        <body>

            <div class="container">
                <!-- ENCABEZADO -->
                <table border="0">
                    <tr>
                        <td><img src="' . $logoBase64 . '" class="logo" alt="Logo"></td>
                        <td><h1>LISTA DE ASISTENCIAS</h1></td>
                    </tr>
                </table>



                <!-- TABLA -->
                <table>
                    <tbody>
                        <tr>
                            <th><strong>Actividad:</strong></th>
                            <td >'.$asistencias->first()->actividad.'</td>
                            <th><strong>Total alumnos:</strong></th>
                            <td>'.$totalAlumnos.'</td>
                        </tr>
                        <tr>
                            <th><strong>Docente a cargo:</strong></th>
                            <td colspan="3">'.$nombreProf->first()->nombre.'</td>
                        </tr>
                        <tr>
                            <th><strong>Fecha y hora:</strong></th>
                            <td>'.$asistencias->first()->fecha.'</td>
                            <th><strong>Aula:</strong></th>
                            <td >'.$asistencias->first()->salon.'</td>
                        </tr>
                        <tr>
                            <th>Matrícula</th>
                            <th>Nombre</th>
                            <th colspan="2">Asistencia</th>
                        </tr>
                        '. $filas .'
                        
                    </tbody>
                </table>
            </div>

        </body>
        </html>
        ';

        // Cargar HTML en Dompdf
        $dompdf->loadHtml($html);

        // Configurar tamaño de papel y orientación (A4, vertical)
        $dompdf->setPaper('A4', 'landscape');

        // Renderizar el PDF
        $dompdf->render();

        // Enviar el PDF al navegador
        $dompdf->stream("reporte.pdf", ["Attachment" => false]);
    }

    // Método para mostrar las reservas
    public function showReservations()
    {
        // Traer todas las reservas con las relaciones necesarias
        $reservas = Reserva::with(['usuario', 'cita', 'cita.actividad'])->get();

        return view('reservas', compact('reservas'));
    }

    // Método para exportar las reservas a un archivo Excel
    public function export()
    {
        // Obtenemos las reservas con sus relaciones necesarias
        // Obtener las reservas donde el estatus no es 'cancelada'
        $reservas = Reserva::with(['usuario', 'cita', 'cita.actividad'])
            ->where('estatus', '!=', 'cancelada')  // Asegúrate de que 'estatus' sea el campo correcto
            ->get();

        // Crear una nueva instancia de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definir las cabeceras de las columnas
        $sheet->setCellValue('A1', 'Matrícula');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Actividad');
        $sheet->setCellValue('D1', 'Asistencia');

        // Llenar las filas con los datos de las reservas
        $row = 2; // Empezamos en la segunda fila (debido a que la primera es para cabeceras)
        foreach ($reservas as $reserva) {
            $sheet->setCellValue('A' . $row, $reserva->usuario->matricula); // Matrícula del estudiante
            $sheet->setCellValue('B' . $row, $reserva->cita->actividad->fecha); // Fecha de la cita
            $sheet->setCellValue('C' . $row, $reserva->cita->actividad->actividad); // Nombre de la actividad
            $sheet->setCellValue('D' . $row, $reserva->asistencia ? 'Sí' : 'No'); // Asistencia (Sí o No)

            $row++;
        }

        // Crear un archivo Excel (.xlsx)
        $writer = new Xlsx($spreadsheet);

        // Forzar la descarga del archivo Excel
        $filename = 'reservas.xlsx';
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
