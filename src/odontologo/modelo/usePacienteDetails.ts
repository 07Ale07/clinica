// odontologo/modelo/hooks/usePacienteDetails.ts
import { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../../services/api'; // Importa desde services
import { Paciente, Familiar, CitaAnterior } from './PacienteModel';
import { Turno } from './turnoModel';

export const usePacienteDetails = (turno: Turno) => {
  const [paciente, setPaciente] = useState<Paciente | null>(null);
  const [familiares, setFamiliares] = useState<Familiar[]>([]);
  const [citasAnteriores, setCitasAnteriores] = useState<CitaAnterior[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchDetails = async () => {
      if (!turno.id_paciente) {
        setError('ID de paciente no disponible');
        setLoading(false);
        return;
      }
      setLoading(true);
      try {
        const [pacRes, famRes, citRes] = await Promise.all([
          axios.get<Paciente>(`${API_BASE_URL}/paciente/${turno.id_paciente}/detalles`),
          axios.get<Familiar[]>(`${API_BASE_URL}/paciente/${turno.id_paciente}/familiares`),
          axios.get<CitaAnterior[]>(`${API_BASE_URL}/paciente/${turno.id_paciente}/citas-anteriores`),
        ]);
        setPaciente(pacRes.data);
        setFamiliares(famRes.data);
        setCitasAnteriores(citRes.data);
      } catch (err) {
        setError('Error al cargar los detalles del paciente');
        console.error('Error en fetchDetails:', err);
      } finally {
        setLoading(false);
      }
    };
    fetchDetails();
  }, [turno.id_paciente]);

  return { paciente, familiares, citasAnteriores, loading, error };
};