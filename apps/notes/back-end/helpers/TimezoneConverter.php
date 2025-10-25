<?php
// En /helpers/TimezoneConverter.php

class TimezoneConverter {
    public static function processDateFilters(array $data): array {
        if (!isset($data['user_timezone']) || empty($data['user_timezone'])) {
            return $data;
        }

        $userTimezone = new DateTimeZone($data['user_timezone']);
        $utcTimezone = new DateTimeZone('UTC');

        // Escenario 1: Rango de fechas explícito (sin cambios)
        if (isset($data['date_range_start']) && !empty($data['date_range_start'])) {
            $localStart = new DateTime($data['date_range_start'], $userTimezone);
            $localEnd = new DateTime($data['date_range_end'], $userTimezone);
            
            $data['date_range_start'] = $localStart->setTimezone($utcTimezone)->format('Y-m-d H:i:s');
            $data['date_range_end'] = $localEnd->setTimezone($utcTimezone)->format('Y-m-d H:i:s');
        } 
        // Escenario 2: Filtros de año y/o mes
        else if (isset($data['filter_year']) && !empty($data['filter_year'])) {
            $years = array_filter(array_map('trim', explode(',', $data['filter_year'])));
            $months = isset($data['filter_month']) && !empty($data['filter_month']) 
                      ? array_filter(array_map('trim', explode(',', $data['filter_month']))) 
                      : range(1, 12);

            $overallStart = null;
            $overallEnd = null;

            foreach ($years as $year) {
                foreach ($months as $month) {
                    try {
                        $localStart = new DateTime("{$year}-{$month}-01 00:00:00", $userTimezone);
                        $localEnd = clone $localStart;
                        $localEnd->modify('+1 month');

                        $utcStart = $localStart->setTimezone($utcTimezone);
                        $utcEnd = $localEnd->setTimezone($utcTimezone);

                        if ($overallStart === null || $utcStart < $overallStart) {
                            $overallStart = clone $utcStart;
                        }
                        if ($overallEnd === null || $utcEnd > $overallEnd) {
                            $overallEnd = clone $utcEnd;
                        }
                    } catch (Exception $e) {
                        continue;
                    }
                }
            }

            if ($overallStart && $overallEnd) {
                $data['date_range_start'] = $overallStart->format('Y-m-d H:i:s');
                $data['date_range_end'] = $overallEnd->format('Y-m-d H:i:s');
            }

            // Limpiamos los filtros originales
            unset($data['filter_year'], $data['filter_month']);
        }

        return $data;
    }

    /**
     * Convierte fecha y hora a UTC
     * 
     * @param string $dateOrDateTime Fecha en formato Y-m-d o datetime completo en formato Y-m-d H:i:s
     * @param string|null $time Hora en formato H:i:s o H:i (opcional si $dateOrDateTime ya incluye hora)
     * @param string $userTimezone Zona horaria del usuario
     * @return string Datetime en UTC en formato Y-m-d H:i:s
     */
    public static function convertDateTimeToUtc(string $dateOrDateTime, ?string $time = null, string $userTimezone = ''): string {
        try {
            // Si no se proporciona time, asumimos que dateOrDateTime ya incluye la hora
            if ($time === null) {
                $datetime_string = $dateOrDateTime;
            } else {
                $datetime_string = $dateOrDateTime . " " . $time;
            }
            
            $appt_datetime_local = new DateTime($datetime_string, new DateTimeZone($userTimezone));
            $appt_datetime_utc = clone $appt_datetime_local;
            $appt_datetime_utc->setTimezone(new DateTimeZone("UTC"));
            
            return $appt_datetime_utc->format("Y-m-d H:i:s");
        } catch (Exception $e) {
            throw new Exception("Error al convertir fecha y hora a UTC: " . $e->getMessage());
        }
    }
}