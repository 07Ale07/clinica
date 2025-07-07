import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

export default function ConsultarTurno() {
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Pantalla para consultar turnos pendientes</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#e0e0e0',
    alignItems: 'center',
    justifyContent: 'center',
  },
  text: {
    fontSize: 18,
  },
});
