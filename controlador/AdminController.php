<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../modelo/AdminModel.php';

class AdminController extends Controller
{
    private AdminModel $model;

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    public function dashboard(): void
    {
        $this->iniciarSesion();

        if (!isset($_SESSION['admin_name'])) {
            header('Location: vista/login/login_form.php');
            exit;
        }

        $this->render(__DIR__ . '/../vista/adm/dashboard/dashboard.php', [
            'adminName' => $_SESSION['admin_name'],
            'fechaActual' => $this->obtenerFechaLarga(),
            'horaActual' => $this->obtenerHoraActual(),
            'resumen' => $this->model->obtenerResumenTablas(),
            'productosInventario' => $this->model->obtenerProductosInventario(),
            'datosSalidas' => $this->model->obtenerSalidasPorFecha(),
            'datosEntradas' => $this->model->obtenerEntradasPorFecha(),
            'alertas' => $this->model->obtenerAlertas(),
        ]);
    }

    private function iniciarSesion(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    private function obtenerFechaLarga(): string
    {
        date_default_timezone_set('America/Lima');

        $diaSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];

        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        $fecha = new DateTime('now', new DateTimeZone('America/Lima'));
        $dia = $diaSemana[$fecha->format('l')] ?? $fecha->format('l');
        $mes = $meses[$fecha->format('m')] ?? $fecha->format('F');

        return sprintf(
            '%s, %s de %s del %s',
            $dia,
            $fecha->format('d'),
            $mes,
            $fecha->format('Y')
        );
    }

    private function obtenerHoraActual(): string
    {
        return (new DateTime('now', new DateTimeZone('America/Lima')))->format('H:i');
    }
}
