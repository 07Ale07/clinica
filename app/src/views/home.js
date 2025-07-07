import React from 'react';
import { View, Text, Button, StyleSheet } from 'react-native';

export default function Home({ navigation }) {
  return (
    <View style={styles.container}>
      <Button title="Sacar Turno" onPress={() => navigation.navigate('SacarTurno')} />
      <View style={{ marginTop: 20 }} />
      <Button title="Consultar Turnos Pendientes" onPress={() => navigation.navigate('ConsultarTurno')} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#c2c2c2',
    alignItems: 'center',
    justifyContent: 'center',
    padding: 20,
  },
  title: {
    fontSize: 24,
    marginBottom: 30,
  },
});
