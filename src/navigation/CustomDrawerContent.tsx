import React, { useEffect } from 'react';
import { View, TouchableOpacity, StyleSheet, Text } from 'react-native';
import { DrawerContentScrollView } from '@react-navigation/drawer';
import { useNavigation } from '@react-navigation/native';
import { StackNavigationProp } from '@react-navigation/stack';
import { Ionicons } from '@expo/vector-icons';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { LinearGradient } from 'expo-linear-gradient';
import { RootStackParamList } from './types';

type DrawerNavigationProp = StackNavigationProp<RootStackParamList>;

const CustomDrawerContent: React.FC<any> = (props) => {
  const navigation = useNavigation<DrawerNavigationProp>();

  useEffect(() => {
    const checkUserSession = async () => {
      try {
        const id_usuario = await AsyncStorage.getItem('id_usuario');
        if (!id_usuario || id_usuario === 'null') {
          console.warn('No se encontró id_usuario en AsyncStorage, redirigiendo a Login');
          navigation.navigate('Login');
        }
      } catch (error: any) {
        console.error('Error checking user session:', error.message || error);
        navigation.navigate('Login');
      }
    };
    checkUserSession();
  }, [navigation]);

  const handleLogout = async () => {
    try {
      await AsyncStorage.multiRemove(['id_usuario', 'username', 'fullName', 'jobTitle']);
      console.log('Datos eliminados de AsyncStorage, redirigiendo a Login');
      navigation.navigate('Login');
    } catch (error) {
      console.error('Error during logout:', error);
    }
  };

  return (
    <DrawerContentScrollView {...props} contentContainerStyle={styles.drawerContainer}>
      <View style={styles.menuItems}>
        <TouchableOpacity style={styles.logoutButton} onPress={handleLogout}>
          <LinearGradient colors={['#E63946', '#FF6B6B']} style={styles.logoutButtonGradient}>
            <Ionicons name="log-out-outline" size={24} color="#FFFFFF" style={styles.logoutIcon} />
            <Text style={styles.logoutButtonText}>Cerrar Sesión</Text>
          </LinearGradient>
        </TouchableOpacity>
      </View>
    </DrawerContentScrollView>
  );
};

const styles = StyleSheet.create({
  drawerContainer: {
    flex: 1,
    backgroundColor: '#F7FAFD',
  },
  menuItems: {
    padding: 20,
  },
  logoutButton: {
    borderRadius: 10,
    overflow: 'hidden',
    marginTop: 20,
  },
  logoutButtonGradient: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 12,
    paddingHorizontal: 20,
  },
  logoutIcon: {
    marginRight: 10,
  },
  logoutButtonText: {
    fontSize: 16,
    fontWeight: '600',
    color: '#FFFFFF',
  },
});

export default CustomDrawerContent;