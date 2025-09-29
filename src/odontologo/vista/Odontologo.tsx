import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { GestureHandlerRootView } from 'react-native-gesture-handler';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { Ionicons } from '@expo/vector-icons';
import { RootStackParamList } from '../../navigation/types';
import CustomHeader from '../../navigation/CustomHeader';

type OdontoloNavigationProp = StackNavigationProp<RootStackParamList>;

const Odontolo: React.FC = () => {
  const navigation = useNavigation<OdontoloNavigationProp>();

  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      <SafeAreaView style={styles.safeAreaContainer}>
        <CustomHeader title="Odontólogo" showBackButton={false} showMenuButton={true} />
        <View style={styles.container}>
          <View style={styles.panelsContainer}>
            <TouchableOpacity
              style={styles.panel}
              onPress={() => navigation.navigate('Turnos')}
            >
              <Ionicons name="today-outline" size={40} color="#4B9CDB" />
              <Text style={styles.panelText}>Turnos</Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={styles.panel}
              onPress={() => navigation.navigate('Horarios')}
            >
              <Ionicons name="calendar-outline" size={40} color="#4B9CDB" />
              <Text style={styles.panelText}>Horarios</Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={styles.panel}
              onPress={() => navigation.navigate('Historial')}
            >
              <Ionicons name="document-text-outline" size={40} color="#4B9CDB" />
              <Text style={styles.panelText}>Historial</Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={styles.panel}
              onPress={() => navigation.navigate('Inventario')}
            >
              <Ionicons name="cube-outline" size={40} color="#4B9CDB" />
              <Text style={styles.panelText}>Inventario</Text>
            </TouchableOpacity>
          </View>
        </View>
      </SafeAreaView>
    </GestureHandlerRootView>
  );
};

const styles = StyleSheet.create({
  safeAreaContainer: {
    flex: 1,
    backgroundColor: '#F7FAFD',
  },
  container: {
    flex: 1,
    padding: 20,
  },
  panelsContainer: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    justifyContent: 'space-between',
    marginTop: 20,
  },
  panel: {
    width: '48%',
    aspectRatio: 1,
    backgroundColor: '#FFFFFF',
    borderRadius: 15,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: 20,
    shadowColor: '#8A8F9E',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.3,
    shadowRadius: 8,
    elevation: 5,
  },
  panelText: {
    fontSize: 18,
    fontWeight: '600',
    color: '#4B9CDB',
    marginTop: 10,
  },
});

export default Odontolo;