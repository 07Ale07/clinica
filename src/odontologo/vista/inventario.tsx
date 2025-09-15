import React, { useState } from 'react';
import { View, Text, StyleSheet, FlatList, TouchableOpacity, TextInput } from 'react-native';

interface InventoryItem {
  id: string;
  name: string;
  quantity: number;
  category: string;
}

const mockInventory: InventoryItem[] = [
  { id: '1', name: 'Anestesia Lidocaína', quantity: 50, category: 'Medicamentos' },
  { id: '2', name: 'Fresas Dentales', quantity: 20, category: 'Herramientas' },
  { id: '3', name: 'Guantes Desechables', quantity: 200, category: 'Consumibles' },
];

const Inventario: React.FC = () => {
  const [search, setSearch] = useState('');

  const filteredInventory = mockInventory.filter((item) =>
    item.name.toLowerCase().includes(search.toLowerCase())
  );

  const renderItem = ({ item }: { item: InventoryItem }) => (
    <View style={styles.item}>
      <Text style={styles.itemText}>{item.name}</Text>
      <Text style={styles.itemSubText}>Categoría: {item.category}</Text>
      <Text style={styles.itemSubText}>Cantidad: {item.quantity}</Text>
      <TouchableOpacity style={styles.updateButton}>
        <Text style={styles.updateButtonText}>Actualizar</Text>
      </TouchableOpacity>
    </View>
  );

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Inventario</Text>
      <Text style={styles.subtitle}>Controla los medicamentos y herramientas disponibles</Text>
      <TextInput
        style={styles.searchInput}
        placeholder="Buscar en inventario..."
        value={search}
        onChangeText={setSearch}
      />
      <FlatList
        data={filteredInventory}
        renderItem={renderItem}
        keyExtractor={(item) => item.id}
        contentContainerStyle={styles.list}
      />
      <TouchableOpacity style={styles.addButton}>
        <Text style={styles.addButtonText}>+ Agregar Item</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 10,
  },
  subtitle: {
    fontSize: 18,
    color: '#666',
    marginBottom: 20,
  },
  searchInput: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 10,
    fontSize: 16,
    marginBottom: 20,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  list: {
    paddingBottom: 20,
  },
  item: {
    backgroundColor: '#fff',
    borderRadius: 10,
    padding: 15,
    marginBottom: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 5,
    elevation: 3,
  },
  itemText: {
    fontSize: 16,
    fontWeight: '600',
    color: '#333',
  },
  itemSubText: {
    fontSize: 14,
    color: '#666',
    marginVertical: 5,
  },
  updateButton: {
    backgroundColor: '#007bff',
    borderRadius: 5,
    padding: 8,
    alignSelf: 'flex-end',
  },
  updateButtonText: {
    color: '#fff',
    fontSize: 14,
  },
  addButton: {
    backgroundColor: '#28a745',
    borderRadius: 10,
    padding: 15,
    alignItems: 'center',
    marginTop: 10,
  },
  addButtonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});

export default Inventario;