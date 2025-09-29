// odontologo/modelo/hooks/usePacienteDetails.ts
import { useState, useEffect } from 'react';
import axios from 'axios';
import { API_BASE_URL } from '../../services/api';
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
        console.log('Probando /pacientes/paciente/detalles');
        const pacRes = await axios.get<Paciente>(`${API_BASE_URL}/pacientes/paciente/${turno.id_paciente}/detalles`);
        console.log('Respuesta /pacientes/paciente/detalles:', pacRes.data);
        setPaciente(pacRes.data);

        console.log('Probando /pacientes/paciente/familiares');
        const famRes = await axios.get<Familiar[]>(`${API_BASE_URL}/pacientes/paciente/${turno.id_paciente}/familiares`);
        console.log('Respuesta /pacientes/paciente/familiares:', famRes.data);
        setFamiliares(famRes.data);

        console.log('Probando /pacientes/paciente/citas-anteriores');
        const citRes = await axios.get<CitaAnterior[]>(`${API_BASE_URL}/pacientes/paciente/${turno.id_paciente}/citas-anteriores`);
        console.log('Respuesta /pacientes/paciente/citas-anteriores:', citRes.data);
        setCitasAnteriores(citRes.data);
      } catch (err: any) {
        setError(`Error al cargar los detalles del paciente: ${err.message}`);
        console.error('Error en fetchDetails:', err.response?.data || err);
      } finally {
        setLoading(false);
      }
    };
    fetchDetails();
  }, [turno.id_paciente]);

  return { paciente, familiares, citasAnteriores, loading, error };
};