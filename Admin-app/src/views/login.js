import React, { useState } from 'react';
import { View, Text, TextInput, Button, Alert, StyleSheet } from 'react-native';
import { validarLogin } from '../logic/validar_login';

export default function Login({ navigation }) {
  const [usuario, setUsuario] = useState('');
  const [clave, setClave] = useState('');

  const iniciarSesion = async () => {
    const resultado = await validarLogin(usuario, clave);
    if (resultado.success) {
      Alert.alert('Éxito', `Bienvenido, ${resultado.nombre}`);
      // navigation.navigate('Home'); // Agregalo cuando tengas una vista principal
    } else {
      Alert.alert('Error', resultado.error || 'Usuario o clave incorrectos');
    }
  };

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Ingreso de Odontólogo</Text>
      <TextInput
        style={styles.input}
        placeholder="Usuario"
        value={usuario}
        onChangeText={setUsuario}
      />
      <TextInput
        style={styles.input}
        placeholder="Contraseña"
        secureTextEntry
        value={clave}
        onChangeText={setClave}
      />
      <Button title="Ingresar" onPress={iniciarSesion} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#dfe6e9',
    justifyContent: 'center',
    padding: 20,
  },
  title: {
    fontSize: 22,
    marginBottom: 20,
    textAlign: 'center',
  },
  input: {
    backgroundColor: '#fff',
    padding: 12,
    marginBottom: 15,
    borderRadius: 8,
  },
});
