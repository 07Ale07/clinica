import React, { useState } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert } from 'react-native';
import { registrarPaciente } from '../controlador/SacarTurnoController';
import { Paciente } from '../modelo/Paciente';
import { globalStyles } from '../css/styles';

interface Props {
    dniInicial: string;
    onRegistroCompletado: (paciente: Paciente) => void;
}

const RegistroPaciente: React.FC<Props> = ({ dniInicial, onRegistroCompletado }) => {
    const [nombre, setNombre] = useState('');
    const [apellido, setApellido] = useState('');
    const [fechaNac, setFechaNac] = useState('');
    const [error, setError] = useState('');

    const handleSubmit = async () => {
        if (!nombre || !apellido || !fechaNac) {
            setError('Todos los campos son requeridos');
            return;
        }
        const fechaNacDate = new Date(fechaNac);
        const hoy = new Date();
        if (fechaNacDate > hoy) {
            setError('La fecha de nacimiento no puede ser futura');
            return;
        }
        if ((hoy.getFullYear() - fechaNacDate.getFullYear()) > 120) {
            setError('La fecha de nacimiento no parece válida');
            return;
        }
        try {
            const paciente: Paciente = { nombre, apellido, fecha_nac: fechaNac, dni: dniInicial };
            const registrado = await registrarPaciente(paciente);
            onRegistroCompletado(registrado);
        } catch (err: any) {
            setError(err.message || 'Error al registrar');
        }
    };

    return (
        <View style={globalStyles.container}>
            <Text style={globalStyles.title}>Registro de Paciente</Text>
            <TextInput style={globalStyles.input} placeholder="Nombre" value={nombre} onChangeText={setNombre} />
            <TextInput style={globalStyles.input} placeholder="Apellido" value={apellido} onChangeText={setApellido} />
            <TextInput style={globalStyles.input} placeholder="Fecha de Nacimiento (YYYY-MM-DD)" value={fechaNac} onChangeText={setFechaNac} />
            <TextInput style={globalStyles.input} placeholder="DNI" value={dniInicial} editable={false} />
            {error && <Text style={globalStyles.error}>{error}</Text>}
            <Button title="Registrarse y Continuar" onPress={handleSubmit} />
        </View>
    );
};

export default RegistroPaciente;