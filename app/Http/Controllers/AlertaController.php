<?php

namespace App\Http\Controllers;

use App\Alerta;
use App\Exports\AlertasExport;
use App\Exports\ConsultasExport;
use App\Paciente;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlertaController extends Controller
{
    static function getAlerta($cant, $min, $max, $msg_bajo, $msg_alto)
    {
        if ($cant > $max)
            return $msg_alto;
        elseif ($cant < $min)
            return $msg_bajo;
        return null;
    }

    static function alertGlucosa($consulta)
    {
        $glucosa = $consulta->cant_glucosa;
        $g_baja = "Glucosa Baja";
        $g_alta = "Glucosa Alta";

        if (!$consulta->diab_mill) {
            if ($consulta->ayuno)
                return AlertaController::getAlerta($glucosa, 70, 100, $g_baja, $g_alta);
            else
                return AlertaController::getAlerta($glucosa, 90, 140, $g_baja, $g_alta);
        } else {
            if ($consulta->ayuno)
                return AlertaController::getAlerta($glucosa, 70, 130, $g_baja, $g_alta);
            else
                return AlertaController::getAlerta($glucosa, 100, 179, $g_baja, $g_alta);
        }
    }

    static function intervalsGlucosa($consulta)
    {
        if (!$consulta->diab_mill) {
            if ($consulta->ayuno)
                return [70, 100];
            else
                return [90, 140];
        } else {
            if ($consulta->ayuno)
                return [70, 130];
            else
                return [100, 179];
        }
    }

    static function alertIMC($consulta, $paciente)
    {
        if ($consulta->peso)
            return self::getAlerta($consulta->peso / ($paciente->talla / 100) ** 2, 18.5, 24.999, 'Peso Bajo', 'Peso alto');
        return null;
    }

    static function intervalIMC()
    {
        return [18.5, 25];
    }

    static function alertICC($consulta, $paciente)
    {
        $icc_bajo = "ICC debajo";
        $icc_alto = "ICC alto";

        if ($consulta->cintura !== null && $consulta->cadera !== null) {
            if ($paciente->sexo === "M")
                return self::getAlerta($consulta->cintura / $consulta->cadera, 0.71, 0.84, $icc_bajo, $icc_alto);
            else
                return self::getAlerta($consulta->cintura / $consulta->cadera, 0.78, 0.94, $icc_bajo, $icc_alto);
        }
        return null;
    }

    static function intervalICC($paciente)
    {
        if ($paciente->sexo === "M")
            return [0.71, 0.84];
        else
            return [0.78, 0.94];
    }

    static function alertTensionSist($consulta, $paciente)
    {
        $edad = (new DateTime())->diff(new DateTime($paciente->fecha_nacimiento))->y;
        $ta_sist = $consulta->ta_sist;
        $msg_baja = "T.A. Sistólica Baja";
        $msg_alta = "T.A. Sistólica Alta";

        if ($edad <= 29) {
            return AlertaController::getAlerta($ta_sist, 80, 134, $msg_baja, $msg_alta);
        } elseif ($edad >= 30 && $edad <= 39) {
            return AlertaController::getAlerta($ta_sist, 89, 139, $msg_baja, $msg_alta);
        } elseif ($edad >= 40) {
            return AlertaController::getAlerta($ta_sist, 90, 139, $msg_baja, $msg_alta);
        }
        return null;
    }

    static function intervalTensionSist($consulta, $paciente)
    {
        $edad = (new DateTime($consulta->created_at))->diff(new DateTime($paciente->fecha_nacimiento))->y;

        if ($edad <= 29) {
            return [80, 134];
        } elseif ($edad >= 30 && $edad <= 39) {
            return [89, 139];
        } elseif ($edad >= 40) {
            return [90, 139];
        }
    }

    static function alertTensionDiast($consulta, $paciente)
    {
        $edad = (new DateTime())->diff(new DateTime($paciente->fecha_nacimiento))->y;
        $ta_diast = $consulta->ta_diast;
        $msg_baja = "T.A. Diastólica Baja";
        $msg_alta = "T.A. Diastólica Alta";

        if ($edad <= 29) {
            return AlertaController::getAlerta($ta_diast, 60, 84, $msg_baja, $msg_alta);
        } elseif ($edad >= 30 && $edad <= 39) {
            return AlertaController::getAlerta($ta_diast, 60, 89, $msg_baja, $msg_alta);
        } elseif ($edad >= 40 && $edad <= 59) {
            return AlertaController::getAlerta($ta_diast, 70, 89, $msg_baja, $msg_alta);
        } elseif ($edad >= 60) {
            return AlertaController::getAlerta($ta_diast, 70, 90, $msg_baja, $msg_alta);
        }
        return null;
    }

    static function intervalTensionDiast($consulta, $paciente)
    {
        $edad = (new DateTime($consulta->created_at))->diff(new DateTime($paciente->fecha_nacimiento))->y;
        if ($edad <= 29) {
            return [60, 84];
        } elseif ($edad >= 30 && $edad <= 39) {
            return [60, 89];
        } elseif ($edad >= 40 && $edad <= 59) {
            return [70, 89];
        } elseif ($edad >= 60) {
            return [70, 90];
        }
    }

    static function getAlertas($consulta)
    {
        $paciente = Paciente::find($consulta->paciente);

        $status = [
            'glucosa' => self::alertGlucosa($consulta),
            'imc' => self::alertIMC($consulta, $paciente),
            'icc' => self::alertICC($consulta, $paciente),
            'ta_sist' => self::alertTensionSist($consulta, $paciente),
            'ta_diast' => self::alertTensionDiast($consulta, $paciente),
        ];

        foreach ($status as $key => $item) {
            if ($item !== null) {
                $consulta->alerta()
                    ->firstOrCreate([
                        'mensaje' => $item,
                        'tipo' => $key,
                    ]);
            } else {
                $consulta->alerta()->where('tipo', $key)->delete();
            }
        }
    }

    public function getAlertasSesion($sesion)
    {
        return Excel::download(new AlertasExport($sesion), "alertas_$sesion.xlsx");
    }
}
