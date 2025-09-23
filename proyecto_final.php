<?php

declare(strict_types=1);

class Estudiante {
    public int $id;
    public string $nombre;
    public int $edad;
    public string $carrera;
    public array $materias = [];

    public function __construct(int $id, string $nombre, int $edad, string $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
    }

    public function agregarMateria(string $materia, float $calificacion): void {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio(): float {
        if (empty($this->materias)) {
            return 0.0;
        }
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'promedio' => $this->obtenerPromedio(),
            'materias' => $this->materias
        ];
    }
    
    public function __toString(): string {
        return "ID: {$this->id}, Nombre: {$this->nombre}, Edad: {$this->edad}, Carrera: {$this->carrera}, Promedio: {$this->obtenerPromedio()}";
    }
}

class SistemaGestionEstudiantes {
    private array $estudiantes = [];
    private array $graduados = [];

    public function agregarEstudiante(Estudiante $estudiante): void {
        $this->estudiantes[$estudiante->id] = $estudiante;
    }

    public function obtenerEstudiante(int $id): ?Estudiante {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes(): array {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral(): float {
        if (empty($this->estudiantes)) {
            return 0.0;
        }
        $promedios = array_map(fn($estudiante) => $estudiante->obtenerPromedio(), $this->estudiantes);
        return array_sum($promedios) / count($promedios);
    }

    public function obtenerEstudiantesPorCarrera(string $carrera): array {
        return array_filter($this->estudiantes, fn($estudiante) => strtolower($estudiante->carrera) === strtolower($carrera));
    }

    public function obtenerMejorEstudiante(): ?Estudiante {
        if (empty($this->estudiantes)) {
            return null;
        }
        $mejorEstudiante = null;
        $mejorPromedio = -1;
        foreach ($this->estudiantes as $estudiante) {
            $promedio = $estudiante->obtenerPromedio();
            if ($promedio > $mejorPromedio) {
                $mejorPromedio = $promedio;
                $mejorEstudiante = $estudiante;
            }
        }
        return $mejorEstudiante;
    }

    public function generarReporteRendimiento(): array {
        $reporte = [];
        $materias_calificaciones = [];

        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->materias as $materia => $calificacion) {
                if (!isset($materias_calificaciones[$materia])) {
                    $materias_calificaciones[$materia] = [];
                }
                $materias_calificaciones[$materia][] = $calificacion;
            }
        }
        
        foreach ($materias_calificaciones as $materia => $calificaciones) {
            $reporte[$materia] = [
                'promedio' => array_sum($calificaciones) / count($calificaciones),
                'maxima' => max($calificaciones),
                'minima' => min($calificaciones)
            ];
        }

        return $reporte;
    }

    public function graduarEstudiante(int $id): bool {
        if (isset($this->estudiantes[$id])) {
            $estudiante = $this->estudiantes[$id];
            $this->graduados[$id] = $estudiante;
            unset($this->estudiantes[$id]);
            return true;
        }
        return false;
    }

