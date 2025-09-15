import React, { useState } from 'react';
import { View, TextInput, TouchableOpacity } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { styles } from '../../css/TurnoStyles';

interface Props {
  onBuscar: (termino: string) => void;
}

const BuscadorPacientes: React.FC<Props> = ({ onBuscar }) => {
  const [termino, setTermino] = useState('');

  const handleBuscar = () => {
    onBuscar(termino);
  };

  const handleLimpiar = () => {
    setTermino('');
    onBuscar('');
  };

  return (
    <View style={styles.searchContainer}>
      <TextInput
        style={styles.searchInput}
        value={termino}
        onChangeText={setTermino}
        placeholder="Buscar por nombre o apellido"
        onSubmitEditing={handleBuscar}
      />
      {termino ? (
        <TouchableOpacity onPress={handleLimpiar} style={styles.searchIcon}>
          <Ionicons name="close-circle" size={24} color="#999" />
        </TouchableOpacity>
      ) : (
        <TouchableOpacity onPress={handleBuscar} style={styles.searchIcon}>
          <Ionicons name="search" size={24} color="#999" />
        </TouchableOpacity>
      )}
    </View>
  );
};

export default BuscadorPacientes;