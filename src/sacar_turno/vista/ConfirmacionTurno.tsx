import React from 'react';
import { View, Text, Button, StyleSheet } from 'react-native';
import { Turno } from '../modelo/Paciente';
import { globalStyles } from '../css/styles';

interface Props {
    turno: Turno;
    onVolver: () => void;
}

const ConfirmacionTurno: React.FC<Props> = ({ turno, onVolver }) => {
    return (
        <View style={globalStyles.container}>
            <Text style={globalStyles.title}>Turno Confirmado</Text>
            <Text>¡Su turno ha sido registrado exitosamente!</Text>
            <Text>Fecha: {turno.fecha}</Text>
            <Text>Hora: {turno.hora}</Text>
            {turno.email && <Text>Se enviará una confirmación a: {turno.email}</Text>}
            <Button title="Volver al inicio" onPress={onVolver} />
        </View>
    );
};

export default ConfirmacionTurno;