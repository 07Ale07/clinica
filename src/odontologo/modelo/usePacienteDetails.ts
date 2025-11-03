// modelo/usePacienteDetails.ts
import { useState, useEffect } from 'react';
import { apiService } from '../../services/api';
import { Paciente, Familiar, CitaAnterior } from './PacienteModel';
import { Turno } from './turnoModel';

type UsePacienteDetailsParams = {
  id_paciente: number;
  // Opcional: datos del turno actual (solo si viene desde turnos)
  turnoActual?: Pick<Turno, 'hora_inicio' | 'tipo' | 'estado' | 'nombre_paciente'>;
};

export const usePacienteDetails = ({ id_paciente, turnoActual }: UsePacienteDetailsParams) => {
  const [paciente, setPaciente] = useState<Paciente | null>(null);
  const [familiares, setFamiliares] = useState<Familiar[]>([]);
  const [citasAnteriores, setCitasAnteriores] = useState<CitaAnterior[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchDetails = async () => {
      if (!id_paciente) {
        setError('ID de paciente no válido');
        setLoading(false);
        return;
      }

      setLoading(true);
      try {
        const [pacRes, famRes, citRes] = await Promise.all([
          apiService.get<Paciente>(`/pacientes/paciente/${id_paciente}/detalles`),
          apiService.get<Familiar[]>(`/pacientes/paciente/${id_paciente}/familiares`),
          apiService.get<CitaAnterior[]>(`/pacientes/paciente/${id_paciente}/citas-anteriores`),
        ]);

        setPaciente(pacRes.data);
        setFamiliares(famRes.data);
        setCitasAnteriores(citRes.data);
      } catch (err: any) {
        setError(`Error al cargar datos: ${err.message}`);
        console.error('Error en usePacienteDetails:', err.response?.data || err);
      } finally {
        setLoading(false);
      }
    };

    fetchDetails();
  }, [id_paciente]);

  return { paciente, familiares, citasAnteriores, loading, error, turnoActual };
};