    public function generarRanking(): array {
        $ranking = $this->estudiantes;
        uasort($ranking, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $ranking;
    }

    public function buscarEstudiante(string $query): array {
        return array_filter($this->estudiantes, fn($estudiante) => 
            stripos($estudiante->nombre, $query) !== false || 
            stripos($estudiante->carrera, $query) !== false
        );
    }

    public function generarEstadisticasPorCarrera(): array {
        $estadisticas = [];
        $carreras = array_reduce($this->estudiantes, function($carry, $estudiante) {
            if (!isset($carry[$estudiante->carrera])) {
                $carry[$estudiante->carrera] = [];
            }
            $carry[$estudiante->carrera][] = $estudiante;
            return $carry;
        }, []);

        foreach ($carreras as $carrera => $estudiantes_carrera) {
            $promedios = array_map(fn($e) => $e->obtenerPromedio(), $estudiantes_carrera);
            $mejorEstudiante = null;
            $mejorPromedio = -1;
            foreach ($estudiantes_carrera as $estudiante) {
                if ($estudiante->obtenerPromedio() > $mejorPromedio) {
                    $mejorPromedio = $estudiante->obtenerPromedio();
                    $mejorEstudiante = $estudiante;
                }
            }
            $estadisticas[$carrera] = [
                'numero_estudiantes' => count($estudiantes_carrera),
                'promedio_general' => array_sum($promedios) / count($promedios),
                'mejor_estudiante' => $mejorEstudiante->nombre
            ];
        }
        return $estadisticas;
    }

    public function asignarFlags(): array {
        $reporte_flags = [];
        foreach ($this->estudiantes as $estudiante) {
            $promedio = $estudiante->obtenerPromedio();
            $flags = [];
            if ($promedio >= 4.5) {
                $flags[] = "Honor Roll";
            }
            if ($promedio < 3.0) {
                $flags[] = "En Riesgo Académico";
            }
            if (in_array(true, array_map(fn($c) => $c < 3.0, $estudiante->materias))) {
                $flags[] = "Materia Reprobada";
            }
            $reporte_flags[$estudiante->nombre] = $flags;
        }
        return $reporte_flags;
    }
}

// --- Sección de Prueba ---

// 1. Instanciar el SistemaGestionEstudiantes
$sistema = new SistemaGestionEstudiantes();

// 2. Crear y agregar al menos 10 estudiantes
$estudiante1 = new Estudiante(1, 'Ana Pérez', 20, 'Ingeniería de Software');
$estudiante1->agregarMateria('Matemáticas', 4.8);
$estudiante1->agregarMateria('Programación I', 5.0);
$estudiante1->agregarMateria('Bases de Datos', 4.5);
$sistema->agregarEstudiante($estudiante1);

$estudiante2 = new Estudiante(2, 'Luis Gómez', 21, 'Ingeniería de Software');
$estudiante2->agregarMateria('Matemáticas', 3.5);
$estudiante2->agregarMateria('Programación I', 4.0);
$estudiante2->agregarMateria('Física', 3.8);
$sistema->agregarEstudiante($estudiante2);

$estudiante3 = new Estudiante(3, 'María Losa', 19, 'Diseño Gráfico');
$estudiante3->agregarMateria('Teoría del Color', 5.0);
$estudiante3->agregarMateria('Software de Diseño', 4.9);
$estudiante3->agregarMateria('Fotografía', 4.7);
$sistema->agregarEstudiante($estudiante3);

$estudiante4 = new Estudiante(4, 'Carlos Rivera', 22, 'Medicina');
$estudiante4->agregarMateria('Anatomía', 4.2);
$estudiante4->agregarMateria('Farmacología', 3.9);
$estudiante4->agregarMateria('Biología', 4.0);
$sistema->agregarEstudiante($estudiante4);

$estudiante5 = new Estudiante(5, 'Sofía Vargas', 20, 'Ingeniería de Software');
$estudiante5->agregarMateria('Programación I', 2.8);
$estudiante5->agregarMateria('Bases de Datos', 3.0);
$estudiante5->agregarMateria('Redes', 3.5);
$sistema->agregarEstudiante($estudiante5);

$estudiante6 = new Estudiante(6, 'Javier Soto', 23, 'Arquitectura');
$estudiante6->agregarMateria('Dibujo Técnico', 4.1);
$estudiante6->agregarMateria('Cálculo', 3.7);
$sistema->agregarEstudiante($estudiante6);

$estudiante7 = new Estudiante(7, 'Laura Mesa', 21, 'Diseño Gráfico');
$estudiante7->agregarMateria('Teoría del Color', 4.5);
$estudiante7->agregarMateria('Historia del Arte', 4.2);
$sistema->agregarEstudiante($estudiante7);

$estudiante8 = new Estudiante(8, 'Pedro Rojas', 24, 'Medicina');
$estudiante8->agregarMateria('Farmacología', 5.0);
$estudiante8->agregarMateria('Anatomía', 4.8);
$sistema->agregarEstudiante($estudiante8);

$estudiante9 = new Estudiante(9, 'Diana Castro', 20, 'Ingeniería de Software');
$estudiante9->agregarMateria('Programación I', 4.5);
$estudiante9->agregarMateria('Redes', 4.2);
$sistema->agregarEstudiante($estudiante9);

$estudiante10 = new Estudiante(10, 'Miguel Ochoa', 21, 'Ingeniería Civil');
$estudiante10->agregarMateria('Estructuras', 4.3);
$estudiante10->agregarMateria('Geología', 3.9);
$sistema->agregarEstudiante($estudiante10);


echo "### 1. Listado de Estudiantes\n";
echo "---------------------------------\n";
foreach ($sistema->listarEstudiantes() as $estudiante) {
    echo $estudiante . "\n";
}

echo "\n### 2. Búsqueda de Estudiante por ID (ID 3)\n";
echo "---------------------------------\n";
$estudianteEncontrado = $sistema->obtenerEstudiante(3);
echo $estudianteEncontrado ? "Estudiante encontrado: " . $estudianteEncontrado->nombre : "Estudiante no encontrado.\n";

echo "\n### 3. Promedio General de Todos los Estudiantes\n";
echo "---------------------------------\n";
echo "Promedio general: " . round($sistema->calcularPromedioGeneral(), 2) . "\n";

echo "\n### 4. Estudiantes por Carrera (Ingeniería de Software)\n";
echo "---------------------------------\n";
$ingSoftware = $sistema->obtenerEstudiantesPorCarrera('Ingeniería de Software');
foreach ($ingSoftware as $estudiante) {
    echo $estudiante . "\n";
}

echo "\n### 5. Mejor Estudiante del Sistema\n";
echo "---------------------------------\n";
$mejor = $sistema->obtenerMejorEstudiante();
echo "El mejor estudiante es: " . ($mejor ? $mejor->nombre . " con un promedio de " . $mejor->obtenerPromedio() : "No hay estudiantes.") . "\n";

echo "\n### 6. Reporte de Rendimiento por Materia\n";
echo "---------------------------------\n";
print_r($sistema->generarReporteRendimiento());

echo "\n### 7. Graduar Estudiante (ID 1)\n";
echo "---------------------------------\n";
if ($sistema->graduarEstudiante(1)) {
    echo "Ana Pérez ha sido graduada.\n";
} else {
    echo "No se pudo graduar al estudiante.\n";
}

echo "\n### 8. Ranking de Estudiantes por Promedio\n";
echo "---------------------------------\n";
$ranking = $sistema->generarRanking();
$pos = 1;
foreach ($ranking as $estudiante) {
    echo "Posición {$pos}: " . $estudiante->nombre . " (Promedio: " . round($estudiante->obtenerPromedio(), 2) . ")\n";
    $pos++;
}

echo "\n### 9. Búsqueda de Estudiante (por nombre 'luis' o carrera 'diseño')\n";
echo "---------------------------------\n";
$resultadosBusqueda = $sistema->buscarEstudiante('ing');
foreach ($resultadosBusqueda as $estudiante) {
    echo $estudiante . "\n";
}

echo "\n### 10. Estadísticas por Carrera\n";
echo "---------------------------------\n";
print_r($sistema->generarEstadisticasPorCarrera());

echo "\n### 11. Asignación de Flags a Estudiantes\n";
echo "---------------------------------\n";
print_r($sistema->asignarFlags());
?>

?>