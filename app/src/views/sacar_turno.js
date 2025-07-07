import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

export default function SacarTurno() {
  return (
    <View style={styles.container}>
      <Text style={styles.text}>Pantalla para sacar un turno</Text>
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
