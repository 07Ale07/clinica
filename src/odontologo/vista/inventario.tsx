import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, FlatList, TextInput, ActivityIndicator, Alert } from 'react-native';
import { InventarioControl } from '../controlador/inventario_controlador';
import { InventoryItem } from '../modelo/inventario_modelo';
import { Feather } from '@expo/vector-icons';
import { styles } from '../css/inventarioStyles';
import CustomHeader from '../../navigation/CustomHeader';
import { SafeAreaView } from 'react-native-safe-area-context';

const Inventario: React.FC = () => {
  const [inventory, setInventory] = useState<InventoryItem[]>([]);
  const [filteredInventory, setFilteredInventory] = useState<InventoryItem[]>([]);
  const [search, setSearch] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const loadInventory = async () => {
      setIsLoading(true);
      setError(null);
      try {
        const data = await InventarioControl.fetchInventario();
        setInventory(data);
        setFilteredInventory(data);
      } catch (err) {
        setError(err instanceof Error ? err.message : 'Error desconocido al cargar el inventario.');
        Alert.alert('Error', error || 'Error al cargar');
      } finally {
        setIsLoading(false);
      }
    };

    loadInventory();
  }, []);

  useEffect(() => {
    const filtered = inventory.filter((item) =>
      item.nombre.toLowerCase().includes(search.toLowerCase()) ||
      item.descripcion.toLowerCase().includes(search.toLowerCase())
    );
    setFilteredInventory(filtered);
  }, [search, inventory]);

  const formatDate = (dateString: string) => {
    const date = new Date(dateString);
    return date.toLocaleString('es-ES', { dateStyle: 'medium', timeStyle: 'short' });
  };

  const renderItem = ({ item }: { item: InventoryItem }) => (
    <View style={styles.item}>
      <Text style={styles.itemText}>{item.nombre}</Text>
      <Text style={styles.itemSubText}>Categoría: {item.category}</Text>
      <Text style={styles.itemSubText}>Cantidad: {item.quantity}</Text>
      <Text style={styles.itemSubText}>Descripción: {item.descripcion}</Text>
      <Text style={styles.itemSubText}>Última actualización: {formatDate(item.fecha_actualizacion)}</Text>
    </View>
  );

  return (
    <SafeAreaView style={styles.safeAreaContainer}>
      <CustomHeader title="Inventario" showBackButton={true} showMenuButton={true} />
      <View style={styles.container}>
        {isLoading ? (
          <ActivityIndicator size="large" color="#4B9CDB" />
        ) : error ? (
          <Text style={styles.errorText}>{error}</Text>
        ) : (
          <>
            <View style={styles.searchContainer}>
              <Feather name="search" size={24} color="#4B9CDB" style={styles.searchIcon} />
              <TextInput
                style={styles.searchInput}
                placeholder="Buscar por nombre o descripción..."
                placeholderTextColor="#8A8F9E"
                value={search}
                onChangeText={setSearch}
              />
            </View>
            <FlatList
              data={filteredInventory}
              renderItem={renderItem}
              keyExtractor={(item) => item.id.toString()}
              contentContainerStyle={styles.list}
              ListEmptyComponent={<Text style={styles.noItemsText}>No hay items en el inventario.</Text>}
            />
          </>
        )}
      </View>
    </SafeAreaView>
  );
};

export default Inventario;
