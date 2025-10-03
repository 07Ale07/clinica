import React, { useState } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert, Platform, TouchableOpacity } from 'react-native';
import DateTimePicker from '@react-native-community/datetimepicker';
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
    const [fechaNac, setFechaNac] = useState<Date | null>(null);
    const [showDatePicker, setShowDatePicker] = useState(false);
    const [error, setError] = useState('');

    const formatDate = (date: Date | null): string => {
        if (!date) return '';
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    };

    const formatToISO = (date: Date | null): string => {
        if (!date) return '';
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const handleDateChange = (event: any, selectedDate?: Date) => {
        const currentDate = selectedDate || fechaNac;
        setShowDatePicker(Platform.OS === 'ios');
        if (selectedDate) {
            setFechaNac(currentDate);
        }
    };

    const handleSubmit = async () => {
        if (!nombre || !apellido || !fechaNac) {
            setError('Todos los campos son requeridos');
            return;
        }
        const hoy = new Date();
        if (fechaNac > hoy) {
            setError('La fecha de nacimiento no puede ser futura');
            return;
        }
        if ((hoy.getFullYear() - fechaNac.getFullYear()) > 120) {
            setError('La fecha de nacimiento no parece válida');
            return;
        }
        try {
            const paciente: Paciente = { nombre, apellido, fecha_nac: formatToISO(fechaNac), dni: dniInicial };
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
            <TouchableOpacity
                style={globalStyles.input}
                onPress={() => setShowDatePicker(true)}
            >
                <Text style={fechaNac ? globalStyles.inputText : globalStyles.placeholderText}>
                    {fechaNac ? formatDate(fechaNac) : 'Fecha de Nacimiento (DD/MM/YYYY)'}
                </Text>
            </TouchableOpacity>
            {showDatePicker && (
                <DateTimePicker
                    value={fechaNac || new Date()}
                    mode="date"
                    display="default"
                    onChange={handleDateChange}
                    maximumDate={new Date()}
                />
            )}
            <TextInput style={globalStyles.input} placeholder="DNI" value={dniInicial} editable={false} />
            {error && <Text style={globalStyles.error}>{error}</Text>}
            <Button title="Registrarse y Continuar" onPress={handleSubmit} />
        </View>
    );
};

const styles = StyleSheet.create({
    placeholderText: {
        color: '#999',
    },
    inputText: {
        color: '#000',
    },
});

export default RegistroPaciente;
