import React, { useState } from 'react';
import { View, Text, TextInput, Button, Alert } from 'react-native';
import { verificarPaciente } from '../controlador/SacarTurnoController';
import { Paciente } from '../modelo/Paciente';
import { globalStyles } from '../css/styles';

interface Props {
    onPacienteVerificado: (paciente: Paciente | null, dni: string) => void;
}

const VerificarPaciente: React.FC<Props> = ({ onPacienteVerificado }) => {
    const [dni, setDni] = useState('');
    const [error, setError] = useState('');

    const handleSubmit = async () => {
        console.log('Botón Continuar presionado, DNI ingresado:', dni);
        if (!/^\d{8,10}$/.test(dni)) {
            console.log('Validación de DNI fallida:', dni);
            Alert.alert('Error', 'El DNI debe contener entre 8 y 10 dígitos numéricos');
            setError('El DNI debe contener entre 8 y 10 dígitos numéricos');
            return;
        }
        try {
            console.log('Llamando a verificarPaciente con DNI:', dni);
            const paciente = await verificarPaciente(dni);
            console.log('Respuesta de verificarPaciente:', paciente);
            onPacienteVerificado(paciente, dni);
        } catch (err: any) {
            console.error('Error en handleSubmit:', err.message || err);
            Alert.alert('Error', err.message || 'Error al verificar paciente');
            setError(err.message || 'Error al verificar paciente');
        }
    };

    return (
        <View style={globalStyles.container}>
            <Text style={globalStyles.title}>Verificar Paciente</Text>
            <TextInput
                style={globalStyles.input}
                placeholder="DNI"
                value={dni}
                onChangeText={setDni}
                keyboardType="numeric"
            />
            {error && <Text style={globalStyles.error}>{error}</Text>}
            <Button title="Continuar" onPress={handleSubmit} />
        </View>
    );
};

export default VerificarPaciente;