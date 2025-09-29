import React, { useState } from 'react';
import { View } from 'react-native';
import VerificarPaciente from './VerificarPaciente';
import RegistroPaciente from './RegistroPaciente';
import SeleccionOdontologo from './SeleccionOdontologo';
import ConfirmacionTurno from './ConfirmacionTurno';
import { Paciente, Turno } from '../modelo/Paciente';
import { globalStyles } from '../css/styles';

const SacarTurnoMain: React.FC = () => {
    const [step, setStep] = useState<'verificar' | 'registro' | 'seleccion' | 'confirmacion'>('verificar');
    const [paciente, setPaciente] = useState<Paciente | null>(null);
    const [dniInicial, setDniInicial] = useState('');
    const [turnoConfirmado, setTurnoConfirmado] = useState<Turno | null>(null);

    const handlePacienteVerificado = (pac: Paciente | null, dni: string) => {
        setPaciente(pac);
        setDniInicial(dni);
        setStep(pac ? 'seleccion' : 'registro');
    };

    const handleRegistroCompletado = (pac: Paciente) => {
        setPaciente(pac);
        setStep('seleccion');
    };

    const handleTurnoConfirmado = (turno: Turno) => {
        setTurnoConfirmado(turno);
        setStep('confirmacion');
    };

    const handleVolver = () => {
        setStep('verificar');
        setPaciente(null);
        setTurnoConfirmado(null);
    };

    return (
        <View style={globalStyles.container}>
            {step === 'verificar' && (
                <VerificarPaciente onPacienteVerificado={handlePacienteVerificado} />
            )}
            {step === 'registro' && (
                <RegistroPaciente dniInicial={dniInicial} onRegistroCompletado={handleRegistroCompletado} />
            )}
            {step === 'seleccion' && paciente && (
                <SeleccionOdontologo paciente={paciente} onTurnoConfirmado={handleTurnoConfirmado} />
            )}
            {step === 'confirmacion' && turnoConfirmado && (
                <ConfirmacionTurno turno={turnoConfirmado} onVolver={handleVolver} />
            )}
        </View>
    );
};

export default SacarTurnoMain;