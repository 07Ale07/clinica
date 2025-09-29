import React, { useState, useEffect } from 'react';
import { View, Text, TextInput, Button, Alert } from 'react-native';
import { Picker } from '@react-native-picker/picker';
import { obtenerOdontologos, obtenerHorariosDisponibles, confirmarTurno } from '../controlador/SacarTurnoController';
import { Odontologo, Turno, Paciente } from '../modelo/Paciente';
import { globalStyles } from '../css/styles';

interface Props {
    paciente: Paciente;
    onTurnoConfirmado: (turno: Turno) => void;
}

const SeleccionOdontologo: React.FC<Props> = ({ paciente, onTurnoConfirmado }) => {
    const [odontologos, setOdontologos] = useState<Odontologo[]>([]);
    const [idOdontologo, setIdOdontologo] = useState<number | null>(null);
    const [fecha, setFecha] = useState('');
    const [hora, setHora] = useState('');
    const [horarios, setHorarios] = useState<string[]>([]);
    const [email, setEmail] = useState('');
    const [error, setError] = useState('');

    useEffect(() => {
        async function fetchOdontologos() {
            try {
                const lista = await obtenerOdontologos();
                setOdontologos(lista);
            } catch (err) {
                setError('Error al cargar odontólogos');
            }
        }
        fetchOdontologos();
    }, []);

    useEffect(() => {
        if (idOdontologo !== null && fecha) {
            async function fetchHorarios() {
                try {
                    const lista = await obtenerHorariosDisponibles(idOdontologo, fecha);
                    setHorarios(lista);
                    setHora('');
                } catch (err) {
                    setError('Error al cargar horarios');
                }
            }
            fetchHorarios();
        }
    }, [idOdontologo, fecha]);

    const validateForm = (): boolean => {
        if (!idOdontologo) {
            Alert.alert('Error', 'Seleccione un odontólogo');
            return false;
        }
        if (!fecha) {
            Alert.alert('Error', 'Seleccione una fecha');
            return false;
        }
        const fechaObj = new Date(fecha);
        if (fechaObj.getDay() === 0 || fechaObj.getDay() === 6) {
            Alert.alert('Error', 'No se pueden agendar turnos los fines de semana.');
            return false;
        }
        if (new Date(fecha) < new Date()) {
            Alert.alert('Error', 'La fecha no puede ser pasada');
            return false;
        }
        if (!hora) {
            Alert.alert('Error', 'Seleccione una hora');
            return false;
        }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            Alert.alert('Error', 'Correo electrónico inválido');
            return false;
        }
        return true;
    };

    const handleSubmit = async () => {
        if (!validateForm()) return;
        try {
            setError('');
            if (idOdontologo === null) {
                throw new Error('Odontólogo no seleccionado');
            }
            const turno: Turno = { id_odontologo: idOdontologo, fecha, hora, email };
            const confirmado = await confirmarTurno(paciente.id_persona!, turno);
            onTurnoConfirmado(confirmado);
        } catch (err: any) {
            setError(err.message || 'Error al confirmar turno');
        }
    };

    return (
        <View style={globalStyles.container}>
            <Text style={globalStyles.title}>Seleccionar Odontólogo</Text>
            <Picker
                selectedValue={idOdontologo}
                onValueChange={(value) => setIdOdontologo(value as number | null)}
                style={globalStyles.input}
            >
                <Picker.Item label="Seleccione un odontólogo..." value={null} />
                {odontologos.map((odo) => (
                    <Picker.Item key={odo.id_persona} label={`${odo.nombre} ${odo.apellido}`} value={odo.id_persona} />
                ))}
            </Picker>
            <TextInput
                style={globalStyles.input}
                placeholder="Fecha (YYYY-MM-DD)"
                value={fecha}
                onChangeText={setFecha}
            />
            <Picker
                selectedValue={hora}
                onValueChange={(value) => setHora(value as string)}
                style={globalStyles.input}
                enabled={horarios.length > 0}
            >
                <Picker.Item label="Seleccione una hora..." value="" />
                {horarios.map((h) => (
                    <Picker.Item key={h} label={h} value={h} />
                ))}
            </Picker>
            <TextInput
                style={globalStyles.input}
                placeholder="Email (opcional)"
                value={email}
                onChangeText={setEmail}
                keyboardType="email-address"
            />
            {error && <Text style={globalStyles.error}>{error}</Text>}
            <Button title="Confirmar Turno" onPress={handleSubmit} />
        </View>
    );
};

export default SeleccionOdontologo;